<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/article")
 */
class ArticleController extends AbstractController
{
//    /**
//     * @Route("/", name="article_index", methods="GET")
//     */
//    public function index(): Response
//    {
//        $articles = $this->getDoctrine()
//            ->getRepository(Article::class)
//            ->findAll();
//
//        return $this->render('article/index.html.twig', ['articles' => $articles]);
//    }
//
//    /**
//     * @Route("/new", name="article_new", methods="GET|POST")
//     */
//    public function new(Request $request): Response
//    {
//        $article = new Article();
//        $form = $this->createForm(ArticleType::class, $article);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//
//            $file = $article->getPreviewImg();
//
//            $fileName = md5(uniqid('', true)) . '.' .$file->guessExtension();
//
//            try {
//                $file->move(
//                    $this->getParameter('article_img_directory'),
//                    $fileName
//                );
//            } catch (FileException $e) {
//                Response::HTTP_BAD_REQUEST;
//            }
//
//            $article->setPreviewImg($fileName);
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($article);
//            $em->flush();
//
//            return $this->redirectToRoute('article_index');
//        }
//
//        return $this->render('article/new.html.twig', [
//            'article' => $article,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}", name="article_show", methods="GET")
//     */
//    public function show(Article $article): Response
//    {
//        return $this->render('article/show.html.twig', ['article' => $article]);
//    }
//
//    /**
//     * @Route("/{id}/edit", name="article_edit", methods="GET|POST")
//     */
//    public function edit(Request $request, Article $article): Response
//    {
//        $entity = $this->get('doctrine')->getRepository(Article::class)->find($article->getId());
//        $oldImg = $entity->getPreviewImg();
//
//        $form = $this->createForm(ArticleType::class, $article);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $file = $article->getPreviewImg();
//
//            if($file instanceof UploadedFile){
//                $fileName = md5(uniqid('', true)) . '.' .$file->guessExtension();
//
//                try {
//                    $file->move(
//                        $this->getParameter('article_img_directory'),
//                        $fileName
//                    );
//                } catch (FileException $e) {
//                    Response::HTTP_BAD_REQUEST;
//                }
//
//                $article->setPreviewImg($fileName);
//            } elseif ($file === null && $oldImg !== null){
//                $article->setPreviewImg($oldImg);
//            }
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($article);
//            $em->flush();
//
//            return $this->redirectToRoute('article_index');
//        }
//
//        return $this->render('article/edit.html.twig', [
//            'article' => $article,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/remove/{id}", name="article_remove")
//     * @param $id
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse
//     */
//    public function remove(EntityManagerInterface $em, $id){
//        $article = $this->get('doctrine')->getRepository(Article::class)->find($id);
//
//        $em->remove($article);
//        $em->flush();
//
//        $fileSystem = new Filesystem();
//
//        $baseDir = $this->getParameter('article_img_directory');
//
//        $imgPath = $baseDir . '/' . $article->getPreviewImg();
//
//        $fileSystem->remove($imgPath);
//
//        return $this->redirectToRoute('article_index');
//    }
}
