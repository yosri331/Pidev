<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Form\BlogType;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }
    /**
     * @param BlogRepository $repo
     * @return \Symfony\Component\HttpFoundation\Response
     * @route ("/AfficheB",name="AfficheB")
     */
    public function affiche(BlogRepository  $repo){
        $blog=$repo->findAll();
        return $this->render('blog/afficheblog.html.twig',['blog'=>$blog]);
    }

    /**
     * @param BlogRepository $repo
     * @return \Symfony\Component\HttpFoundation\Response
     * @route ("/AfficheBf",name="AfficheBf")
     */
    public function affiche_blog_front(BlogRepository  $repo){
        $blog=$repo->findAll();
        return $this->render('blog/afficheblogfront.html.twig',['blog'=>$blog]);
    }

    /**
     * @Route ("/supp1/{id}",name="d2")
     */
    function delete($id,BlogRepository $repo){
        $blog=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($blog);
        $em->flush();
        return $this->redirectToRoute('AfficheB');
    }

    /**
     * @Route ("/supp2/{id}",name="d3")
     */
    function delete2($id,BlogRepository $repo){
        $blog=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($blog);
        $em->flush();
        return $this->redirectToRoute('AfficheBf');
    }

    /**
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("blog/AddBlog", name="blog/AddBlog")
     */
    function add(Request $req){
        $blog =new Blog();
        $form=$this->Createform(BlogType::class,$blog);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute('AfficheB');
        }
        return $this->render('blog/AddBlog.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @param Request $req
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route ("blog/AddBlogFront", name="blog/AddBlogFront")
     */
    function add_blog_front(Request $req){
        $blog =new Blog();
        $form=$this->Createform(BlogType::class,$blog);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute('AfficheBf');
        }
        return $this->render('blog/AddBlogFront.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route ("blog/UpdateBlog/{id}",name="updateblog")
     */
    function update(BlogRepository $repo,$id,Request $req){
        $blog=$repo->find($id);
        $form=$this->Createform(BlogType::class,$blog);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute('AfficheB');
        }
        return $this->render('blog/UpdateBlog.html.twig',['form'=>$form->createView()]);
    }

/**
* @Route ("blog/UpdateBlogFront/{id}",name="updateblogfront")
*/
    function update_blog_front(BlogRepository $repo,$id,Request $req){
        $blog=$repo->find($id);
        $form=$this->Createform(BlogType::class,$blog);
        $form->add('Update',SubmitType::class);
        $form->handleRequest($req);
        if($form->isSubmitted() && $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($blog);
            $em->flush();
            return $this->redirectToRoute('AfficheBf');
        }
        return $this->render('blog/UpdateBlogFront.html.twig',['form'=>$form->createView()]);
    }

}
