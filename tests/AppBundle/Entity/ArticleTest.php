<?php

declare(strict_types=1);

namespace Test\AppBundle\Util;

use AppBundle\Entity\Article;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\DateTime;

class ArticleTest extends TestCase
{
    public function testName()
    {
        $testName = 'Name_1';
        $article = new Article();
        $article->setName($testName);
        $this->assertEquals($testName, $article->getName());
    }

    public function testDescription()
    {
        $testDesc = 'desc_1';
        $article = new Article();
        $article->setDescription($testDesc);
        $this->assertEquals($testDesc, $article->getDescription());
    }

    public function testCreatedAt()
    {
        $testCreate = new \DateTime('tomorrow');
        $article = new Article();
        $article->setCreatedAt($testCreate);
        $this->assertEquals($testCreate, $article->getCreatedAt());
    }

}