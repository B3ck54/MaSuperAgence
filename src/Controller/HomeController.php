<?php

namespace App\Controller;

use App\Entity\Property;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */



    public function index()

    {
//        //recupére les derniers biens sur la page home
//       $properties = $repository->findLatest();
//       return $this->render('pages/home.html.twig', [
//           'controller_name' => 'HomeController',
//           'properties' => $properties
//       ]);



        $repo = $this->getDoctrine()->getRepository(Property::class);
        $properties=$repo->findLatest();
        return $this->render('pages/home.html.twig', [
            'controller_name' => 'HomeController',
            'properties' => $properties
        ]);


    }
}


