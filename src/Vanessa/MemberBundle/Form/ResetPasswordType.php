<?php

namespace Vanessa\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Vanessa\MemberBundle\Form\ResetPasswordType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaMemberBundle
 * @subpackage Form
 * @version 0.0.1
 */
class ResetPasswordType extends AbstractType
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
            ->add('email', 'email', array(
                'label' => 'Email address:',
                'attr' => array('class' => 'span4','data-validation-email-message' => 'Invalid email address.')
            ))
            ->add('captcha', 'genemu_recaptcha' )
        ;
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