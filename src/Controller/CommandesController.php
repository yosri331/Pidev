<?php

namespace App\Controller;

use App\Entity\Commandes;
use App\Entity\Products;
use App\Form\CommandesType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CartRepository;
use App\Repository\CommandesRepository;
use App\Repository\LignePanierRepository;
use App\Repository\ProductsRepository;

class CommandesController extends AbstractController
{
    /**
     * @Route("/commandes", name="commandes")
     */
    public function index(): Response
    {
        return $this->render('commandes/index.html.twig', [
            'controller_name' => 'CommandesController',
        ]);
    }

    /**
     * @Route("/commandes/new", name="commandes_new")
     */
    public function new(Request $request,CommandesRepository $commandesRepository,CartRepository $repoCart, LignePanierRepository $repoLigne, ProductsRepository $ProductsRepository): Response
    {
        $commande = new Commandes();
        $form = $this->createForm(CommandesType::class, $commande);
        $form->handleRequest($request);

        if ( $form->isSubmitted() && $form->isValid() ){
            $cartId=$request->getSession()->get("cartId",null);
            $cart=$repoCart->find($cartId);
            $lignePanier=$repoLigne->findBy(array('Cart' => $cart->getId()));
            $listProducts=[];
            $listQt=[];
            foreach($lignePanier as $ligne ){
                $product=$ProductsRepository->findOneBy(['id' => $ligne->getProduct()->getId()]);
                array_push($listProducts,$product);
                array_push($listQt,$ligne->getQuantite());
            }

            $id_for_commande = $commandesRepository->findlastidcommande();
            if ( $id_for_commande){
                $idCommande = $id_for_commande[0]->getIdCommande();
                $idCommande = $idCommande++;
            }else{
                $idCommande = 1;
            }
            $count_products = sizeof($listProducts);
            $commande->setIdCommande($idCommande);
            $commande->setTotal($cart->getTotal());
            //dd($listProducts[0] , $listQt , $commande, $idCommande);
            $entityManager = [$count_products];
            for( $i = 0 ; $i < $count_products ; $i++){
                $commande->setProduct($listProducts[$i]);
                $commande->setQuantiteProduit($listQt[$i]);
                
                $entityManager[$i] = $this->getDoctrine()->getManager();
                $entityManager[$i]->persist($commande);
                $entityManager[$i]->flush();
                $entityManager[$i]->clear();

            }



            return $this->redirectToRoute("ligne");
            
        }
    
        return $this->render('commandes/newfront.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
}
