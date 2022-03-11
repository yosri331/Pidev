<?php

namespace App\Controller;
use App\Form\ReviewType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Entity\Reviews;
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
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Entity\Utilisateur;
use App\Controller\UtilisateurController;
use App\Form\EventSearchType;
use App\Repository\ReviewsRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\MakerBundle\EventRegistry;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use Symfony\Component\VarExporter\Internal\Hydrator;

class EventController extends AbstractController
{
    /**
     * @Route("/event")
     */
   
 
    public function index(): Response
    {
        return $this->render('event/front/front.html.twig', [
            'controller_name' => 'EventController',
        ]);
    }
    
    /**
     * @param EventRepository $rep
     * @param UtilisateurRepository $userrep
     * @return \symfony\component\HttpFoundation\Response
     * @Route("/afficher" ,name="afficher-event") 
     */
    public function afficher(EventRepository $rep,Request $req,ManagerRegistry $doctrine,UtilisateurRepository $userrep,Request $request){
        $events=$rep->findAll();
        
        $event= new event();
        $event1= new event();
        $user=$userrep->find(1);
        $form=$this->createForm(EventType::class,$event);
        $searchform=$this->createForm(EventSearchType::class,$event1);
        $searchform->add('Submit',SubmitType::class);
        $form->add('Submit',SubmitType::class);
        $form->handleRequest($req);
        $searchform->handleRequest($request);
        if($form->isSubmitted() ) {
            $desc=$form->get('description')->getData();
            if(str_contains($desc,'putain')){

            }
            else{

            
            $event->setUtilisateur($user);
           
            $em=$doctrine->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('afficher-event');
            }
            
            
        }
        if($searchform->isSubmitted()){
            $nom=$event1->getNom();
            $kek=$rep->SearchByName($nom);
            return $this->render('event/afficherevent.html.twig',['event'=>$kek,'form'=>$form->createView(),'searchform'=>$searchform->createView()]);

        }
        else
    
        return $this->render('event/afficherevent.html.twig',['event'=>$events,'form'=>$form->createView(),'searchform'=>$searchform->createView()]);


    
    }
    /**
     * @param EventRepository $rep
     * @return \symfony\component\HttpFoundation\Response
     * @Route("/event/afficher" ,name="front-afficher-events") 
     */
    public function frontafficher(EventRepository $rep){
        $event=$rep->SortBydate();
        return $this->render('event/front/afficher-events.html.twig',['event'=>$event]);

    
    }
    /**
     * @param EventRepository $rep
     * @return \symfony\component\HttpFoundation\Response
     * @Route("/event/afficher/{id}" ,name="front-eventdisplay") 
     */
    public function eventdisplay(EventRepository $rep,$id,ManagerRegistry $doctrine,Request $req,UtilisateurRepository $userrep){
        $event=$rep->find($id);
        $reviews=$event->getReviews();
        $user=$userrep->find(1);
        $review= new Reviews();
        $form=$this->createForm(ReviewType::class,$review);
        $form->add('Submit',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $desc=$form->get('description')->getData();
            if(str_contains($desc,'putain')){
            }
            else{
            $em=$doctrine->getManager();
            $review->setDate(new \DateTime());
            $review->setUtilisateur($user);
            $review->setEvent($event);
            $em->persist($review);
            $em->flush();
            return $this->redirectToRoute('front-eventdisplay',['id'=>$id]);
        


            }

        }
        return $this->render('event/front/eventdisplay.html.twig',['event'=>$event,'reviews'=>$reviews,'form'=>$form->createView()]);
        

    }

