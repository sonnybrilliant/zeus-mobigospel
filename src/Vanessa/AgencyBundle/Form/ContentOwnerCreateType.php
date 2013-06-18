<?php

namespace Vanessa\AgencyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface; 

/**
 * Vanessa\AgencyBundle\Form\ContentOwnerCreateType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaAgencyBundle
 * @subpackage Form
 * @version 0.0.1
 */
class ContentOwnerCreateType extends AbstractType
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
                      'placeholder' => 'Content owner name',
                      'minlength' => 2,
                      'data-validation-minlength-message' => 'Name must have at least 2 characters.',
                      'maxlength' => 100,
                      'data-validation-maxlength-message' => 'Name has a limit of 100 characters.',
                      )
                ))            
            ->add('slogan', 'text', array (
                  'label' => 'Slogan:' ,
                  'attr' => array (
                      'class' => 'span4',
                      'placeholder' => 'slogan',
                      'minlength' => 10,
                      'data-validation-minlength-message' => 'Slogan must have at least 10 characters.',
                      'maxlength' => 50,
                      'data-validation-maxlength-message' => 'Slogan has a limit of 50 characters.',  
                      )
                ))
             ->add('description', 'textarea' , array (
                  'label' => 'Description:' ,
                  'required' => false,
                  'attr' => array ('class' => 'tinymce span2' ,'data-theme' => 'simple')
                            
                ))           
              ->add('contactPerson', 'text', array (
                  'label' => 'Full names:' ,
                  'attr' => array (
                      'class' => 'span4' ,
                      'placeholder' => 'Content owner contact person full name',
                      'minlength' => 5,
                      'data-validation-minlength-message' => 'Contact person full name must have at least 5 characters.',
                      'maxlength' => 50,
                      'data-validation-maxlength-message' => 'Contact person full name has a limit of 50 characters.',
                      )
                ))            
               ->add('contactNumber', 'text', array (
                  'label' => 'Telephone:' ,
                  'required' => false,
                  'attr' => array (
                      'class' => 'span4 phone',
                      'placeholder' => 'Content owner contact number',
                      'minlength' => 14,
                      'data-validation-minlength-message' => 'Contact number must have at least 14 characters.',
                      'maxlength' => 20,
                      'data-validation-maxlength-message' => 'Contact number has a limit of 20 characters.',
                      )
                )) 
               ->add('contactEmail', 'email', array (
                  'label' => 'Email address:' ,
                  'required' => false,
                  'attr' => array (
                      'class' => 'span4',
                      'placeholder' => 'Content owner contact email address',
                      'data-validation-email-message' => 'Not a valid email address.',
                      )
                )) 
            ->add('address1', 'text', array(
                'label' => 'Address line 1:',
                  'attr' => array (
                      'class' => 'span4',
                      'placeholder' => 'address line 1',
                      'minlength' => 3,
                      'data-validation-minlength-message' => 'Address line 1 must have at least 3 characters.',
                      'maxlength' => 254,
                      'data-validation-maxlength-message' => 'Address line 1 has a limit of 254 characters.',
                      )
                ))
            ->add('address2', 'text', array(
                'label' => 'Address line 2:',
                'attr' => array (
                    'class' => 'span4',
                    'placeholder' => 'address line 2',
                    )
                ))
            ->add('suburbCode', 'text', array(
                    'label' => 'Suburb code:',
                    'attr' => array (  
                      'class' => 'span4', 
                      'placeholder' => 'suburb postal code',
                      'minlength' => 4,
                      'data-validation-minlength-message' => 'Suburb code must have at least 4 characters.',
                      'maxlength' => 6,
                      'data-validation-maxlength-message' => 'Suburb code has a limit of 6 characters.',
                      )
                ))
            ->add('postalBox', 'text', array(
                'label' => 'Postal box:',
                  'attr' => array (
                      'class' => 'span4',
                      'placeholder' => 'postal box',
                      'minlength' => 3,
                      'data-validation-minlength-message' => 'Postal box must have at least 3 characters.',
                      'maxlength' => 50,
                      'data-validation-maxlength-message' => 'Postal box has a limit of 50 characters.',
                      )
                ))
            ->add('suburb', 'text', array(
                'label' => 'Suburb:',
                  'attr' => array (
                      'class' => 'span4',
                      'placeholder' => 'postal suburb',
                      'minlength' => 3,
                      'data-validation-minlength-message' => 'Postal suburb must have at least 3 characters.',
                      'maxlength' => 50,
                      'data-validation-maxlength-message' => 'Postal suburb has a limit of 50 characters.',
                      )
                ))
            ->add('postalCode', 'text', array(
                    'label' => 'Postal code:',
                    'attr' => array (  
                      'class' => 'span4', 
                      'placeholder' => 'postal code',
                      'minlength' => 4,
                      'data-validation-minlength-message' => 'postal code must have at least 4 characters.',
                      'maxlength' => 6,
                      'data-validation-maxlength-message' => 'postal code has a limit of 6 characters.',
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
        return 'ContentOwnerCreate';
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
