<?php

namespace tests\AppBundle\Handler;

use PHPUnit\Framework\TestCase;
use AppBundle\Controller\TaskController;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
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
            ->getMockBuilder('AppBundle\Handler\CreateTaskHandler')
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
            ->getMockBuilder('AppBundle\Handler\EditTaskHandler')
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
        $editTasks
            ->expects($this->once())
            ->method('handle')
            ->willReturn(true);
       
        $this->assertInternalType('bool', $editTasks->handle($form)); 
    }

    public function testDeleteAction()
    {
        $deleteTasks = $this
            ->getMockBuilder('AppBundle\Handler\DeleteTaskHandler')
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
        $deleteTasks
            ->expects($this->once())
            ->method('handle')
            ->willReturn(NULL);

        $this->assertNull($deleteTasks->handle(new Task()));
    }

    public function testToggleTaskAction()
    {
        $toggleTasks = $this
            ->getMockBuilder('AppBundle\Handler\ToggleTaskHandler')
            ->disableOriginalConstructor()
            ->setMethods(['handle'])
            ->getMock();
        $toggleTasks
            ->expects($this->once())
            ->method('handle')
            ->willReturn(NULL);

        $this->assertNull($toggleTasks->handle(new Task()));
    }
}