    /**
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("/addEvent",name="ajouter-event")
     */
    public function addEvent(EventRepository $rep,ManagerRegistry $doctrine,Request $req,UtilisateurRepository $userrep){
        
        $event= new event();
        $form=$this->createForm(EventType::class,$event);
        $form->add('Submit',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()) {
            $user =$userrep->find(1);
           $event->setUtilisateur($user);
    
            $em=$doctrine->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('afficher-event');
        }
        
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
    /**
     * 
     * @Route("/event/participer/{id}" ,name="participer")
     */
    public function participer(EventRepository $rep,$id,ManagerRegistry $doctrine){
        $event=$rep->find($id);
        $event->setParticipants("mohammed");
        $em=$doctrine->getManager();
        $em->flush();
        $event=$rep->findAll();
        return $this->render('event/front/afficher-events.html.twig',['event'=>$event]);



    }
    /**
     * @Route("/event/rechercher/{nom}" ,name="rechercher")
     */
    public function rechercher(EventRepository $rep,$nom){
        $event=$rep->findBynom($nom);
        return $this->render('event/front/afficher-events.html.twig',['form'=>$event]);
        


    }
    
    public function MultiSearch(EventRepository $rep,Request $req){
        $event = new Event();
        $form=$this->createForm(EventSearchType::class,$event);
        $form->add('Submit',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted()){
            $rep->multiSearch($form->get('search')->getData());
            return $this->render('event/afficherevent.html.twig',['event'=>$rep,'form'=>$form->createView()]);

        }
        
        
        
    }
    /**
     * @Route("/event/TriparDate")
     */
    public function TriparDate(EventRepository $rep){

        
    }
    /**
     *@Route("/AllEvents" ,name="AllEvents")
     */
    public function AllEvents(NormalizerInterface $normalizer,EventRepository $rep)
    {
        $events=$rep->findAll();
        $jsonContent = $normalizer->normalize($events, 'json',['groups'=>'post:read']);
        return new Response(json_encode($jsonContent));



    }
    /**
     * @Route("/jsonAddEvent/new" ,name="jsonAddEvent")
     */
        public function addEventjson(Request $req,NormalizerInterface $normalizer,EventRepository $rep,ManagerRegistry $doctrine){
        $em=$doctrine->getManager();
        $event=new Event();
        $event->setNom($req->get('nom')); 
        $event->setDescription($req->get('description'));
        $event->setDate(new \Datetime($req->get('date')));
        $event->setParticipants($req->get('participants'));
        $event->setImage($req->get('image'));
        $em->persist($event);
        $em->flush();
        $json=$normalizer->normalize($event,'json',['groups'=>'post:read']);
        return new Response(json_encode($json));
    } 
    /**
     * @Route("jsonUpdateEvent/{id}" ,name="jsonUpdateEvent")
     */
    
    public function UpdateEventjson(Request $req,NormalizerInterface $normalizer,EventRepository $rep,ManagerRegistry $doctrine,$id){
        $em=$doctrine->getManager();
        $event=$rep->find($id);
        $event->setNom($req->get('nom')); 
        $event->setDescription($req->get('description'));
        $event->setDate(new \Datetime($req->get('date')));
        $event->setParticipants($req->get('participants'));
        $event->setImage($req->get('image'));
        $em->flush();
        $json=$normalizer->normalize($event,'json',['groups'=>'post:read']);
        return new Response(json_encode($json));
    } 
    /**
     * @Route("/afficherTri", name="triselonreviews")
     */
    public function TriParnbReviews(EventRepository $rep,UtilisateurRepository $userrep,Request $req,Request $request,ManagerRegistry $doctrine){
        
        $events=$rep->findAll();
        $event = new Event();
        $event1 = new Event();
        $user=$userrep->find(1);
        $form=$this->createForm(EventType::class,$event);
        $searchform=$this->createForm(EventSearchType::class,$event1);
        $searchform->add('Submit',SubmitType::class);
        $form->add('Submit',SubmitType::class);
        $form->handleRequest($req);
        $searchform->handleRequest($request);
        if($form->isSubmitted() ) {
            $desc=$form->get('description')->getData();
            if(str_contains($desc,'putain')){

            }
            else{

            
            $event->setUtilisateur($user);
           
            $em=$doctrine->getManager();
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('afficher-event');
            }
            
            
        }
        if($searchform->isSubmitted()){
            $nom=$event1->getNom();
            $kek=$rep->SearchByName($nom);
            return $this->render('event/afficherevent.html.twig',['event'=>$kek,'form'=>$form->createView(),'searchform'=>$searchform->createView()]);

        }
        else{
        usort($events, fn($x,$y)=> $x->getnbComments() <=> $y->getnbComments());
        $array=  array();
        foreach($events as $a){
            array_push($array,$a->getnbComments());
        }
    
        
        return $this->render('event/afficherevent.html.twig',['event'=>$events,'form'=>$form->createView(),'searchform'=>$searchform->createView(),'array' =>$array]);
        
    }
        
    }
    private function getData(EventRepository $rep): array
    {
        /**
         * @var $events Event[]
         */
        $list = array() ;
        $events = $rep->findAll(Query::HYDRATE_ARRAY);

        foreach($events as $event){
            $list[] = $event->__toString();
        }
        return $events;
    }
    /**
     * @Route("/export",  name="export")
     */
    public function export(EventRepository $rep)
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle('Events List');

        $sheet->getCell('A1')->setValue('Nom');
        $sheet->getCell('B1')->setValue('Description');
        $sheet->getCell('C1')->setValue('Date');
        $sheet->getCell('D1')->setValue('Participants');
        


        // Increase row cursor after header write
        $sheet->fromArray($this->getData($rep),null, 'A2', true);


        $writer = new Xlsx($spreadsheet);

        $writer->save('helloworld.xlsx');

        return $this->render("event/excel_page.html.twig");
    }

    
}