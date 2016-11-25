<?php

namespace Ugosansh\Bundle\Image\ClientBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Simple Image form type
 */
class SimpleImageType extends AbstractType
{
    /**
     * @var string
     */
    protected $dataClass;

    /**
     * __construct
     *
     * @param string $dataClass Data class
     */
    public function __construct($dataClass)
    {
        $this->dataClass = $dataClass;
    }

    /**
     * buildForm
     *
     * @param FormBuilderInterface $builder Form Builder
     * @param array                $options Form options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', FileType::class, [
                'label'    => !empty($options['label']) ? $options['label'] : 'Image',
                'attr'     => ['accept' => 'image/png|image/jpg|image/jpeg|image/gif'],
                'required' => array_key_exists('required', $options) ? $options['required'] : false
            ]);
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return 'ugosansh_image_simple';
    }

    /**
     * getDefaultOptions
     *
     * @param array $options Options
     *
     * @return array
     */
    public function getDefaultOptions(array $options) {
        return [
            'data_class' => $this->dataClass
        ];
    }

}
