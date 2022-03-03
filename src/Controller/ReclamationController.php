<?php

namespace App\Controller;
use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReclamationRepository;


class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function index(): Response
    {
        return $this->render('reclamation/affiche.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    /**
     * @param ReclamationRepository $repo
     * @return \Symfony\Component\HttpFoundation\Response
     * @route ("/AfficheR",name="AfficheR")
     */
    public function affiche(ReclamationRepository $repo){
        #$repo=$this->getDoctrine()->getRepository(reclamation::class);
        $reclamation=$repo->findAll();
        return $this->render('reclamation/affiche.html.twig',['reclamation'=>$reclamation]);
    }
    /**
     * @Route ("/supp/{id}",name="d")
     */
    function delete($id,ReclamationRepository $repo){
        $reclam=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($reclam);
        $em->flush();
        return $this->redirectToRoute('AfficheR');
    }

    /**
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("reclamation/Add", name="reclamation/Add")
     */
    function add(Request $req){
        $reclam =new Reclamation();
        $form=$this->Createform(ReclamationType::class,$reclam);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclam);
            $em->flush();
            return $this->redirectToRoute('AfficheR');
        }
        return $this->render('reclamation/Add.html.twig',['form'=>$form->createView()]);
    }
    /**
     * @Route ("reclamation/Update/{id}",name="update")
     */
    function update(ReclamationRepository $repo,$id,Request $req){
        $reclam=$repo->find($id);
        $form=$this->Createform(ReclamationType::class,$reclam);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($reclam);
            $em->flush();
            return $this->redirectToRoute('AfficheR');
        }
        return $this->render('reclamation/Update.html.twig',['form'=>$form->createView()]);
    }
}