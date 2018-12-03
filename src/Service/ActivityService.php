<?php

namespace App\Service;

use App\Controller\BaseController;
use App\Entity\Activity;

class ActivityService extends BaseController
{
    public function linkItem($object, $path)
    {
        return "<a href={$path} target='_blank'>{$object}</a>";
    }

    public function compareChanges($entity)
    {
        $uow = $this->em->getUnitOfWork();
        $uow->computeChangeSets();

        $changeset = $uow->getEntityChangeSet($entity);

        foreach ($changeset as $key => $value) {
            $changes[][$key] = $value;
        }

        return $changes;
    }

    public function saveActivity($details = null, $diff = null)
    {
        $user = $this->getUser();
        if(!$user){
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }

        $activity = new Activity($user, $details, $diff);

        $this->em->persist($activity);
        $this->em->flush();

        return true;
    }
}