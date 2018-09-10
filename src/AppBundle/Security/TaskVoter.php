<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class TaskVoter extends Voter
{
    /**
     * @var string Should contain a description
     */
    const EDIT = 'edit';

    /**
     * @var string Should contain a description
     */
    const DELETE = 'delete';

    /**
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;

    /**
     * TaskVoter constructor.
     * @param AccessDecisionManagerInterface $decisionManager
     */
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }

    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, array(self::EDIT, self::DELETE))) {
            return false;
        }
        // only vote on Task objects inside this voter
        if (!$subject instanceof Task) {
            return false;
        }
        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        // you know $subject is a Task object, thanks to supports
        /** @var Task $task */
        $task = $subject;

        switch ($attribute) {
            case self::EDIT:
                return $this->canEdit($task, $user);
            case self::DELETE:
                return $this->canDelete($task, $user, $token);
        }
        throw new \LogicException('This code should not be reached!');
    }

    /*
     * The user can edit a task he has created
     * @param Task $task
     * @param User $user
     *
     * @return bool|null true or null if he is not the good user
     */
    private function canEdit(Task $task, User $user)
    {
        if ($task->getUser()===$user) {
            return true;
        }
    }

    /*
     * The user can delete a task he has created
     * @param Task $task
     * @param User $user
     * @param TokenInterface $token
     */
    private function canDelete(Task $task, User $user, TokenInterface $token)
    {
        return $this->canEdit($task, $user) || ($this->decisionManager->decide($token, array('ROLE_ADMIN')) && $task->isAnonymous());
    }
}
