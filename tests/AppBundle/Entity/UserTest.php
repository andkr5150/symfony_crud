<?php
namespace Tests\AppBundle\Util;


use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testUsername()
    {
        $user = new User();
        $testUserName = 'Name_test_user';
        $user->setUsername($testUserName);
        $this->assertEquals($testUserName, $user->getUsername());
    }

    public function testPassword()
    {
        $user = new User();
        $testPassword = 'Password';
        $user->setPassword($testPassword);
        $this->assertEquals($testPassword, $user->getPassword());
    }

    public function testRoles()
    {
        $user = new User();
        $this->assertInternalType('array', $user->getRoles());
    }
}