<?php

namespace Vanessa\CodeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Vanessa\CodeBundle\Form\CodeCreateType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCodeBundle
 * @subpackage Form
 * @version 0.0.1
 */
class CodeCreateType extends AbstractType
{

    /**
     *
     * @var VanessaCoreBundle:Member 
     */
    private $user;

    /**
     *
     * @param type $user
     */
    public function __construct($user)
    {
        $this->user = $user;
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
        $user = $this->user;
        $builder
            ->add('code', 'text', array(
                'label' => 'Code:',
                'attr' => array(
                    'class' => 'span4',
                    'placeholder' => 'Song title',
                    'minlength' => 5,
                    'data-validation-minlength-message' => 'Code must have at least 5 characters.',
                    'maxlength' => 8,
                    'data-validation-maxlength-message' => 'Code has a limit of 8 characters.',
                )
            ))
            ->add('song', 'entity', array(
                'class' => 'VanessaCoreBundle:Song',
                'label' => 'Song:',
                'empty_value' => 'Choose a song',
                'attr' => array('class' => 'span4 chosen'),
                'query_builder' => function(EntityRepository $er) use ($user) {
                    if ($user->getIsAdmin()) {
                        return $er->createQueryBuilder('c')
                            ->where('c.isDeleted = :isDeleted')
                            ->andWhere('c.isActive = :isActive')
                            ->setParameters(array(
                                'isDeleted' => false,
                                'isActive' => true
                            ));
                    } else {
                        return $er->createQueryBuilder('c')
                            ->where('c.isDeleted = :isDeleted')
                            ->andWhere('c.isActive = :isActive')
                            ->andWhere('c.agency = :agency')
                            ->setParameters(array(
                                'isDeleted' => false,
                                'isActive' => true,
                                'agency' => $user->getAgency()
                            ));
                    }
                },
            ))
        ;
    }

    /**
     * Get name
     * @return string 
     */
    public function getName()
    {
        return 'Code';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Vanessa\CoreBundle\Entity\Code',
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vanessa\CoreBundle\Entity\Code',
        ));
    }

}

?>
