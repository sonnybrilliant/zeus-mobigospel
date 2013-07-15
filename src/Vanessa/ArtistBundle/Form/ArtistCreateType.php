<?php

namespace Vanessa\ArtistBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Vanessa\ArtistBundle\Form\EventListener\AddAgencyFieldSubscriber;

/**
 * Vanessa\ArtistBundle\Form\ArtistCreateType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaArtistBundle
 * @subpackage Form
 * @version 0.0.1
 */
class ArtistCreateType extends AbstractType
{

    private $container;

    /**
     *
     * @param type $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    /**
     * Build Form
     * 
     * @param FormBuilder $builder
     * @param array $options 
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $subscriber = new AddAgencyFieldSubscriber($builder->getFormFactory());
        $subscriber->setContainer($this->container);
        
        $builder
            ->addEventSubscriber($subscriber)
            ->add('firstName', 'text', array(
                'label' => 'First name:',
                'attr' => array('class' => 'span4'),
                'required' => false
            ))
            ->add('middleName', 'text', array(
                'label' => 'Middle name:',
                'attr' => array('class' => 'span4'),
                'required' => false
            ))
            ->add('lastName', 'text', array(
                'label' => 'Last name:',
                'attr' => array('class' => 'span4'),
                'required' => false
            ))
            ->add('isGroup', 'checkbox', array(
                'label' => 'Is Band?',
                'attr' => array('class' => 'span4 isGroup')
            ))
            ->add('stageName', 'text', array(
                'label' => 'Stage name:',
                'attr' => array('class' => 'span4')
            ))
            ->add('gender', 'entity', array(
                'class' => 'VanessaCoreBundle:Gender',
                'label' => 'Gender:',
                'attr' => array('class' => 'span4 chosen'),
                'required' => false
            ))
            ->add('genres', 'entity', array(
                'class' => 'VanessaCoreBundle:Genre',
                'label' => 'Genres:',
                'multiple' => true ,
                'attr' => array('class' => 'span4 chosen')
            ))            
            ->add('picture', 'file', array(
                'label' => 'Profile picture:',
                'attr' => array('class' => 'span4 chosen'),
                'required' => false
            ))
            ->add('shortBiography', 'textarea', array(
                'label' => 'Biography:',
                'attr' => array('class' => 'tinymce span4', 'data-theme' => 'simple')
            ))

        ;
    }

    /**
     * Get name
     * @return string 
     */
    public function getName()
    {
        return 'ArtistCreate';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Vanessa\CoreBundle\Entity\Artist',
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vanessa\CoreBundle\Entity\Artist',
        ));
    }
}

