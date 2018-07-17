<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserControllerTest extends WebTestCase
{
	private $clientUser = null;
    
    private $clientAdmin = null;


    public function setUp()
    {
        $this->clientUser = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'User1',
        'PHP_AUTH_PW'   => 'password1',
        ));

        $this->clientAdmin = static::createClient(array(), array(
        'PHP_AUTH_USER' => 'User2',
        'PHP_AUTH_PW'   => 'password2',
        ));

        $this->secondClient = static::createClient();
    }

    public function testLoginPage()
    {
        $this->secondClient->request('GET', '/login');
        $this->assertSame(200, $this->secondClient->getResponse()->getStatusCode());
    }

    public function testCreateActionAsUser()
    {
        $this->clientUser->request('GET', '/users/create', array(), array(), array(
        'PHP_AUTH_USER' => 'User1',
        'PHP_AUTH_PW'   => 'password1',
        ));
        $this->assertSame(403, $this->clientUser->getResponse()->getStatusCode());
    }

    public function testCreateActionAsAdmin()
    {    
        $crawler = $this->clientAdmin->request('GET', '/users/create', array(), array(), array(
        'PHP_AUTH_USER' => 'User2',
        'PHP_AUTH_PW'   => 'password2',
        ));

        $this->assertSame(
            Response::HTTP_OK,
            $this->clientAdmin->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'User3';
        $form['user[password][first]'] = 'password3';
        $form['user[password][second]'] = 'password3';
        $form['user[email]'] = 'user3@hotmail.fr';
        $form['user[roles][1]'] = 'ROLE_USER';
        $this->clientAdmin->submit($form);

        $crawler = $this->clientAdmin->followRedirect();
        $response = $this->clientAdmin->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("Superbe ! L\'utilisateur a bien été ajouté.")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("User3")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("user3@hotmail.fr")')->count());
    }

    public function testEditActionAsUser()
    {
        $this->clientUser->request('GET', '/users/3/edit', array(), array(), array(
        'PHP_AUTH_USER' => 'User1',
        'PHP_AUTH_PW'   => 'password1',
        ));
        $this->assertSame(403, $this->clientUser->getResponse()->getStatusCode());
    }

    public function testEditActionAsAdmin()
    {
        $crawler = $this->clientAdmin->request('GET', '/users/3/edit', array(), array(), array(
        'PHP_AUTH_USER' => 'User2',
        'PHP_AUTH_PW'   => 'password2',
        ));

        $this->assertSame(
            Response::HTTP_OK,
            $this->clientAdmin->getResponse()->getStatusCode()
        );

        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'User3';
        $form['user[password][first]'] = 'password3';
        $form['user[password][second]'] = 'password3';
        $form['user[email]'] = 'user3edit@hotmail.fr';
        $form['user[roles][1]'] = 'ROLE_USER';
        $this->clientAdmin->submit($form);
        $crawler = $this->clientAdmin->followRedirect();
        $response = $this->clientAdmin->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(1, $crawler->filter('div.alert-success:contains("Superbe ! L\'utilisateur a bien été modifié")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("User3")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("user3edit@hotmail.fr")')->count());
    }
}