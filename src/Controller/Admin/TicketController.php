<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Comment;
use App\Entity\Status;
use App\Entity\Ticket;
use App\Form\CommentType;
use App\Form\TicketType;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/ticket")
 */
class TicketController extends BaseController
{
    /**
     * @Route("/", name="ticket_index", methods="GET")
     */
    public function index(): Response
    {
        if($this->getRole() == 'ROLE_ADMIN'){
            $tickets = $this->em->getRepository(Ticket::class)->findAll();
        } elseif ($this->getRole() == 'ROLE_MANAGER'){
            $departmentId = $this->getUser()->getDepartment()->getId();
            $tickets = $this->em->getRepository(Ticket::class)->findBy(['department' => $departmentId]);
        } else {
            $userId = $this->getUser()->getId();

            $tickets = $this->em->getRepository(Ticket::class)->findBy(['assignee' => $userId]);
        }

        return $this->render('admin/ticket/index.html.twig', ['tickets' => $tickets]);
    }

    /**
     * @Route("/new", name="ticket_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $status = $this->em->getRepository(Status::class)->findOneBy(['alias' => 'open']);

        $ticket = new Ticket($this->getUser(), $status);
        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $ticket->getImg();

            if($file){
                $fileName = md5(uniqid('', true)) . '.' .$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('ticket_img_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    Response::HTTP_BAD_REQUEST;
                }

                $ticket->setImg($fileName);
            }


            $status = $this->em->getRepository(Status::class)->findOneBy(['alias' => 'open']);

            $ticket->setStatus($status);

            $this->em->persist($ticket);
            $this->em->flush();

            $this->activity->saveActivity("Создал тикет #{$ticket->getId()}", null);


            return $this->redirectToRoute('ticket_index');
        }

        return $this->render('admin/ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ticket_show", methods="GET|POST", requirements={"\+d"})
     * @param Ticket $ticket
     * @return Response
     */
    public function show(Ticket $ticket): Response
    {
        $comments = $ticket->getComments();

        $comment = new Comment($this->getUser());
        $form = $this->createForm(CommentType::class, $comment, [
            'action' => $this->generateUrl('comment_add'),
            'ticket' => $ticket->getId()
        ]);

        return $this->render('admin/ticket/show.html.twig', [
            'ticket' => $ticket,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ticket_edit", methods="GET|POST")
     */
    public function edit(Request $request, Ticket $ticket): Response
    {
        $entity = $this->em->getRepository(Ticket::class)->find($ticket->getId());
        $oldImg = $entity->getImg();

        $form = $this->createForm(TicketType::class, $ticket);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $file = $ticket->getImg();

            if($file instanceof UploadedFile){
                $fileName = md5(uniqid('', true)) . '.' .$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('ticket_img_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    Response::HTTP_BAD_REQUEST;
                }

                $ticket->setImg($fileName);
            } elseif ($file === null && $oldImg !== null){
                $ticket->setImg($oldImg);
            }
            $this->em->persist($ticket);
            $this->em->flush();

            $this->activity->saveActivity("Редактировал тикет #{$ticket->getId()}", null);

            return $this->redirectToRoute('ticket_index');
        }

        return $this->render('admin/ticket/edit.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/remove", name="ticket_remove", requirements={"\+d"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function remove($id)
    {
        $ticket = $this->get('doctrine')->getRepository(Ticket::class)->find($id);

        $this->em->remove($ticket);
        $this->activity->saveActivity("Удалил тикет #{$ticket->getId()}", null);
        $this->em->flush();

        $fileSystem = new Filesystem();

        $baseDir = $this->getParameter('ticket_img_directory');

        $imgPath = $baseDir . '/' . $ticket->getImg();

        $fileSystem->remove($imgPath);

        return $this->redirectToRoute('ticket_index');
    }

    /**
     * @Route("/change_status/{id}/{alias}", name="ticket_change_status")
     */
    public function changeStatus($id, $alias)
    {
        $ticket = $this->em->getRepository(Ticket::class)->find($id);

        $status = $this->em->getRepository(Status::class)->findOneBy(['alias' => $alias]);

        $ticket->setStatus($status);

        if($alias === 'closed'){
            $ticket->setClosedAt(new \DateTime());
        }

        $this->em->persist($ticket);

        $this->em->flush();

        $this->activity->saveActivity("Изменил статус тикета #{$ticket->getId()}", null);

        return $this->show($ticket);
    }
}
