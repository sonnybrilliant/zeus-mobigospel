<?php

namespace Vanessa\CoreBundle\DataFixtures\ORM;

use Vanessa\CoreBundle\Entity\Status;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;

/**
 * Load default system status
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @version 1.0
 * @package VanessaCoreBundle
 * @subpackage DataFixtures
 * @version 0.0.1
 */
class LoadStatus extends AbstractFixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        //create statuses
        $active = new Status();
        $active->setName('Active');
        $active->setCode(10);
        $manager->persist($active);

        $inactive = new Status();
        $inactive->setName('Inactive');
        $inactive->setCode(20);
        $manager->persist($inactive);

        $new = new Status();
        $new->setName('New');
        $new->setCode(30);
        $manager->persist($new);

        $old = new Status();
        $old->setName('Old');
        $old->setCode(40);
        $manager->persist($old);

        $completed = new Status();
        $completed->setName('Completed');
        $completed->setCode(50);
        $manager->persist($completed);

        $cancelled = new Status();
        $cancelled->setName('Cancelled');
        $cancelled->setCode(60);
        $manager->persist($cancelled);

        $progress = new Status();
        $progress->setName('In Progress');
        $progress->setCode(70);
        $manager->persist($progress);

        $pending = new Status();
        $pending->setName('Pending');
        $pending->setCode(80);
        $manager->persist($pending);

        $deleted = new Status();
        $deleted->setName('Deleted');
        $deleted->setCode(90);
        $manager->persist($deleted);

        $pendingEncoding = new Status();
        $pendingEncoding->setName('Pending encoding');
        $pendingEncoding->setCode(100);
        $manager->persist($pendingEncoding);

        $blocked = new Status();
        $blocked->setName('Blocked');
        $blocked->setCode(110);
        $manager->persist($blocked);

        $error = new Status();
        $error->setName('Error');
        $error->setCode(120);
        $manager->persist($error);

        $failed = new Status();
        $failed->setName('Failed');
        $failed->setCode(130);
        $manager->persist($failed);

        $objSuccess = new Status();
        $objSuccess->setName('Successful');
        $objSuccess->setCode(140);
        $manager->persist($objSuccess);

        $timeout = new Status();
        $timeout->setName('Timed Out');
        $timeout->setCode(150);
        $manager->persist($timeout);

        $locked = new Status();
        $locked->setName('Locked');
        $locked->setCode(160);
        $manager->persist($locked);

        $inviteSent = new Status();
        $inviteSent->setName('Invite Sent');
        $inviteSent->setCode(170);
        $manager->persist($inviteSent);

        $encodingPreview = new Status();
        $encodingPreview->setName('Encoding preview');
        $encodingPreview->setCode(180);
        $manager->persist($encodingPreview);

        $encodingFullTrack = new Status();
        $encodingFullTrack->setName('Encoding full track');
        $encodingFullTrack->setCode(190);
        $manager->persist($encodingFullTrack);

        $encoding = new Status();
        $encoding->setName('Encoding');
        $encoding->setCode(200);
        $manager->persist($encoding);


        $manager->flush();

        $this->addReference('status-active', $active);
    }

    public function getOrder()
    {
        return 1;
    }

}
