<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\FiltreData;
use App\Entity\Produit;
use App\Form\CommentsType;
use App\Form\FiltreForm;
use App\Form\Produit1Type;
use App\Form\SearchprodType;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;
use DateTime;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository,SerializerInterface $serializerinterface): Response
    {
        $produits=$produitRepository->findAll();
       // $json=$serializerinterface->serialize($produits,'json',['groups'=>'produits']);
       // dump($produits);
       // die();
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),

        ]);
    }


    /**
     * @Route("/search", name="produit_search", methods={"GET", "POST"})
     */
    public function search(ProduitRepository $produitRepository,Request $request): Response
    {
        $products = $produitRepository->findAll();
        $form = $this->createFormBuilder(null)
            ->add('Name', TextType::class)
            ->add('search', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $re = $request->get('form');
            $products = $produitRepository->findBy(
                ['nomprod' => $re['Name']]
            );
        }
        return $this->render('produit/search.html.twig', [
            'produits' => $products,
            'form' => $form->createView()
            ]);
    }


    /**
 * @Route("/searchajax", name="produit_searchajax", methods={"GET", "POST"})
 */
public function searchAction(Request $request,ProduitRepository $rep,ManagerRegistry $doctrine)
{
    $em = $doctrine->getManager();
    $requestString = $request->get('q');
    $products =  $rep->findEntitiesByString($requestString);
    if(!$products) {
        $result['products']['error'] = "product Not found :( ";
    } else {
        $result['products'] = $this->getRealEntities ($products);
    }
    return new Response(json_encode($result));
}
public function getRealEntities($products){
    foreach ($products as $products){
        $realEntities[$products->getId()] = [$products->getImageprod(),$products->getNomprod()];

    }
    return $realEntities;
}


    /**
     * @Route("/front", name="produit_front", methods={"GET"})
     */
    public function liste(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/liste.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/frontprod", name="front_prod", methods={"GET"})
     */
    public function listef(ProduitRepository $produitRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $data = new FiltreData();
        $form = $this->createForm(FiltreForm::class,$data);
        $form->handleRequest($request);
        $products=$produitRepository->findSearch($data);



        return $this->render('produit/shop.html.twig', [
            'produits' => $products,
            'form'=> $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(Produit1Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_search', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="produit_show", methods={"GET"})
     */
    public function show($id,ProduitRepository $rep): Response
    {
        $produit=$rep->find($id);
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{id}/f", name="produit_showfront", methods={"GET","POST"})
     */
    public function showfront(Request $request,$id,ProduitRepository $rep): Response
    {
        // Partie commentaires
        // On crée le commentaire "vierge"
        
        $produitt=$rep->find($id);
        $comment =new Comments();

        // On génère le formulaire
        $commentForm = $this->createForm(CommentsType::class, $comment);
        $commentForm->handleRequest($request);

        // Traitement du formulaire
        if($commentForm->isSubmitted() && $commentForm->isValid()){
            $comment->setCreatAt(new DateTime());
            $comment->setProduits($produitt);

           // On récupère le contenu du champ parentid
            $parentid = $commentForm->get("parent")->getData();
            // On va chercher le commentaire correspondant
            $em = $this->getDoctrine()->getManager();
            if($parentid != null){
                $parent = $em->getRepository(Comments::class)->find($parentid);
            }
            // On définit le parent
            $comment->setParent($parent ?? null);
            // On va chercher le commentaire correspondant
           // $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();
            $this->addFlash('message', 'Votre commentaire a bien été envoyé');
          //  return $this->redirectToRoute('produit_showfront', [], Response::HTTP_SEE_OTHER);

        }


        return $this->render('produit/showfront.html.twig', [
            'produit' => $produitt,
            'commentForm' => $commentForm->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="produit_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Produit1Type::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods={"POST"})
     */
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
    }

}
