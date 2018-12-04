<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Department;
use App\Form\DepartmentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/department")
 */
class DepartmentController extends BaseController
{
    /**
     * @Route("/", name="department_index", methods="GET")
     */
    public function index(): Response
    {
        $departments = $this->getDoctrine()
            ->getRepository(Department::class)
            ->findAll();

        return $this->render('admin/department/index.html.twig', ['departments' => $departments]);
    }

    /**
     * @Route("/new", name="department_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $department = new Department();
        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $address = $form->get('address')->getData();

            $coordinates = $this->getCoordinates($address);

            $department->setLat($coordinates['lat']);
            $department->setLng($coordinates['lng']);

            $em->persist($department);
            $em->flush();

            $this->activity->saveActivity("Создал новое отделение - {$department->getAddress()}", null);

            return $this->redirectToRoute('department_index');
        }

        return $this->render('admin/department/new.html.twig', [
            'department' => $department,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="department_show", methods="GET")
     */
    public function show(Department $department): Response
    {
        return $this->render('admin/department/show.html.twig', ['department' => $department]);
    }

    /**
     * @Route("/{id}/edit", name="department_edit", methods="GET|POST")
     */
    public function edit(Request $request, Department $department): Response
    {
        $form = $this->createForm(DepartmentType::class, $department);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $address = $form->get('address')->getData();

            $coordinates = $this->getCoordinates($address);

            $department->setLat($coordinates['lat']);
            $department->setLng($coordinates['lng']);

            $this->getDoctrine()->getManager()->flush();

            $this->activity->saveActivity("Редактировал отделение - {$department->getAddress()}", null);

            return $this->redirectToRoute('department_index', ['id' => $department->getId()]);
        }

        return $this->render('admin/department/edit.html.twig', [
            'department' => $department,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/remove", name="department_remove", requirements={"\+d"})
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function remove($id)
    {
        $department = $this->get('doctrine')->getRepository(Department::class)->find($id);

        $this->em->remove($department);
        $this->em->flush();

        $this->activity->saveActivity("Удалил отделение - {$department->getAddress()}", null);

        return $this->redirectToRoute('ticket_index');
    }
}
