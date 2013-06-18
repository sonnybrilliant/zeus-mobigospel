<?php

namespace Vanessa\MemberBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Vanessa\MemberBundle\Form\EventListener\AddAgencyFieldSubscriber;

/**
 * Vanessa\MemberBundle\Form\MemberUpdateType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaLabelBundle
 * @subpackage Form
 * @version 0.0.1
 */
class MemberUpdateType extends AbstractType
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
            ->add('title', 'entity', array(
                'class' => 'VanessaCoreBundle:Title',
                'label' => 'Title:',
                'attr' => array('class' => 'span4 chosen')
            ))
            ->add('gender', 'entity', array(
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

