<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\Volume;
use App\Form\ProductType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{
//    /**
//     * @Route("/", name="product_index", methods="GET")
//     */
//    public function index(): Response
//    {
//        $products = $this->getDoctrine()
//            ->getRepository(Product::class)
//            ->findAll();
//
//        return $this->render('product/index.html.twig', ['products' => $products]);
//    }
//
//    /**
//     * @Route("/new", name="product_new", methods="GET|POST")
//     */
//    public function new(Request $request): Response
//    {
//        $product = new Product();
//        $form = $this->createForm(ProductType::class, $product);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $file = $product->getImg();
//
//            $fileName = md5(uniqid('', true)) . '.' .$file->guessExtension();
//
//            try {
//                $file->move(
//                    $this->getParameter('product_img_directory'),
//                    $fileName
//                );
//            } catch (FileException $e) {
//                Response::HTTP_BAD_REQUEST;
//            }
//
//            $product->setImg($fileName);
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($product);
//            $em->flush();
//
//            return $this->redirectToRoute('product_index');
//        }
//
//        return $this->render('product/new.html.twig', [
//            'product' => $product,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}", name="product_show", methods="GET")
//     */
//    public function show(Product $product): Response
//    {
//        $volumes = $this->get('doctrine')->getRepository(Volume::class)->findBy(['product' => $product->getId()]);
//
//        return $this->render('product/show.html.twig', [
//            'product' => $product,
//            'volumes' => $volumes
//        ]);
//    }
//
//    /**
//     * @Route("/{id}/edit", name="product_edit", methods="GET|POST")
//     */
//    public function edit(Request $request, Product $product): Response
//    {
//        $entity = $this->get('doctrine')->getRepository(Product::class)->find($product->getId());
//        $oldImg = $entity->getImg();
//
//        $form = $this->createForm(ProductType::class, $product);
//        $form->handleRequest($request);
//
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $file = $product->getImg();
//
//            if($file instanceof UploadedFile){
//                $fileName = md5(uniqid('', true)) . '.' .$file->guessExtension();
//
//                try {
//                    $file->move(
//                        $this->getParameter('product_img_directory'),
//                        $fileName
//                    );
//                } catch (FileException $e) {
//                    Response::HTTP_BAD_REQUEST;
//                }
//
//                $product->setImg($fileName);
//            } elseif ($file === null && $oldImg !== null){
//                $product->setImg($oldImg);
//            }
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($product);
//            $em->flush();
//
//            return $this->redirectToRoute('product_index');
//        }
//
//        return $this->render('product/edit.html.twig', [
//            'product' => $product,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/remove/{id}", name="product_remove")
//     * @param $id
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function remove(EntityManagerInterface $em, $id){
//        $product = $this->get('doctrine')->getRepository(Product::class)->find($id);
//
//        $em->remove($product);
//        $em->flush();
//
//        $fileSystem = new Filesystem();
//
//        $baseDir = $this->getParameter('product_img_directory');
//
//        $imgPath = $baseDir . '/' . $product->getImg();
//
//        $fileSystem->remove($imgPath);
//
//        return $this->redirectToRoute('product_index');
//    }
}
