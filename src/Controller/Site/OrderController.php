<?php

namespace App\Controller\Site;

use App\Controller\BaseController;
use App\Entity\Department;
use App\Entity\Order;
use App\Entity\Status;
use App\Entity\Ticket;
use App\Entity\User;
use App\Form\OrderType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client/order")
 */
class OrderController extends BaseController
{
    /**
     * @Route("/", name="order_index")
     */
    public function index()
    {
        $orders = $this->em->getRepository(Order::class)->findBy(['client' => $this->getUser()]);

        return $this->render('site/order/index.html.twig',[
            'orders' => $orders
        ]);
    }

    /**
     * @Route("/create", name="order_new")
     */
    public function new(Request $request)
    {
        $status = $this->em->getRepository(Status::class)->findOneBy(['alias' => 'open']);

        $order = new Order($this->getUser(), $status);
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $address = $form->get('address')->getData();

            $coordinates = $this->getCoordinates($address);

            $order->setLat($coordinates['lat']);
            $order->setLng($coordinates['lng']);
            $order->setAddress($address);

            $departments = $this->em->getRepository(Department::class)->findAll();

            foreach ($departments as $item){
                $data[$item->getId()][] = $this->haversin->calculate($order->getLat(), $order->getLng(), $item->getLat(), $item->getLng());
            }

            $departmentId = array_keys($data, min($data));

            $departmentId = $departmentId[0];

            $department = $this->em->getRepository(Department::class)->find($departmentId);

            $client = $this->getUser();

            $client->setDepartment($department);

            $this->em->persist($client);

            if($form->get('self_delivery')->getData() == true){

                $managers = $this->em->getRepository(User::class)->findBy(['roles' => 'ROLE_MANAGER']);

                $managerId = $managers[0];

                $assignee = $this->em->getRepository(User::class)->find($managerId);

            } else {
                $couriers = $this->em->getRepository(User::class)->findBy(['department' => $departmentId, 'roles' => 'ROLE_COURIER']);

                foreach ($couriers as $courier){
                    $tasks[$courier->getId()][] = $courier->getOrder();
                }

                $courierId = array_keys($tasks, min($tasks));

                $courierId = $courierId[0];

                $assignee = $this->em->getRepository(User::class)->find($courierId);
            }

            $order->setAssignee($assignee);

            $order->setDepartment($department);

            $this->em->persist($order);
            $this->em->flush();

            return $this->redirectToRoute('client_profile');
        }

        return $this->render('site/order/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}