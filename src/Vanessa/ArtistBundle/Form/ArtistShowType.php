<?php

namespace Vanessa\ArtistBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Vanessa\ArtistBundle\Form\EventListener\AddAgencyFieldSubscriber;

/**
 * Vanessa\ArtistBundle\Form\ArtistShowType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaArtistBundle
 * @subpackage Form
 * @version 0.0.1
 */
class ArtistShowType extends AbstractType
{

    /**
     * Build Form
     * 
     * @param FormBuilder $builder
     * @param array $options 
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('firstName', 'text', array(
                'label' => 'First name:',
                'attr' => array('class' => 'span4' , 'disabled' => 'disabled')
            ))
            ->add('lastName', 'text', array(
                'label' => 'Last name:',
                'attr' => array('class' => 'span4' , 'disabled' => 'disabled')
            ))
            ->add('middleName', 'text', array(
                'label' => 'Middle name:',
                'attr' => array('class' => 'span4', 'disabled' => 'disabled'),
            ))                 
            ->add('stageName', 'text', array(
                'label' => 'Stage name:',
                'attr' => array('class' => 'span4' , 'disabled' => 'disabled')
            ))
            ->add('gender', 'entity', array(
                'class' => 'VanessaCoreBundle:Gender',
                'label' => 'Gender:',
                'attr' => array('class' => 'span4 chosen' , 'disabled' => 'disabled')
            ))
            ->add('genres', 'entity', array(
                'class' => 'VanessaCoreBundle:Genre',
                'label' => 'Genres:',
                'multiple' => true ,
                'attr' => array('class' => 'span4 chosen' , 'disabled' => 'disabled')
            ))            
            ->add('shortBiography', 'textarea', array(
                'label' => 'Biography:',
                'attr' => array('class' => 'tinymce span4', 'data-theme' => 'simple' , 'disabled' => 'disabled')
            ))

        ;
    }

    /**
     * Get name
     * @return string 
     */
    public function getName()
    {
        return 'ArtistShow';
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

?>
