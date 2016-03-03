<?php

namespace Ugosansh\Bundle\Image\ClientBundle\Manager;

use Ugosansh\Component\Image\ImageInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Psr\Log\LoggerInterface;

/**
 * Image entity manager
 */
class ImageManager
{
    /**
     * Client $client
     */
    protected $client;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * __constrct
     *
     * @param Client $client
     * @param string $entityClass
     */
    public function __construct(Client $client = null, $entityClass = '')
    {
        $this->client      = $client;
        $this->logger      = null;
        $this->entityClass = '';

        if ($this->entityClass) {
            $this->setEntityClass($entityClass);
        }
    }

    /**
     * Check if valid response
     *
     * @param Response $response
     *
     * @return boolean
     */
    protected function isValidResponse(Response $response)
    {
        return ($response->getStatusCode() < 200 || $response->getStatusCode() >= 400) ? false : true;
    }

    /**
     * Log
     *
     * @param string $level
     * @param stirng $message
     * @param array  $context
     */
    protected function log($level, $message, array $context = [])
    {
        if ($this->logger) {
            $context = [
                'status' => $context['response']->getStatusCode(),
                'body'   => $context['response']->getBody()
            ];

            if ($level == 'error') {
                $this->logger->error($message, $context);
            } else {
                $this->logger->log($message, $context);
            }
        }
    }

    /**
     * hydrate entity
     *
     * @param array $content
     *
     * @return ImageInterface
     */
    protected function hydrateEntity(array $content)
    {
        $image = $this->createEntity();

        $image
            ->setId($content['id'])
            ->setSource($content['source'])
            ->setTitle($content['title'])
            ->setSlug($content['slug'])
            ->setPath($content['path'])
            ->setMimeType($content['mime_type'])
            ->setExtension($content['extension'])
            ->setWidth(isset($content['width']) ? $content['width'] : null)
            ->setHeight(isset($content['height']) ? $content['height'] : null)
            ->setDateCreate(new \DateTime($content['date_create']))
        ;

        if (!empty($content['date_update'])) {
            $image->setDateUpdate(new \DateTime($content['date_update']));
        }

        foreach ($content['_links'] as $name => $link) {
            $image->addLink($name, $link['href']);
        }

        return $image;       
    }

    /**
     * entityToJson
     *
     * @param ImageInterface $image
     *
     * @return array
     */
    protected function entityToJson(ImageInterface $image)
    {
        $content = [
            'title' => $image->getTitle()
        ];

        if ($image->getFile()) {
            $content['binarySource'] = base64_encode(file_get_contents($image->getFile()->getRealPath()));
        } else {
            $content['binarySource'] = $image->getBinarySource();
        }

        return $content;
    }

    /**
     * Create a new instance
     *
     * @return ImageInterface
     */
    public function createEntity()
    {
        $entityClass = $this->entityClass;

        return new $entityClass();
    }

    /**
     * Find image
     *
     * @param integer $id
     *
     * @return ImageInterface
     */
    public function find($id)
    {
        return $this->getInfo($id);
    }

    /**
     * getInfo
     *
     * @param integer $id
     * @param integer $width
     * @param integer $height
     * @param integer $crop
     *
     * @return array
     */
    public function getInfo($id, $width = null, $height = null, $crop = null)
    {
        $url = '';

        if (!is_null($width)) {
            $url = sprintf('/v1/images/%s-%s-%s-%s.json', $id, $width, $height, $crop);
        } else {
            $url = sprintf('/v1/images/%s', $id);
        }

        $response = $this->client->get($url);

        if (!$this->isValidResponse($response)) {
            $this->log('error', 'Failed to get image info', ['response' => $response]);

            return null;
        }

        return $this->hydrateEntity(json_decode($response->getBody(), true));
    }

    /**
     * Get base64
     *
     * @param integer $id
     * @param integer $width
     * @param integer $height
     * @param integer $crop
     *
     * @return string
     */
    public function getBase64($id, $width = null, $height = null, $crop = null)
    {
        if ($image = $this->getInfo($id, $width, $height, $crop)) {
            $url      = $image->getLink('url');
            $response = $this->client->get($url);

            if ($this->isValidResponse($response)) {
                if ($response->getBody() instanceof \GuzzleHttp\Psr7\Stream) {
                    return base64_encode($response->getBody()->getContents());
                } else {
                    ld(get_class($response->getBody()));die;
                }
            } else {
                $this->log('error', 'Failed to get image info', ['response' => $response]);
            }

        }

        return null;
    }

    /**
     * save
     *
     * @param ImageInterface $image
     *
     * @return mixed array|boolean
     */
    public function save(ImageInterface $image)
    {
        $body     = $this->entityToJson($image);
        $response = null;

        if ($image->getId()) {
            $response = $this->client->put(
                sprintf('/v1/images/%s', $image->getId()),
                [
                    'headers'     => ['Content-Type: application/json'],
                    'form_params' => $body
                ]
            );
        } else {
            $response = $this->client->post('/v1/images/',
                [
                    'headers'     => ['Content-Type: application/json'],
                    'form_params' => $body
                ]
            );
        }

        if (!$this->isValidResponse($response)) {

            $this->log('error', sprintf('Failed to save image "%s"', $image->getTitle()), ['response' => $response]);

            return false;
        }

        return $this->hydrateEntity(json_decode($response->getBody(), true));
    }

    /**
     * delete
     *
     * @param ImageInterface $image
     *
     * @return boolean
     */
    public function delete(ImageInterface $image)
    {
        $response = $this->client->delete(sprintf('/v1/images/%s', $image->getId()), ['body' => '{}']);

        if (!$this->isValidResponse($response)) {
            $this->log('error', sprintf('Failed to remove image "%s"', $image->getId(), ['response' => $response]));

            return false;
        }

        return true;
    }

    /**
     * Get url image
     *
     * @param integer $id
     * @param integer $width
     * @param integer $height
     * @param integer $crop
     *
     * @return string
     */
    public function getUrl($id, $width = null, $height = null, $crop = null)
    {
        if ($image = $this->getInfo($id, $width, $height, $crop)) {
            return $image->getLink('url');
        }

        return null;
    }

    /**
     * Generate image url
     *
     * @param integer $id
     * @param integer $width
     * @param integer $height
     * @param integer $crop
     * @param string  $extension
     *
     * @return string
     */
    public function generateUrl($id, $width, $height, $crop, $extension)
    {
        return sprintf(
            '/v1/images/%s-%s-%s-%s.%s',
            $id,
            $width,
            $height,
            $crop,
            $extension
        );
    }

    /**
     * Set client
     *
     * @param Client $client
     *
     * @return ImageManager
     */
    public function setClient(Client $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Set Logger
     *
     * @param LoggerInterface $logger
     *
     * @return ImageManager
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Set entityClass
     *
     * @param string $entityClass
     *
     * @return ImageManager
     */
    public function setEntityClass($entityClass)
    {
        if (!in_array('Ugosansh\Component\Image\ImageInterface', class_implements($entityClass))) {
            throw new \InvalidArgumentException('Image entity class must be implement Ugosansh\Component\Image\ImageInterface');
        }

        $this->entityClass = $entityClass;

        return $this;
    }

}
