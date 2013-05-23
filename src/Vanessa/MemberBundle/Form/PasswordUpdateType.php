<?php

namespace Vanessa\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Vanessa\MemberBundle\Form\PasswordUpdateType
 *
 * @author Ronald Conco <ronald.conco@gmail.com>
 * @package VanessaMemberBundle
 * @subpackage Form
 * @version 0.0.1
 */
class PasswordUpdateType extends AbstractType
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
        $builder->add('password' , 'repeated' , array (
          'type' => 'password' ,
          'first_name' => 'first' ,
          'first_options'  => array('label' => 'New password:',
              'attr'=> array(
                  'placeholder' => 'New password',
                  "class"=>"span3 password_test",
                  "data-validation-minlength-message" => "Password must have at least 5 characters",
                  "minlength" => 5)),  
          'second_name' => 'second' ,
          'second_options' => array('label' => 'Re-type password:',
              'attr'=> array(
                  'placeholder' => 'Re-type password',
                  "class"=>"span3",
                  "data-validation-minlength-message" => "Password must have at least 5 characters",
                  "minlength"=>5,
                  "data-validation-match-match" =>"ResetPassword[password][first]",
                  "data-validation-match-message" =>"Passwords do not match")),
          'invalid_message' =>'Passwords do not match' ,
        ));
    }

    /**
     * Get name
     * @return string 
     */
    public function getName()
    {
        return 'ResetPassword';
    }
}