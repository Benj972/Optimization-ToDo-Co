<?php

namespace tests\AppBundle\Service;

use PHPUnit\Framework\TestCase;
use AppBundle\Controller\UserController;
use AppBundle\Entity\User;

class UserControllerTest extends TestCase
{
	public function testDeleteAction()
	{
		$deleteUsers = $this
            ->getMockBuilder('AppBundle\Service\DeleteManager')
            ->disableOriginalConstructor()
            ->setMethods(['delete'])
            ->getMock();
        $deleteUsers
            ->expects($this->once())
            ->method('delete')
            ->willReturn(NULL);

        $this->assertNull($deleteUsers->delete(new User()));
	}
}