<?php

namespace Vanessa\SongBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Vanessa\SongBundle\Form\SongShowType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaSongBundle
 * @subpackage Form
 * @version 0.0.1
 */
class SongShowType extends AbstractType
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
            ->add('title', 'text', array(
                'label' => 'Title:',
                'attr' => array('class' => 'span4' , 'disabled' => 'disabled')
            ))
            ->add('featuredArtist', 'text', array(
                'label' => 'Featured artist:',
                'required' => false,
                'attr' => array('class' => 'span4' , 'disabled' => 'disabled'),
            ))
            ->add('artist', 'entity', array(
                'class' => 'VanessaCoreBundle:Artist',
                'label' => 'Artist:',
                'attr' => array('class' => 'span4 chosen', 'disabled' => 'disabled'),
            ))
            ->add('status', 'entity', array(
                'class' => 'VanessaCoreBundle:Status',
                'label' => 'Status:',
                'attr' => array('class' => 'span4 chosen', 'disabled' => 'disabled'),
            ))
            ->add('genres', 'entity', array(
                'class' => 'VanessaCoreBundle:Genre',
                'label' => 'Genres:',
                'multiple' => true ,
                'attr' => array('class' => 'span4 chosen','disabled' => 'disabled'),
                 'empty_value' => 'Choose a genre',
            ))   
        ;
    }

    /**
     * Get name
     * @return string 
     */
    public function getName()
    {
        return 'SongTemp';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Vanessa\CoreBundle\Entity\SongTemp',
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vanessa\CoreBundle\Entity\SongTemp',
        ));
    }

}

?>
