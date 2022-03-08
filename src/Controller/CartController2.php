<?php

namespace App\Controller;

use App\Repository\CartRepository;
use App\Entity\Cart;
use App\Entity\LignePanier;
use App\Repository\LignePanierRepository;
use App\Repository\ProductsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\Persistence\ManagerRegistry;

class CartController2 extends AbstractController{

/**
 * @Route("/addCart/{id}", name="addCart")
 */
    public function addProduct( Request $request, CartRepository $repo, EntityManagerInterface $em,LignePanierRepository $repoLigne,ProductsRepository $repoProduct,int $id):Response{

        $product = $repoProduct->find($id);
        $cartId=$request->getSession()->get("cartId",null);
    //id user 
    
/**entite cart fiha champ valide 
 * valide = false => cart hiya panier
 * valide=true => cart hiya cmd
 * 
 * 
 * if user.getCart :==  null
 * on cree une nouvelle panier  $cart=new Cart();  cart.setUSer persist
 * on ajoute ligne panier set product
 * else if user.getCart !=  null (user has his own cart)
 * if product in ligne panier find by id cart w id prod if true ++qte
 * sinn new ligne panier
 */
        $cart=$repo->find($cartId);

        if ($cart==null){
            $cart=new Cart();
            $cart->setTotal($product->getPrice());

            $em->persist($cart);
            $em->flush();
            $request->getSession()->set("cartId",$cart->getId());
            
        }else{
            $cart->setTotal($cart->getTotal()+$product->getPrice());
        }
        



        $is_product_in_panier = $repoLigne->findOneBy(['Product' => $product->getId() , 'Cart' => $cart->getId()]);

        if ($is_product_in_panier){
            $nouv_quantite = $is_product_in_panier->getQuantite() + 1;
            $is_product_in_panier->setQuantite($nouv_quantite);
            $em->persist($is_product_in_panier);


        }else {
            $lignePanier=new LignePanier();
            $lignePanier->setProduct($product);
            $lignePanier->setCart($cart);
            $lignePanier->setQuantite(1);
            $em->persist($lignePanier);

        }




        //dd($lignePanier);
        
        $em->flush();
        return $this->redirectToRoute("ligne");
    }

    /**
     * @Route("/ligne", name="ligne")
     */
    public function index(Request $request,CartRepository $repoCart, LignePanierRepository $repoLigne, ProductsRepository $repoProduct){
        //$cart=$repoCart->find($request->getSession()->get("cartId"));
        $cartId=$request->getSession()->get("cartId",null);
        $cart=$repoCart->find($cartId);
        $lignePanier=$repoLigne->findBy(array('Cart' => $cart->getId()));
        $listProducts=[];
        $listQt=[];
        $listIdProduitCart=[];
        foreach($lignePanier as $ligne ){
            $product=$repoProduct->find($ligne->getProduct()->getId());
            array_push($listProducts,$product);
            array_push($listQt,$ligne->getQuantite());
            array_push($listIdProduitCart, $ligne->getId());
        }

        return $this->render("ligne_panier\indexback.html.twig",[
            "id" => $listIdProduitCart,
            "listProduct"=>$listProducts,
            "listQt"=>$listQt,
            "total"=>$cart->getTotal()
        ]);

 
   }
   
   
/**
     * @Route("/session", name="session")
     */
    public function session(Request $request):Response{
        $request->getSession()->set("cartId",27);
        return new Response("session added");
    }
/**
     * @Route("/{id}", name="produit_delete", methods={"POST"})
     */
    public function delete(Request $request, cart $cart, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cart->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cart);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ligne_panier_index', [], Response::HTTP_SEE_OTHER);
    }
   /**
     * @Route("/lignef", name="lignef")
     */
    public function indexf(Request $request,CartRepository $repoCart, LignePanierRepository $repoLigne, ProductsRepository $repoProduct){
        //$cart=$repoCart->find($request->getSession()->get("cartId"));
        $cartId=$request->getSession()->get("cartId",null);
        $cart=$repoCart->find($cartId);
        $lignePanier=$repoLigne->findBy(array('Cart' => $cart->getId()));
        $listProducts=[];
        $listQt=[];
        $listIdProduitCart=[];
        foreach($lignePanier as $ligne ){
            $product=$repoProduct->find($ligne->getProduct()->getId());
            array_push($listProducts,$product);
            array_push($listQt,$ligne->getQuantite());
            array_push($listIdProduitCart, $ligne->getId());
        }

        return $this->render("ligne_panier\index.html.twig",[
            "id" => $listIdProduitCart,
            "listProduct"=>$listProducts,
            "listQt"=>$listQt,
            "total"=>$cart->getTotal()
        ]);

 
   }
}