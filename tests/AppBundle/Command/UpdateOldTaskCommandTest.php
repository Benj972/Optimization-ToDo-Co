<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\UpdateOldTaskCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class UpdateOldTaskCommandTest extends KernelTestCase
{
    public function testExecute()
    {
        $kernel = self::bootKernel();
        $kernel->boot();

        $application = new Application($kernel);
        $command = $application->find('demo:load');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),

            // pass arguments to the helper
            'anonymous' => 'anonymous',
        ));

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('OLD TASKS UPDATE', $output);
    }
}
