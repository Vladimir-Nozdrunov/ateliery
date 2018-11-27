<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Ticket;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/profile")
 */
class ProfileController extends BaseController
{
    /**
     * @Route("/", name="profile_index")
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function info()
    {
        $user = $this->getUser();

        $createdTickets = $this->em->getRepository(Ticket::class)->countCreatedTickets($user->getId());

        $openTickets = $this->em->getRepository(Ticket::class)->countOpenTickets($user->getId());

        $closedTickets = $this->em->getRepository(Ticket::class)->countClosedTickets($user->getId());

        return $this->render('admin/profile/index.html.twig', [
            'closedTickets' => $closedTickets,
            'createdTickets' => $createdTickets,
            'openTickets' => $openTickets
        ]);
    }
}