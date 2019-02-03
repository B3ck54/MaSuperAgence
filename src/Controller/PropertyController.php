<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;


class PropertyController extends AbstractController
{

    /**
     * @Route("/biens", name="property.index")
     */


    public function index()
    {
//        $property = new Property();
//        $property->setTitle('Mon premier bien')
//            ->setPrice('200000')
//            ->setRooms(4)
//            ->setBedrooms(3)
//            ->setDescription('Une petite description')
//            ->setSurface(60)
//            ->setFloor(4)
//            ->setHeat(1)
//            ->setCity('Montpellier')
//            ->setAdress('15 Boulevard Gambetta')
//            ->setPostalCode('3400');
//
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($property);
//            $em->flush();



//        $repository = $this->getDoctrine()->getRepository(Property::class);
//        dump($repository);

//        $property = $this->repository->findAllVisible();
//        $property[0]->setSold(true);
//        $this->em->flush();




        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            'current_menu' => 'properties'
        ]);
    }

    /**
     *
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */

    public function show($slug,$id)
    {
        $repo = $this->getDoctrine()->getRepository(Property::class);
        $property = $repo->find($id);

        if($property -> getSlug() !== $slug) {
            return $this->redirectToRoute('property.show',[
                'id'=> $property->getId(),
                'slug' => $property->getSlug()
             ],301);
        }

        return $this->render('property/show.html.twig',[
            'controller_name' => 'PropertyController',
            'property' => $property,
            'current_menu' => 'properties'
         ]);
    }
}
