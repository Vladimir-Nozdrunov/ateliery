<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Order;
use App\Entity\Status;
use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/order")
 */
class OrderController extends BaseController
{
    /**
     * @Route("/", name="admin_order_index")
     */
    public function index(){
        if($this->getRole() == 'ROLE_ADMIN'){
            $orders = $this->em->getRepository(Order::class)->findBy([], ['id' => 'DESC']);
        } elseif ($this->getRole() == 'ROLE_MANAGER'){
            $departmentId = $this->getUser()->getDepartment()->getId();
            $orders = $this->em->getRepository(Order::class)->findBy(['department' => $departmentId], ['id' => 'DESC']);
        } else {
            $userId = $this->getUser()->getId();

            $orders = $this->em->getRepository(Order::class)->findBy(['assignee' => $userId], ['id' => 'DESC']);
        }

        return $this->render('admin/order/index.html.twig', ['orders' => $orders]);
    }

    /**
     * @Route("/convert/{id}", name="convert_to_ticket")
     */
    public function convertToTicket($id)
    {
        $order = $this->em->getRepository(Order::class)->find($id);

        $status = $this->em->getRepository(Status::class)->findOneBy(['alias' => 'open']);

        $ticket = new Ticket($this->getUser(), $status);

        $department = $order->getDepartment();

        $manager = $this->em->getRepository(User::class)->findOneBy(['department' => $department->getId(), 'roles' => 'ROLE_MANAGER']);

        $ticket->setAssignee($manager);

        $ticket->setDepartment($department);

        $ticket->setDueDate($order->getDueDate());

        $ticket->setTitle('Доставлено в отделение');

        $ticket->setInfo($order->getInfo());

        $status = $this->em->getRepository(Status::class)->findOneBy(['alias' => 'closed']);

        $order->setStatus($status);

        $this->em->persist($order);
        $this->em->persist($ticket);
        $this->em->flush();

        $this->activity->saveActivity("Перевел заказ (#{$order->getId()}) в статус тикета(#{$ticket->getId()})", null);

        return $this->index();
    }
}