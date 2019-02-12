<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\PropertySearch;
use App\Form\ContactType;
use App\Form\PropertySearchType;
use App\Notification\ContactNotification;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Property;


/**
 * @property PropertyRepository repository
 */
class PropertyController extends AbstractController
{


    public function __construct(PropertyRepository $repository,ObjectManager $em)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/biens", name="property.index")
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */


    public function index(PaginatorInterface $paginator, Request $request)
    {

        // Créer une entité qui va représenter notre recherche
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);

        // Gérer le traitement dans le controller

        //on récupère l'ensemble des biens
        $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page',1),
            12
        );


        return $this->render('property/index.html.twig', [
            'controller_name' => 'PropertyController',
            'current_menu' => 'properties',
            'properties'=> $properties,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     */

    public function show($slug,$id,Request $request, ContactNotification $notification)
    {
        $repo = $this->getDoctrine()->getRepository(Property::class);
        $property = $repo->find($id);


        if($property -> getSlug() !== $slug) {
            return $this->redirectToRoute('property.show',[
                'id'=> $property->getId(),
                'slug' => $property->getSlug()
             ],301);
        }

        $contact = new Contact();
        $contact->setProperty($property);
        $form = $this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);

        if($form->isSubmitted()&& $form->isValid()){
            //Gérer les emails
            $notification->notify($contact);
            $this->addFlash('success','Votre email a bien été envoyé');

            return $this->redirectToRoute('property.show',[
                'id'=> $property->getId(),
                'slug' => $property->getSlug()
            ]);
        }


        return $this->render('property/show.html.twig',[
            'controller_name' => 'PropertyController',
            'property' => $property,
            'current_menu' => 'properties',
            'form' => $form->createView()
         ]);
    }
}
