<?php

namespace Tests\AppBundle\Command;

use AppBundle\Command\ParseCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class ParseCommandTest extends KernelTestCase
{

    public function testExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new ParseCommand());

        $command = $application->find('app:parse');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),
            '--pages' => '1',
        ));

        $output = $commandTester->getDisplay();
        $this->assertEquals('', $output);
    }
}