<?php

namespace Vanessa\TransactionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Vanessa\TransactionBundle\Form\InboundViewType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaTransactionBundle
 * @subpackage Form
 * @version 0.0.1
 */
class InboundViewType extends AbstractType
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
            ->add('msisdn', 'text', array(
                'label' => 'Msisdn:',
                'attr' => array(
                    'class' => 'span4',
                    'disabled' => 'disabled'
                )
            ))
            ->add('toAddress', 'text', array(
                'label' => 'To Address:',
                'attr' => array(
                    'class' => 'span4',
                    'disabled' => 'disabled'
                )
            ))
            ->add('body', 'textarea', array(
                'label' => 'Payload:',
                'attr' => array(
                    'class' => 'span4',
                    'disabled' => 'disabled'
                )
            ))
            ->add('seqno', 'text', array(
                'label' => 'Seqno:',
                'attr' => array(
                    'class' => 'span4',
                    'disabled' => 'disabled'
                )
            ))
            ->add('status', 'entity', array(
                'label' => 'Status:',
                'class' => 'VanessaCoreBundle:Status',
                'attr' => array(
                    'class' => 'span4',
                    'disabled' => 'disabled'
                )
            ))
            ->add('network', 'text', array(
                'label' => 'Network:',
                'attr' => array(
                    'class' => 'span4',
                    'disabled' => 'disabled'
                )
            ))
            ->add('createdAt', 'date', array(
                'label' => 'Received At:',
                'attr' => array(
                    'class' => 'span4',
                    'disabled' => 'disabled'
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
        return 'Rxqueue';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Vanessa\CoreBundle\Entity\Rxqueue',
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vanessa\CoreBundle\Entity\Rxqueue',
        ));
    }

}

?>
