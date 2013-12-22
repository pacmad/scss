<?php
namespace SCSS\PasselBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use SCSS\PasselBundle\Entity\Attendee;

class LoadAttendeeData extends AbstractFixture implements OrderedFixtureInterface
{
    $test = new Attendee();
    $test->setFirstName('johnny');
    $test->setLastName('Testman');
    $test->setFaction($this->getReference('faction-test-test'));
    $test->setPassel($this->getReference('passel-test'));
    $manager->persist($test);
    $this->addReference('attendee-testman-johnny');

    $manager->flush();
}