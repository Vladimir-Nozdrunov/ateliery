<?php

namespace App\Controller\Site;

use App\Controller\BaseController;
use App\Entity\Client;
use App\Entity\User;
use App\Form\ClientType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SiteController extends BaseController
{
    /**
     * @Route("/", name="site_index")
     */
    public function index()
    {
        return $this->render('site/main.html.twig');
    }

    /**
     * @Route("/registration", name="site_registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new Client();
        $form = $this->createForm(ClientType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setRoles('ROLE_CLIENT');

            $pass = $form->get('password')->getData();

            $encoded = $encoder->encodePassword($user, $pass);

            $user->setPassword($encoded);

            $this->em->persist($user);
            $this->em->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('site/client/registration.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login()
    {
        return $this->forward('App\Controller\SecurityController::login');
    }
}