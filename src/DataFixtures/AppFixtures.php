<?php

namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\Status;
use App\Entity\Ticket;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $status = $manager->getRepository(Status::class)->findOneBy(['alias' => 'open']);

        $users = $manager->getRepository(User::class)->findAll();

        $departments = $manager->getRepository(Department::class)->findAll();

        foreach ($users as $user){

            $ticket = new Ticket($user, $status);
            foreach ($departments as $department){
                $ticket->setDepartment($department);
            }

            $ticket->setStatus($status);

            $manager->persist($ticket);
        }

        for ($i = 0; $i < 20; $i++) {

        }

        $manager->flush();
    }
}
