<?php

namespace App\Controller;

use App\Entity\Activity;
use App\Service\ActivityService;
use App\Service\Haversine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    protected $em;
    protected $haversin;
    protected $activity;

    public function __construct(EntityManagerInterface $em, Haversine $haversin, ActivityService $activity)
    {
        $this->em = $em;
        $this->haversin = $haversin;
        $this->activity = $activity;
    }

    public function getRole()
    {
        $role = $this->getUser()->getRoles();

        return $role = $role[0];
    }

    public function getCoordinates($address)
    {
        $address = 'Киев, ' . $address;

        $address = urlencode($address);

        $url = "http://www.mapquestapi.com/geocoding/v1/address?key=9dtWXrkGKY5IXxUXFIcz8tFXQyKMKlii&location={$address}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        $coordinates = json_decode($output,true);

        $coordinates = $coordinates['results'][0]['locations'][0]['latLng'];

        return $coordinates;
    }

    public function countNearest()
    {

    }


}