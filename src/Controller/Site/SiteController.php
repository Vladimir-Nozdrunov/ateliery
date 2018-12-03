<?php

namespace App\Controller\Site;

use App\Controller\BaseController;
use App\Entity\Department;
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
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $client = new User();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $client->setRoles('ROLE_CLIENT');

            $client->setDepartment(null);

            $pass = $form->get('password')->getData();

            $encoded = $encoder->encodePassword($client, $pass);

            $client->setPassword($encoded);

            $this->em->persist($client);
            $this->em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('site/client/registration.html.twig', [
            'user' => $client,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/client/profile", name="client_profile")
     */
    public function clientProfile()
    {
        $user = $this->getUser();
        return $this->render('site/client/profile.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/departments", name="site_departments")
     */
    public function indexDepartments()
    {
        $departments = $this->em->getRepository(Department::class)->findAll();

        return $this->render('site/departments.html.twig', [
           'departments' => $departments
        ]);
    }
}