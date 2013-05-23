<?php

namespace Vanessa\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Vanessa\MemberBundle\Form\MemberViewType
 *
 * @author Ronald Conco <ronald.conco@gmail.com>
 * @package VanessaMemberBundle
 * @subpackage Form
 * @version 0.0.1
 */
class MemberViewType extends AbstractType
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
                'class' => 'VanessaCoreBundle:Agency',
                'label' => 'Agency:',
                'attr' => array('class' => 'span4 chosen' , 'disabled'=>'disabled')
            ))
            ->add('group', 'entity', array(
                'class' => 'VanessaCoreBundle:Group',
                'label' => 'Role:',
                'attr' => array('class' => 'span4 chosen' , 'disabled'=>'disabled')
            ))
            ->add('title', 'entity', array(
                'class' => 'VanessaCoreBundle:Title',
                'label' => 'Title:',
                'attr' => array('class' => 'span4 chosen' , 'disabled'=>'disabled')
            ))
            ->add('gender', 'entity', array(
                'class' => 'VanessaCoreBundle:Gender',
                'label' => 'Gender:',
                'attr' => array('class' => 'span4 chosen' , 'disabled'=>'disabled')
            ))
            ->add('firstName', 'text', array(
                'label' => 'First name:',
                'attr' => array('class' => 'span4 disabled', 'disabled'=>'disabled')
            ))
            ->add('lastName', 'text', array(
                'label' => 'Last name:',
                'attr' => array('class' => 'span4' , 'disabled'=>'disabled')
            ))
            ->add('mobileNumber', 'text', array(
                'label' => 'Cellphone:',
                'attr' => array('class' => 'span4' , 'disabled'=>'disabled')
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

