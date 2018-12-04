<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Comment;
use App\Entity\Ticket;
use App\Form\CommentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/comment")
 */
class CommentController extends BaseController
{
    /**
     * @Route("/add", name="comment_add")
     */
    public function addComment(Request $request)
    {
        $comment = new Comment($this->getUser());
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        $ticketId = $form->get('ticket')->getData();

        $ticket = $this->em->getRepository(Ticket::class)->find($ticketId);



        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setTicket($ticket);

            $this->em->persist($comment);
            $this->em->flush();

            $this->activity->saveActivity("Добавил комментарий к тикету #{$ticket->getId()}", null);

            return $this->redirectToRoute('ticket_show', ['id' => $ticketId]);
        }

        return $this->render('admin/ticket/new.html.twig', [
            'ticket' => $ticket,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/remove", name="comment_remove", requirements={"\+d"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function remove($id)
    {
        $comment = $this->em->getRepository(Comment::class)->find($id);

        $ticket = $comment->getTicket();

        $this->em->remove($comment);
        $this->em->flush();

        $this->activity->saveActivity("Удалил комментарий в тикете #{$ticket->getId()}", null);

        return $this->redirectToRoute('ticket_show', ['id' => $comment->getTicket()->getId()]);
    }
}