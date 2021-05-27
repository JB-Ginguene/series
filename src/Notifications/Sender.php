<?php


namespace App\Notifications;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class Sender
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager=$entityManager;
    }


    public function sendNewUserToAdmin(User $user)
    {

        file_put_contents('notif.txt', $user->getFirstname());
    }

}