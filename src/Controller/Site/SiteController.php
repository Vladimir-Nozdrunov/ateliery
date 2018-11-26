<?php

namespace App\Controller\Site;

use App\Controller\BaseController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SiteController extends BaseController
{
    /**
     * @Route("/menu", name="menu")
     */
    public function menu()
    {

    }

    /**
     * @Route("/", name="site_index")
     */
    public function index()
    {
        $a = 'gsge';

        return new JsonResponse($a, 200);
    }
}