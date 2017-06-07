<?php

namespace Tests\AppBundle\Util;

use PHPUnit\Framework\TestCase;
use AppBundle\Entity\ClassSymfony;
use AppBundle\Entity\NamespaceSymfony;


class NamespaceSymfonyTest extends TestCase
{
    public function testName()
    {
        $testName = 'Name_namespace';
        $namespace = new NamespaceSymfony();
        $namespace->setName($testName);
        $this->assertEquals($testName, $namespace->getName());
    }

    public function testURL()
    {
        $testURL = 'URL_namespace';
        $namespace = new NamespaceSymfony();
        $namespace->setUrl($testURL);
        $this->assertEquals($testURL, $namespace->getUrl());
    }


}