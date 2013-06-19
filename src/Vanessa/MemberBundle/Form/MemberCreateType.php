<?php

namespace Vanessa\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Vanessa\MemberBundle\Form\MemberCreateType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaLabelBundle
 * @subpackage Form
 * @version 0.0.1
 */
class MemberCreateType extends AbstractType
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
            ->add('agency', 'entity', array(
                'empty_value' => 'Select an agency',
                'class' => 'VanessaCoreBundle:Agency',
                'label' => 'Agency:',
                'attr' => array('class' => 'span4 chosen'),
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->where('a.enabled = :enabled')
                        ->setParameter('enabled',true);
                },
            ))
            ->add('group', 'entity', array(
                'empty_value' => 'Select a role',
                'class' => 'VanessaCoreBundle:Group',
                'label' => 'Role:',
                'attr' => array('class' => 'span4 chosen')
            ))
            ->add('title', 'entity', array(
                'empty_value' => 'Select a title',
                'class' => 'VanessaCoreBundle:Title',
                'label' => 'Title:',
                'attr' => array('class' => 'span4 chosen')
            ))
            ->add('gender', 'entity', array(
                'empty_value' => 'Select a gender',
                'class' => 'VanessaCoreBundle:Gender',
                'label' => 'Gender:',
                'attr' => array('class' => 'span4 chosen')
            ))
            ->add('firstName', 'text', array(
                'label' => 'First name:',
                'attr' => array(
                    'class' => 'span4',
                    "data-validation-minlength-message" => "First name must have at least 2 characters.",
                    "minlength" => 2,
                    "data-validation-maxlength-message" => "First name has a limit of 100 characters.",
                    "maxlength" => 100,
                 )
            ))
            ->add('lastName', 'text', array(
                'label' => 'Last name:',
                'attr' => array(
                    'class' => 'span4',
                    "data-validation-minlength-message" => "Last name must have at least 2 characters.",
                    "minlength" => 2,
                    "data-validation-maxlength-message" => "Last name has a limit of 100 characters.",
                    "maxlength" => 100,                    
                )
            ))
            ->add('mobileNumber', 'text', array(
                'label' => 'Cellphone:',
                'attr' => array('class' => 'span4 phone')
            ))
            ->add('email', 'repeated', array(
                'type' => 'email',
                'first_name' => 'first',
                'first_options'  => array('label' => 'Email address:'),
                'options' => array('attr' => array('class' => 'span4')),
                'second_name' => 'second',
                'second_options' => array('label' => 'Confirm Email address:'),
                'invalid_message' => 'Email addresses do not match',
                
            ))

        ;
    }

    /**
     * Get name
     * @return string 
     */
    public function getName()
    {
        return 'Member';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Vanessa\CoreBundle\Entity\Member',
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vanessa\CoreBundle\Entity\Member',
        ));
    }

}

