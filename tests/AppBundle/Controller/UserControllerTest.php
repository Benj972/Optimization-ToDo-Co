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

    public function testLoginPage()
    {
        $this->clientNotLoged->request('GET', '/login');
        $this->assertSame(200, $this->clientNotLoged->getResponse()->getStatusCode());
    }

    public function testListActionNotLoged()
    {
        $this->clientNotLoged->request('GET', '/users');
        $crawler = $this->clientNotLoged->followRedirect();
        $this->assertEquals(200, $this->clientNotLoged->getResponse()->getStatusCode());
        $this->assertEquals(1, $crawler->filter('html:contains("Se connecter")')->count());
    }

    public function testListActionUser()
    {
        $this->clientUser->request('GET', '/users');
        $this->assertSame(403, $this->clientUser->getResponse()->getStatusCode());
    }

    public function testListActionAdmin()
    {
        $crawler = $this->clientAdmin->request('GET', '/users');
        $this->assertSame(200, $this->clientAdmin->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Liste des utilisateurs")')->count());
    }

    public function testCreateButtonAdmin()
    {
        $crawler = $this->clientAdmin->request('GET', '/');
        $link = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $this->clientAdmin->click($link);
        $this->assertSame(200, $this->clientAdmin->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer un utilisateur")')->count());
        $this->assertSame(1, $crawler->filter('form')->count());
    }

    public function testCreateButtonUser()
    {
        $crawler = $this->clientUser->request('GET', '/');
        $link = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $this->clientUser->click($link);
        $this->assertSame(403, $this->clientUser->getResponse()->getStatusCode());
    }

    public function testCreateActionAsUser()
    {
        $this->clientUser->request('GET', '/users/create');
        $this->assertSame(403, $this->clientUser->getResponse()->getStatusCode());
    }

    public function testCreateActionAsAdmin()
    {    
        $crawler = $this->clientAdmin->request('GET', '/users/create');
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

    public function testCreateActionEmptyUsername()
    {
        $crawler = $this->clientAdmin->request('GET', '/users/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'test1@hotmail.fr';
        $form['user[roles][1]'] = 'ROLE_USER';
        $crawler = $this->clientAdmin->submit($form);
        $this->assertSame(1, $crawler->filter('html:contains("Créer un utilisateur")')->count());
    }

    public function testCreateActionEmptyEmail()
    {
        $crawler = $this->clientAdmin->request('GET', '/users/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'User';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[roles][1]'] = 'ROLE_USER';
        $crawler = $this->clientAdmin->submit($form);
        $this->assertSame(1, $crawler->filter('html:contains("Créer un utilisateur")')->count());
    }

    public function testCreateActionNonUniqueEmail()
    {
        $crawler = $this->clientAdmin->request('GET', '/users/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'User';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'user1@hotmail.fr';
        $form['user[roles][1]'] = 'ROLE_USER';
        $crawler = $this->clientAdmin->submit($form);
        $this->assertSame(1, $crawler->filter('html:contains("Cet email est déjà utilisé par un utilisateur.")')->count());
    }

    public function testEditActionAsUser()
    {
        $this->clientUser->request('GET', '/users/3/edit');
        $this->assertSame(403, $this->clientUser->getResponse()->getStatusCode());
    }

    public function testEditActionAsAdmin()
    {
        $crawler = $this->clientAdmin->request('GET', '/users/3/edit');
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

    public function testDeleteActionAsUser()
    {
        $this->clientUser->request('GET', '/users/2/delete');
        $this->assertSame(403, $this->clientUser->getResponse()->getStatusCode());
    }

    public function testDeleteActionAsAdmin()
    {
        $this->clientAdmin->request('GET', '/users/3/delete');
        $this->assertSame(200, $this->clientAdmin->getResponse()->getStatusCode());
    }
}