<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData implements FixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $user = new User();
        $user->setUsername('root');
        $user->setPassword(password_hash('1234', PASSWORD_BCRYPT));
        $manager->persist($user);
        $manager->flush();

    }

}