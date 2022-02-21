<?php

namespace App\Controller;

use App\Form\EventType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Event;
use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class EventController extends AbstractController
{
    /**
     * @Route("/event")
     */
    public function index(): Response
    {
        return $this->render('event/front.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
    /**
     * @param EventRepository $rep
     * @return \symfony\component\HttpFoundation\Response
     * @Route("/afficher" ,name="afficher-event") 
     */
    public function afficher(EventRepository $rep){
        $event=$rep->findAll();
        return $this->render('event/afficherevent.html.twig',['event'=>$event]);

    
    }
    /**
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/addEvent",name="ajouter-event")
     */
    public function addEvent(EventRepository $rep,ManagerRegistry $doctrine,Request $req){
        $event= new event();
        $form=$this->createForm(EventType::class,$event);
        $form->add('Submit',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()) {
            $file=$event->getImage();
            $filename= md5 (uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                 $filename
            );
            $event->setImage($filename);
            $event->setDate(new \DateTime());
            $em=$doctrine->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('afficher-event');
        }
        return $this->render('event/ajouterEvent.html.twig',['form'=>$form->createView()]);
    }
    /**
     *@Route("supprimer/{id}",name="d")
     */
    public function deleteEvent(EventRepository $rep,$id,ManagerRegistry $doctrine){
        $event=$rep->find($id);
        $em=$doctrine->getManager();
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('afficher-event');

    }
    /**
     * 
     *@Route("modifier-event/{id}",name="modifier-event")
     */
    public function modifier(EventRepository $rep,$id,ManagerRegistry $doctrine,Request $request){
        $event=$rep->find($id);
        $form=$this->createForm(EventType::class,$event); 
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $event->setDate(new \DateTime());
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('afficher-event');
        }
        return $this->render('event/modifier-event.html.twig',['form'=>$form->createView()]);
    }
    
}