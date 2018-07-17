<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DomCrawler\Crawler;

class DefaultControllerTest extends WebTestCase
{
    private $clientUser = null;

    public function setUp()
    {
        $this->clientUser = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'User1',
        'PHP_AUTH_PW'   => 'password1',
        ));
    }

    public function testIndex()
    {
        $crawler = $this->clientUser->request('GET', '/', array(), array(), array(
        'PHP_AUTH_USER' => 'User1',
        'PHP_AUTH_PW'   => 'password1',
        ));
        $this->assertSame(200, $this->clientUser->getResponse()->getStatusCode());
        $this->assertContains('Bienvenue sur Todo List', $crawler->filter('h1')->text());
    }
}
