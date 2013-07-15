<?php

namespace Vanessa\MemberBundle\Form\EventListener;

use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Doctrine\ORM\EntityRepository;

/**
 * Add agency field 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaLabelBundle
 * @subpackage Form/EventListener
 * @version 0.0.1
 */
class AddAgencyFieldSubscriber implements EventSubscriberInterface
{

    private $factory;
    private $container;

    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public static function getSubscribedEvents()
    {
        return array(FormEvents::POST_SET_DATA => 'preSetData');
    }

    public function preSetData(DataEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();

        // During form creation setData() is called with null as an argument
        // by the FormBuilder constructor. We're only concerned with when
        // setData is called with an actual Entity object in it (whether new,
        // or fetched with Doctrine). This if statement let's us skip right
        // over the null condition.
        if (null === $data) {
            return;
        }


        if ($this->container->get('security.context')->isGranted('ROLE_ADMIN')) {
            $form->add($this->factory->createNamed(
                    'agency', 'entity', null, array(
                    'class' => 'VanessaCoreBundle:Agency',
                    'label' => 'Organization:',      
                    'attr' => array('class' => 'span4 chosen'),
                    'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('a')
                                    ->where('a.enabled = :enabled')                                    
                                    ->setParameters(array(
                                        'enabled' => true,
                                        ));
                        },    
                )));
            $form->add($this->factory->createNamed(
                    'group', 'entity', null, array(
                    'class' => 'VanessaCoreBundle:Group',
                    'attr' => array('class' => 'span4 chosen')
                )));
        }
    }

}
