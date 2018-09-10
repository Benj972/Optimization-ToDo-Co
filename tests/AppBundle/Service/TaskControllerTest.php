<?php

namespace tests\AppBundle\Service;

use PHPUnit\Framework\TestCase;
use AppBundle\Controller\TaskController;
use AppBundle\Entity\Task;

class TaskControllerTest extends TestCase
{
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