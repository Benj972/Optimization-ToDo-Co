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

    public function testDeleteAction()
    {
        $deleteTasks = $this
            ->getMockBuilder('AppBundle\Service\DeleteManager')
            ->disableOriginalConstructor()
            ->setMethods(['delete'])
            ->getMock();
        $deleteTasks
            ->expects($this->once())
            ->method('delete')
            ->willReturn(NULL);

        $this->assertNull($deleteTasks->delete(new Task()));
    }

    public function testToggleTaskAction()
    {
        $toggleTasks = $this
            ->getMockBuilder('AppBundle\Service\ToggleTask')
            ->disableOriginalConstructor()
            ->setMethods(['switch'])
            ->getMock();
        $toggleTasks
            ->expects($this->once())
            ->method('switch')
            ->willReturn(NULL);

        $this->assertNull($toggleTasks->switch(new Task()));
    }
}