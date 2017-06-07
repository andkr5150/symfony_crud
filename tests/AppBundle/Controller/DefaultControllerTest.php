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

        $crawler = $client->request('GET', '/admin');

        $linkCreate = $crawler->filter('a:contains("Create entry")')->eq(0)->link();
        $crawler = $client->click($linkCreate);

        $form = $crawler->selectButton('Submit')->form();
        $form['article[name]'] = 'new_name';
        $form['article[description]'] = 'new_desc';
        $client->submit($form);

        $this->assertTrue(
            $client->getResponse()->isRedirect('/admin'));

        $this->assertTrue($crawler->filter('input')->count() > 1);
    }

    public function testdeleteAction()
    {
        $client = static::createClient(array(), array(
            'PHP_AUTH_USER' => 'root',
            'PHP_AUTH_PW'   => '1234',
        ));
        $crawler = $client->request('GET', '/admin');

        $linkCreate = $crawler->filter('a:contains("delete")')->eq(1)->link();
        $crawler = $client->click($linkCreate); // delete

        $this->assertTrue(
            $client->getResponse()->isRedirect('/admin'));
//        $this->assertTrue($crawler->filter('input')->count() > 1);
    }

}