<?php

namespace App\Event;

use App\Entity\User;
use Symfony\Contracts\EventDispatcher\Event;

class RegistrationEvent extends Event
{
    const NAME = 'register.user';
    /**
     * @var User $user
     */
    private $user;
    /**
     * RegistrationEvent constructor.
     * @param User $registeredUser
     */
    public function __construct(User $registeredUser)
    {
        $this->user = $registeredUser;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }


}