<?php

namespace Tests\AppBundle\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Controller\DefaultController;

class DefaultControllerTest extends WebTestCase
{
    public function testindexAction()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'root',
            'PHP_AUTH_PW'   => '1234',
        ));

        $client->request('GET', '/');

        $this->assertTrue(
            $client->getResponse()->isRedirect('/admin'));
    }


    public function testCreateAction()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'root',
            'PHP_AUTH_PW'   => '1234',
        ));

        $crawler = $client->request('GET', '/admin/create');

        $form = $crawler->selectButton('Submit')->form();
        $form->setValues(array(
            'article[name]' => 'new_name',
            'article[description]' => 'new_desc',
        ));

        $client->submit($form);
    }


}