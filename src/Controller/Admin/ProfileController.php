<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Ticket;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/profile", name="profile_index")
 */
class ProfileController extends BaseController
{
    /**
     * @Route("/")
     */
    public function info()
    {
        $user = $this->getUser()->getId();

        $myTickets = $this->em->getRepository(Ticket::class)->findBy(['assignee' => $user]);
    }
}