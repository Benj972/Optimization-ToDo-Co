<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DomCrawler\Crawler;

class DefaultControllerTest extends WebTestCase
{
    private $clientUser = null;

    private $clientAdmin = null;

    private $clientNotLoged = null;

    public function setUp()
    {
        $this->clientNotLoged = static::createClient();

        $this->clientUser = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'User1',
        'PHP_AUTH_PW'   => 'password1',
        ));

        $this->clientAdmin = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'User2',
        'PHP_AUTH_PW'   => 'password2',
        ));
    }

    public function testIndexUser()
    {
        $crawler = $this->clientUser->request('GET', '/', array(), array(), array(
        'PHP_AUTH_USER' => 'User1',
        'PHP_AUTH_PW'   => 'password1',
        ));
        $this->assertSame(200, $this->clientUser->getResponse()->getStatusCode());
        $this->assertContains('Bienvenue sur Todo List', $crawler->filter('h1')->text());
    }

    public function testIndexAdmin()
    {
        $crawler = $this->clientAdmin->request('GET', '/', array(), array(), array(
        'PHP_AUTH_USER' => 'User2',
        'PHP_AUTH_PW'   => 'password2',
        ));
        $this->assertSame(200, $this->clientAdmin->getResponse()->getStatusCode());
        $this->assertContains('Bienvenue sur Todo List', $crawler->filter('h1')->text());
    }

    public function testIndexNotLoged()
    {
        $this->clientNotLoged->request('GET', '/');

        $this->assertSame(302, $this->clientNotLoged->getResponse()->getStatusCode());
    }
}