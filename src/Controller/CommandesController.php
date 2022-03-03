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
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;



class CommandesController extends AbstractController
{
    
    /**
     * @Route("/commandes", name="commandes", methods={"GET"})
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Commandes::class)->findAll();

        $commandes = $paginator->paginate(
            $donnees, 
            $request->query->getInt('page', 1), 
            1
        );
        
        return $this->render('commandes/index.html.twig', [
            'commandes' => $commandes,
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
    
        return $this->render('commandes/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
     /**
     *@Route("/commandes/show/{id}", name="commandes_show", methods={"GET"})
     */
    public function show(Commandes $commande): Response
    {
        return $this->render('commandes/show.html.twig', [
            'commande' => $commande,
         ]);
    }
    /**
     * @Route("/listc", name="ListCommande", methods={"GET"})
     */
    public function listc(Request $request, PaginatorInterface $paginator): Response
    {

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $donnees = $this->getDoctrine()->getRepository(Commandes::class)->findAll();

        $commandes = $paginator->paginate(
            $donnees, 
            $request->query->getInt('page', 1), 
            1
        );
        
        
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('commandes/listc.html.twig', [
            'commandes' => $commandes,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
        return $this->render('commandes/listc.html.twig', [
            'commandes' => $commandes,
        ]);
    
        
}}
