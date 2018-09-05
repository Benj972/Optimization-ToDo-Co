<?php

namespace tests\AppBundle\Handler;

use PHPUnit\Framework\TestCase;
use AppBundle\Controller\UserController;
use AppBundle\Entity\User;
use Symfony\Component\Form\FormInterface;

class UserControllerTest extends TestCase
{
	public function testCreateAction()
	{
        $form = $this
            ->getMockBuilder(FormInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $createUsers = $this
            ->getMockBuilder('AppBundle\Handler\CreateUserHandler')
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
        $createUsers
            ->expects($this->once())
            ->method('handle')
            ->willReturn(true);
       
        $this->assertInternalType('bool', $createUsers->handle($form, new User()));
	}

	public function testEditAction()
	{
        $form = $this
            ->getMockBuilder(FormInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $editUsers = $this
            ->getMockBuilder('AppBundle\Handler\EditUserHandler')
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
        $editUsers
            ->expects($this->once())
            ->method('handle')
            ->willReturn(true);
       
        $this->assertInternalType('bool', $editUsers->handle($form));
	}

	public function testDeleteAction()
	{
		$deleteUsers = $this
            ->getMockBuilder('AppBundle\Handler\DeleteUserHandler')
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
        $deleteUsers
            ->expects($this->once())
            ->method('handle')
            ->willReturn(NULL);

        $this->assertNull($deleteUsers->handle(new User()));
	}
}