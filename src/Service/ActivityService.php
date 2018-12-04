<?php

namespace App\Service;

use App\Entity\Activity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ActivityService extends Controller
{
    protected $em;
    protected $container;

    /**
     * ActivityService constructor.
     * @param $em
     */
    public function __construct(EntityManagerInterface $em, ContainerInterface $container)
    {
        $this->em = $em;
        $this->container = $container;
    }


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
        if(!$user) {
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
        }

        $activity = new Activity($user, $details, $diff);

        $this->em->persist($activity);
        $this->em->flush();

        return true;
    }
}