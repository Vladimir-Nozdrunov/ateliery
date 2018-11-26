<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin/user")
 */
class UserController extends BaseController
{
    /**
     * @Route("/", name="user_index", methods="GET")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('/admin/user/index.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/new", name="user_new", methods="GET|POST")
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function new(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $roles = $form->get('roles')->getData();
            $user->setRoles($roles);

            $pass = $form->get('password')->getData();

            $encoded = $encoder->encodePassword($user, $pass);

            $user->setPassword($encoded);

            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods="GET")
     */
    public function show(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods="GET|POST")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', ['id' => $user->getId()]);
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/remove", name="user_remove", requirements={"\+d"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function remove($id)
    {
        $user = $this->get('doctrine')->getRepository(User::class)->find($id);

        $user->setIsActive(false);

        $this->em->persist($user);
        $this->em->flush();


        return $this->redirectToRoute('user_index');
    }

//    /**
//     * @Route("/test")
//     * @param UserPasswordEncoderInterface $encoder
//     * @return JsonResponse
//     */
//    public function test(UserPasswordEncoderInterface $encoder)
//    {
//        $user = new User();
//
//        $user->setUsername('admin');
//        $pass = 'Pass4Toppik';
//
//        $encoded = $encoder->encodePassword($user, $pass);
//
//        $user->setPassword($encoded);
//
//        $this->em->persist($user);
//
//        $this->em->flush();
//
//        return new JsonResponse('okay', 200);
//    }
}