<?php

namespace tests\AppBundle\Handler;

use PHPUnit\Framework\TestCase;
use AppBundle\Controller\TaskController;
use AppBundle\Entity\Task;
use Symfony\Component\Form\FormInterface;

class TaskControllerTest extends TestCase
{
	public function testCreateAction()
	{
        $form = $this
            ->getMockBuilder(FormInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $createTasks = $this
            ->getMockBuilder('AppBundle\Handler\CreateHandler')
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
        $createTasks
            ->expects($this->once())
            ->method('handle')
            ->willReturn(true);
       
        $this->assertInternalType('bool', $createTasks->handle($form, new Task()));
	}

    public function testEditAction()
    {
        $form = $this
            ->getMockBuilder(FormInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $editTasks = $this
            ->getMockBuilder('AppBundle\Handler\EditHandler')
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
        $editTasks
            ->expects($this->once())
            ->method('handle')
            ->willReturn(true);
       
        $this->assertInternalType('bool', $editTasks->handle($form)); 
    }
}