<?php

namespace Vanessa\AgencyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Vanessa\AgencyBundle\Form\ResellerAccountStatusUpdateType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaLabelBundle
 * @subpackage Form
 * @version 0.0.1
 */
class ResellerAccountStatusUpdateType extends AbstractType
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

        $builder->add('accountStatus', 'choice', array(
            'empty_value' => 'Choose a state',
            'label' => 'Status:',
            'required'  => true,
            'choices' => array(
                'activate' => 'Activate',
                'lock' => 'Lock',
            ),
        ));
    }

    /**
     * Get name
     * @return string 
     */
    public function getName()
    {
        return 'ResellerAccountStatusUpdate';
    }

}

