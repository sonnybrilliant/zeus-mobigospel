<?php

namespace Vanessa\AgencyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface; 

/**
 * Vanessa\AgencyBundle\Form\ResellerProfileType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaAgencyBundle
 * @subpackage Form
 * @version 0.0.1
 */
class ResellerProfileType extends AbstractType
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
            ->add('name', 'text', array (
                  'label' => 'Name:' ,
                  'attr' => array (
                      'class' => 'span4',
                      'disabled'=>'disabled'
                      )
                ))            
            ->add('slogan', 'text', array (
                  'label' => 'Slogan:' ,
                  'attr' => array (
                      'class' => 'span4',
                      'disabled'=>'disabled'
                      )
                ))
             ->add('description', 'textarea' , array (
                  'label' => 'Description:' ,
                  'required' => false,
                  'attr' => array ('class' => 'tinymce span4' ,'data-theme' => 'simple','disabled'=>'disabled')
                            
                ))           
              ->add('contactPerson', 'text', array (
                  'label' => 'Full names:' ,
                  'attr' => array (
                      'class' => 'span4' ,
                      'disabled'=>'disabled'
                      )
                ))            
               ->add('contactNumber', 'text', array (
                  'label' => 'Telephone:' ,
                  'required' => false,
                  'attr' => array (
                      'class' => 'span4 phone',
                      'disabled'=>'disabled'
                      )
                )) 
               ->add('contactEmail', 'email', array (
                  'label' => 'Email address:' ,
                  'required' => false,
                  'attr' => array (
                      'class' => 'span4',
                      'disabled'=>'disabled'
                      )
                )) 
            ->add('address1', 'text', array(
                'label' => 'Address line 1:',
                  'attr' => array (
                      'class' => 'span4',
                      'disabled'=>'disabled'
                      )
                ))
            ->add('address2', 'text', array(
                'label' => 'Address line 2:',
                'attr' => array (
                    'class' => 'span4',
                    'disabled'=>'disabled'
                    )
                ))
            ->add('suburbCode', 'text', array(
                    'label' => 'Suburb code:',
                    'attr' => array (  
                      'class' => 'span4', 
                      'disabled'=>'disabled'
                      )
                ))
            ->add('postalBox', 'text', array(
                'label' => 'Postal box:',
                  'attr' => array (
                      'class' => 'span4',
                      'disabled'=>'disabled'
                      )
                ))
            ->add('suburb', 'text', array(
                'label' => 'Suburb:',
                  'attr' => array (
                      'class' => 'span4',
                      'disabled'=>'disabled'
                      )
                ))
            ->add('postalCode', 'text', array(
                    'label' => 'Postal code:',
                    'attr' => array (  
                      'class' => 'span4', 
                      'disabled'=>'disabled'
                      )
                ))            
        
        ;
    }

    /**
     * Get name
     * @return string 
     */
    public function getName()
    {
        return 'ResellerProfile';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Vanessa\CoreBundle\Entity\Agency',
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vanessa\CoreBundle\Entity\Agency',
        ));
    }

}

?>
