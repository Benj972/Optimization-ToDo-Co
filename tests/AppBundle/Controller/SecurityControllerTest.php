<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityControllerTest extends WebTestCase
{
	private $client = null;

	private $clientUser = null;

    public function setUp()
    {
        $this->client = static::createClient();

        $this->clientUser = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'User1',
        'PHP_AUTH_PW'   => 'password1',
        ));
    }
	
	public function testLoginAction()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('form')->count());
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'User1';
        $form['_password'] = 'password1';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('html:contains("Bienvenue sur Todo List")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Consulter la liste des tâches à faire")')->count());
    }

    public function testBadCredentials()
    {
        $crawler = $this->client->request('GET', '/login');
        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('form')->count());
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'user';
        $form['_password'] = 'password';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert-danger:contains("Invalid credentials")')->count());
    }

    public function testLogout()
    {
        $this->clientUser->request('GET', '/logout');

        $response = $this->clientUser->getResponse();
        $this->assertSame(302, $response->getStatusCode());
        $this->clientUser->followRedirect();
        $this->assertSame(200, $this->clientUser->getResponse()->getStatusCode());
    }
}