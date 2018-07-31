<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskControllerTest extends WebTestCase
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

    public function testListActionNotLoged()
    {
        $this->clientNotLoged->request('GET', '/tasks');
        $crawler = $this->clientNotLoged->followRedirect();
        $this->assertSame(200, $this->clientNotLoged->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Se connecter")')->count());
    }

    public function testListButtonUser()
    {
        $crawler = $this->clientUser->request('GET', '/');
        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $crawler = $this->clientUser->click($link);
        $this->assertSame(200, $this->clientUser->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer une tâche")')->count());
    }

    public function testListButtonAdmin()
    {
        $crawler = $this->clientAdmin->request('GET', '/');
        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $crawler = $this->clientAdmin->click($link);
        $this->assertSame(200, $this->clientAdmin->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer une tâche")')->count());
    }

    
    public function testListActionAdmin()
    {
        $crawler = $this->clientAdmin->request('GET', '/tasks');
        $this->assertSame(200, $this->clientAdmin->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer une tâche")')->count());
    }

    public function testListActionUser()
    {
        $crawler = $this->clientUser->request('GET', '/tasks');
        $this->assertSame(200, $this->clientUser->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Créer une tâche")')->count());
    }

    public function testCreateButtonUser()
    {
        $crawler = $this->clientUser->request('GET', '/');
        $link = $crawler->selectLink('Créer une nouvelle tâche')->link();
        $crawler = $this->clientUser->click($link);
        $this->assertSame(200, $this->clientUser->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Ajouter")')->count());
        $this->assertSame(1, $crawler->filter('form')->count());
    }

    public function testCreateButtonAdmin()
    {
        $crawler = $this->clientAdmin->request('GET', '/');
        $link = $crawler->selectLink('Créer une nouvelle tâche')->link();
        $crawler = $this->clientAdmin->click($link);
        $this->assertSame(200, $this->clientAdmin->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Ajouter")')->count());
        $this->assertSame(1, $crawler->filter('form')->count());
    }

    public function testCreateActionUser()
    {
        $crawler = $this->clientUser->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'New task';
        $form['task[content]'] = 'New task content';
        $this->clientUser->submit($form);
        $crawler = $this->clientUser->followRedirect();
        $response = $this->clientUser->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("New task")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("New task content")')->count());
    }

    public function testCreateActionAdmin()
    {
        $crawler = $this->clientAdmin->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'New task';
        $form['task[content]'] = 'New task content';
        $this->clientAdmin->submit($form);
        $crawler = $this->clientAdmin->followRedirect();
        $response = $this->clientAdmin->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("New task")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("New task content")')->count());
    }

    public function testEditActionUser()
    {
        $crawler = $this->clientUser->request('GET', '/tasks/3/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Task3edit';
        $form['task[content]'] = 'Task3edit content';
        $this->clientUser->submit($form);
        $crawler = $this->clientUser->followRedirect();
        $response = $this->clientUser->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Task3edit")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Task3edit content")')->count());
    }
    
    public function testEditActionAdmin()
    {
        $crawler = $this->clientAdmin->request('GET', '/tasks/5/edit');
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'Task5edit';
        $form['task[content]'] = 'Task5edit content';
        $this->clientAdmin->submit($form);
        $crawler = $this->clientAdmin->followRedirect();
        $response = $this->clientAdmin->getResponse();
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame(1, $crawler->filter('html:contains("Task3edit")')->count());
        $this->assertSame(1, $crawler->filter('html:contains("Task3edit content")')->count());
    }

    public function testEditActionOtherUser()
    {
        $crawler = $this->clientUser->request('GET', '/tasks/1/edit');
        $response = $this->clientUser->getResponse();
        $this->assertSame(403, $response->getStatusCode());
    }

    public function testToggleUndone()
    {
        $this->clientUser->request('GET', '/tasks/3/toggle');
        $this->clientUser->followRedirect();
        $response = $this->clientUser->getResponse();
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testToggleDone()
    {
        $this->clientUser->request('GET', '/tasks/6/toggle');
        $this->clientUser->followRedirect();
        $response = $this->clientUser->getResponse();
        $this->assertSame(200, $response->getStatusCode());
    }
    
    public function testDeleteActionUser()
    {
        $crawler = $this->clientUser->request('GET', '/tasks/4/delete');
        $this->assertSame(302, $this->clientUser->getResponse()->getStatusCode());
        $crawler = $this->clientUser->followRedirect();
        $this->assertSame(200, $this->clientUser->getResponse()->getStatusCode());
    }

    public function testDeleteActionAdmin()
    {
        $this->clientAdmin->request('GET', '/tasks/5/delete');
        $this->clientAdmin->followRedirect();
        $response = $this->clientAdmin->getResponse();
        $this->assertSame(200, $response->getStatusCode());
    }

    public function testDeleteActionOtherUser()
    {
        $this->clientAdmin->request('GET', '/tasks/3/delete');
        $response = $this->clientAdmin->getResponse();
        $this->assertSame(403, $response->getStatusCode());
    }
}
