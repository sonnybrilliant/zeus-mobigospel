<?php

namespace Vanessa\SongBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;



/**
 * Vanessa\SongBundle\Form\SongRejectType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaSongBundle
 * @subpackage Form
 * @version 0.0.1
 */
class SongRejectType extends AbstractType
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
            ->add('message', 'textarea', array(
                'label' => 'Reason:',
                'attr' => array('class' => 'tinymce span4', 'data-theme' => 'simple'),
                'required' => false
            ))
        ;
    }

    /**
     * Get name
     * @return string 
     */
    public function getName()
    {
        return 'SongRejectType';
    }

}

?>
