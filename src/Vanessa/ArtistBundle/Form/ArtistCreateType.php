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
                'required' => false,
                'attr' => array(
                    'class' => 'span4',
                    'placeholder' => 'Firt name',
                    'minlength' => 2,
                    'data-validation-minlength-message' => 'First name must have at least 2 characters.',
                    'maxlength' => 100,
                    'data-validation-maxlength-message' => 'First name  has a limit of 100 characters.',                   
                    ),
                
            ))
            ->add('middleName', 'text', array(
                'label' => 'Middle name:',
                'required' => false,
                'attr' => array(
                    'class' => 'span4',
                    'placeholder' => 'Middle name',
                    'minlength' => 2,
                    'data-validation-minlength-message' => 'Middle name must have at least 2 characters.',
                    'maxlength' => 100,
                    'data-validation-maxlength-message' => 'Middle name  has a limit of 100 characters.',                      
                    ),
                
            ))
            ->add('lastName', 'text', array(
                'label' => 'Last name:',
                'required' => false,
                'attr' => array(
                    'class' => 'span4',
                    'placeholder' => 'Last name',
                    'minlength' => 2,
                    'data-validation-minlength-message' => 'Last name must have at least 2 characters.',
                    'maxlength' => 100,
                    'data-validation-maxlength-message' => 'Last name  has a limit of 100 characters.',                    
                    ),
                
            ))
            ->add('isGroup', 'checkbox', array(
                'label' => 'Is Band?',
                'attr' => array('class' => 'span4 isGroup'),
                'required' => false
            ))
            ->add('stageName', 'text', array(
                'label' => 'Stage name:',
                'required' => false,
                'attr' => array(
                    'class' => 'span4',
                    'placeholder' => 'Stage name',
                    'minlength' => 2,
                    'data-validation-minlength-message' => 'Stage name must have at least 2 characters.',
                    'maxlength' => 100,
                    'data-validation-maxlength-message' => 'Stage name has a limit of 100 characters.',                      
                    )
            ))
            ->add('gender', 'entity', array(
                'class' => 'VanessaCoreBundle:Gender',
                'label' => 'Gender:',
                'attr' => array('class' => 'span4 chosen'),
                'required' => false,
                'empty_value' => 'Choose a gender',
            ))
            ->add('genres', 'entity', array(
                'class' => 'VanessaCoreBundle:Genre',
                'label' => 'Genres:',
                'multiple' => true ,
                'attr' => array('class' => 'span4 chosen'),
                 'empty_value' => 'Choose a genre',
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

