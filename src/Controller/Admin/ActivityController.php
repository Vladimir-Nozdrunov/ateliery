<?php

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Entity\Activity;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/activity")
 */
class ActivityController extends BaseController
{
    /**
     * @Route("/", name="activity_index")
     */
    public function getActivity()
    {
        $activity = $this->em->getRepository(Activity::class)->findAll();

        return $this->render('admin/activity/index.html.twig',
            [
                'activities' => $activity
            ]);
    }
}