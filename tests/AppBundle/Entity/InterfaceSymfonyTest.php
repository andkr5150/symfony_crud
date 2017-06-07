<?php

namespace Tests\AppBundle\Util;

use AppBundle\Entity\InterfaceSymfony;
use AppBundle\Entity\NamespaceSymfony;
use PHPUnit\Framework\TestCase;

class InterfaceSymfonyTest extends TestCase
{
    public function testName()
    {
        $testName = 'Name_Interface';
        $interface = new InterfaceSymfony();
        $interface->setName($testName);
        $this->assertEquals($testName, $interface->getName());
    }

    public function testURL()
    {
        $testURL = 'URL_interface';
        $interface = new InterfaceSymfony();
        $interface->setUrl($testURL);
        $this->assertEquals($testURL, $interface->getUrl());
    }

    public function testNamespace()
    {
        $testNamespace = new NamespaceSymfony();
        $interface = new InterfaceSymfony();
        $interface->setNamespace($testNamespace);
        $this->assertEquals($testNamespace, $interface->getNamespace());
    }
}