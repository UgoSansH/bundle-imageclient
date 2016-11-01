<?php

namespace Ugosansh\Bundle\Image\ClientBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Image form type
 */
class ImageType extends AbstractType
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
            ->add('title', TextType::class, [
                'label' => 'titre'
            ])
            ->add('file', FileType::class, [
                'label' => 'Image',
                'attr'  => ['accept' => 'image/png|image/jpg|image/jpeg|image/gif']
            ]);
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return 'ugosansh_image';
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
