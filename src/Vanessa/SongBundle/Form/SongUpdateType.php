<?php

namespace Vanessa\SongBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Vanessa\SongBundle\Form\EventListener\AddAgencyFieldSubscriber;
use Doctrine\ORM\EntityRepository;

/**
 * Vanessa\SongBundle\Form\SongUpdateType
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaSongBundle
 * @subpackage Form
 * @version 0.0.1
 */
class SongUpdateType extends AbstractType
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
            ->add('title', 'text', array(
                'label' => 'Title:',
                'attr' => array(
                    'class' => 'span4',
                    'placeholder' => 'Song title',
                    'minlength' => 2,
                    'data-validation-minlength-message' => 'Song title must have at least 2 characters.',
                    'maxlength' => 100,
                    'data-validation-maxlength-message' => 'Song title has a limit of 100 characters.',
                    
                    )
            ))
            ->add('featuredArtist', 'text', array(
                'label' => 'Featured artist:',
                'required' => false,
                'attr' => array(
                    'class' => 'span4',
                    'placeholder' => 'Featured artist',
                    'minlength' => 2,
                    'data-validation-minlength-message' => 'Featured artist name must have at least 2 characters.',
                    'maxlength' => 100,
                    'data-validation-maxlength-message' => 'Featured artist name has a limit of 100 characters.',                    
                    ),
                
            ))
            ->add('artist', 'entity', array(
                'class' => 'VanessaCoreBundle:Artist',
                'label' => 'Artist:',
                'attr' => array('class' => 'span4 chosen'),
                'query_builder' => function(EntityRepository $er) use ($user) {
                    if ($user->getIsAdmin()) {
                        return $er->createQueryBuilder('a')
                            ->where('a.isDeleted = :status')
                            ->setParameter('status', false);
                    } else {
                        return $er->createQueryBuilder('a')
                            ->where('a.isDeleted = :status')
                            ->andWhere('a.agency = :agency')
                            ->setParameters(array(
                                'status' => false,
                                'agency' => $user->getAgency()
                            ));
                    }
                },
            ))
            ->add('genres', 'entity', array(
                'class' => 'VanessaCoreBundle:Genre',
                'label' => 'Genres:',
                'multiple' => true ,
                'attr' => array('class' => 'span4 chosen'),
                 'empty_value' => 'Choose a genre',
            ))   
            ->add('song', 'file', array(
                'label' => 'Audio file:',
                'attr' => array('class' => 'span4 chosen'),
                'required' => false,
            ))
        ;
    }

    /**
     * Get name
     * @return string 
     */
    public function getName()
    {
        return 'SongTemp';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Vanessa\CoreBundle\Entity\SongTemp',
        );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Vanessa\CoreBundle\Entity\SongTemp',
        ));
    }

}

?>
