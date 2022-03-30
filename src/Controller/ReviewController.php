<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\ReviewType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reviews;
use App\Repository\EventRepository;
use App\Repository\ReviewsRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReviewController extends AbstractController
{
    #[Route('/review', name: 'review')]
    public function index(): Response
    {
        return $this->render('review/index.html.twig', [
            'controller_name' => 'ReviewController',
        ]);
    }
     /**
     * @param ReviewsRepository $rep
     * @return \symfony\component\HttpFoundation\Response
     * @Route("/afficher-event/{id}" ,name="afficher-comments") 
     */
    public function afficher(ReviewsRepository $rep,$id,EventRepository $repo){
        $event=$repo->find($id);

        $review=$event->getReviews();
        return $this->render('event/afficherReviews.html.twig',['review'=>$review,'id'=>$id]);


    
    }
    
    /**
     *@Route("supprimer-review/{id}/{id_event}",name="delete-review")
     */
    public function deleteEvent(ReviewsRepository $rep,$id,ManagerRegistry $doctrine,$id_event){
        $event=$rep->find($id);
        $em=$doctrine->getManager();
        $em->remove($event);
        $em->flush();
        return $this->redirectToRoute('afficher-comments',['id'=>$id_event]);

    }
    /**
     *@Route("supprimer-review/{id}/{id_event}",name="delete-review-front")
     */
    public function deleteEventfront(ReviewsRepository $rep,EventRepository $everep,$id,ManagerRegistry $doctrine,$id_event){
        $event=$rep->find($id);
        $em=$doctrine->getManager();
        $em->remove($event);
        $em->flush();
        $events=$everep->findAll();
        return $this->render('event/front/afficher-events.html.twig',['event'=>$events]);

    }
    /**
     * @param Request $req
     * @param $
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("ajouter-review/{id_event}",name="add_review")
     */
    public function addReview(ReviewsRepository $rep,ManagerRegistry $doctrine,$id_event,Request $req,EventRepository $repo,UtilisateurRepository $userep){
        $review =new Reviews();
        $user=$userep->find(1);
        $form=$this->createForm(ReviewType::class,$review);
        $form->add('Submit',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$doctrine->getManager();
            $review->setUtilisateur($user);
            $review->setDate(new \DateTime());
            $event=$repo->find($id_event);
            $review->setEvent($event);
            $em->persist($review);
            $em->flush();
            return $this->redirectToRoute('afficher-comments',['id'=>$id_event]);
        }
        return $this->render('event/ajouter-review.html.twig',['form'=>$form->createView()]);

    }
    /**
     *@Route("modifier/{id}/{id_event}",name="modifier-review")
     */
    public function updateReview(ReviewsRepository $rep,ManagerRegistry $doctrine,$id,$id_event,Request $request){
        $review=$rep->find($id);
        $form=$this->createForm(ReviewType::class,$review); 
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() ){
            $review->setDate(new \DateTime());
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('afficher-comments',['id'=>$id_event]);
        }
        return $this->render('event/modifier-review.html.twig',['form'=>$form->createView()]);

    }
    /**
     *@Route("modifier/{id}/{id_event}",name="modifier-review-front")
     */
    public function updateReviewfront(ReviewsRepository $rep, EventRepository $everep,ManagerRegistry $doctrine,$id,$id_event,Request $request){
        $events=$everep->findAll();
        $review=$rep->find($id);
        $form=$this->createForm(ReviewType::class,$review); 
        $form->add('Update',SubmitType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() ){
            $review->setDate(new \DateTime());
            $em=$doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('afficher-comments',['id'=>$id_event]);
        }
        return $this->render('event/front/afficher-events.html.twig',['event'=>$events]);

    }
    /**
     *@Route("hide_comment/{id}/{id_event}",name="hide_comment")
     */
    public function masquerReview(ReviewsRepository $rep,$id,$id_event,ManagerRegistry $doctrine){
        $review=$rep->find($id);
        $review->setHidden(true);
        $em=$doctrine->getManager();
        $em->flush();

        return $this->redirectToRoute('afficher-comments',['id'=>$id_event]);
    }
    

}

