<?php

namespace Ugosansh\Bundle\Image\ClientBundle\Entity;

use Ugosansh\Component\Image\ImageInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 */
class Image implements ImageInterface, \JsonSerializable
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $source;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $mimeType;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var integer
     */
    private $width;

    /**
     * @var integer
     */
    private $height;

    /**
     * @var integer
     */
    private $weight;

    /**
     * @var array
     */
    private $metadata;

    /**
     * @var \DateTime
     */
    private $dateCreate;

    /**
     * @var \DateTime
     */
    private $dateUpdate;

    /**
     * @var \DateTime
     */
    private $dateDelete;

    /**
     * @var string
     */
    private $binarySource;

    /**
     * @var string
     */
    private $links;

    /**
     * @var File
     *
     * @Assert\File(maxSize="6000000")
     */
    private $file;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->links = [];
    }

    public function jsonSerialize()
    {
        return [
            'id'         => $this->id,
            'source'     => $this->source,
            'title'      => $this->title,
            'slug'       => $this->slug,
            'mimeType'   => $this->mimeType,
            'extension'  => $this->extension,
            'width'      => $this->width,
            'height'     => $this->height,
            'weight'     => $this->weight,
            'metadata'   => $this->metadata,
            'dateCreate' => $this->dateCreate ? $this->dateCreate->format('d-m-Y H:i:s') : null,
            'dateUpdate' => $this->dateUpdate ? $this->dateUpdate->format('d-m-Y H:i:s') : null,
            'href'       => $this->links['url']
        ];


    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Image
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set source
     *
     * @param string $source
     * @return Image
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string 
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Image
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Image
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return Image
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set mimeType
     *
     * @param string $mimeType
     * @return Image
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * Get mimeType
     *
     * @return string 
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set extension
     *
     * @param string $extension
     * @return Image
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;

        return $this;
    }

    /**
     * Get extension
     *
     * @return string 
     */
    public function getExtension()
    {
        return $this->extension;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return Image
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return Image
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return Image
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set metadata
     *
     * @param array $metadata
     *
     * @return ImageInterface
     */
    public function setMetadata(array $metadata)
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * Get metadata
     *
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Add metadata
     *
     * @param string $name
     * @param string $value
     *
     * @return ImageInterface
     */
    public function addMetadata($name, $value)
    {
        $this->metadata[$name] = $value;
    }

    /**
     * Remove metadata
     *
     * @param string $name
     *
     * @return ImageInterface
     */
    public function removeMetadata($name)
    {
        if (array_key_exists($name, $this->metadata)) {
            unset($this->metadata[$name]);
        }

        return $this;
    }

    /**
     * Set binarySource
     *
     * @param string $binarySource
     *
     * @return Image
     */
    public function setBinarySource($binarySource)
    {
        $this->binarySource = $binarySource;

        return $this;
    }

    /**
     * Get binarySource
     *
     * @return string
     */
    public function getBinarySource()
    {
        return $this->binarySource;
    }


    /**
     * Set dateCreate
     *
     * @param \DateTime $dateCreate
     * @return Image
     */
    public function setDateCreate($dateCreate)
    {
        $this->dateCreate = $dateCreate;

        return $this;
    }

    /**
     * Get dateCreate
     *
     * @return \DateTime 
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     * @return Image
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;

        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime 
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

    /**
     * Set dateDelete
     *
     * @param \DateTime $dateDelete
     * @return Image
     */
    public function setDateDelete($dateDelete)
    {
        $this->dateDelete = $dateDelete;

        return $this;
    }

    /**
     * Get dateDelete
     *
     * @return \DateTime 
     */
    public function getDateDelete()
    {
        return $this->dateDelete;
    }

    /**
     * Add link
     *
     * @param string $name
     * @param string $link
     *
     * @return Image
     */
    public function addLink($name, $link)
    {
        $this->links[$name] = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @param string $name
     *
     * @return string
     */
    public function getLink($name)
    {
        return $this->hasLink($name) ? $this->links[$name] : null;
    }

    /**
     * Has link
     *
     * @param string $name
     *
     * @return boolean
     */
    public function hasLink($name)
    {
        return array_key_exists($name, $this->links);
    }

    /**
     * Set links
     *
     * @param array $links
     *
     * @return Image
     */
    public function setLinks(array $links)
    {
        $this->links = $links;
    }

    /**
     * Get links
     *
     * @return array
     */
    public function getLinks()
    {
        return $this->links;
    }

    /**
     * setFile
     *
     * @param File $file
     *
     * @return Image
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * getFile
     *
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

}
