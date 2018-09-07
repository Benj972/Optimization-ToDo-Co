<?php

namespace tests\Security\TaskVoterTest;

use PHPUnit\Framework\TestCase;
use AppBundle\Security\TaskVoter;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class TaskVoterTest extends TestCase
{
	private $decisionManager;

	private $tokenInterface;

	const EDIT = 'edit';

	public function setUp()
	{
		$this->decisionManager = $this
            ->getMockBuilder(AccessDecisionManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->tokenInterface = $this
            ->getMockBuilder(TokenInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
	}

	public function testSupports()
	{
		$attribute = self::EDIT;
		$subject = new Task();

		$voter = new TaskVoter($this->decisionManager);
		$method = new \ReflectionMethod('AppBundle\Security\TaskVoter', 'supports');
		$method->setAccessible(true);

		$this->assertInternalType('bool', $method->invoke($voter, $attribute, $subject));
		$this->assertSame(true, $method->invoke($voter, $attribute, $subject));
	}

	public function testVoteOnAttribute()
	{
		$attribute = self::EDIT;
		$subject = new Task();

		$voter = new TaskVoter($this->decisionManager);
		$method = new \ReflectionMethod('AppBundle\Security\TaskVoter', 'voteOnAttribute');
		$method->setAccessible(true);

		$this->assertInternalType('bool', $method->invoke($voter, $attribute, $subject, $this->tokenInterface));
	}	

	public function testCanEdit()
	{
		$task = new Task();
		$user = new User();
		$task->setUser($user);

		$voter = new TaskVoter($this->decisionManager);
		$method = new \ReflectionMethod('AppBundle\Security\TaskVoter', 'canEdit');
		$method->setAccessible(true);

		$this->assertInternalType('bool', $method->invoke($voter, $task, $user));
		$this->assertSame(true, $method->invoke($voter, $task, $user));
	}

	public function testcanDelete()
	{
		$task = new Task();
		$user = new User();
		$task->setUser($user);

        $voter = new TaskVoter($this->decisionManager);
		$method = new \ReflectionMethod('AppBundle\Security\TaskVoter', 'canDelete');
		$method->setAccessible(true);

		$this->assertInternalType('bool', $method->invoke($voter, $task, $user, $this->tokenInterface));
		$this->assertSame(true, $method->invoke($voter, $task, $user, $this->tokenInterface));
	}
}