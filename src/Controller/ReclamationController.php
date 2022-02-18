<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    function add(){

    }
}
