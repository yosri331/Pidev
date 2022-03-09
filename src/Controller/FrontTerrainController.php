<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\ReservationRepository;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



/**
 * @Route("/frontTerrain")
 */
class FrontTerrainController extends AbstractController
{
    /**
     * @Route("/",name="terrainFront_index", methods={"GET"})
     */
    public function index(TerrainRepository $terrainRepository): Response
    {

        return $this->render('front_terrain/index.html.twig', [
            'terrains' => $terrainRepository->findAll(),
        ]);
    }
    /**
     * @Route("/terrainList",name="terrain_list", methods={"GET"})
     */
    public function listTerrain( Request $request,PaginatorInterface $paginator,TerrainRepository $terrainRepository): Response
    {
        $donness=$terrainRepository->findAll();
        $terrians=$paginator->paginate(
            $donness,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('front_terrain/TerrainFrontIndex.html.twig', [
            'terrains' => $terrians,
        ]);
    }

    /**
     * @Route("/add", name="terrain_add", methods={"GET", "POST"})
     */
    public function new(Request $request,EntityManagerInterface $entityManager): Response
    {
        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->add('Submit',SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() ) {
            $entityManager->persist($terrain);
            $entityManager->flush();
            

            return $this->redirectToRoute('terrainFront_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('front_terrain/FrontNew.html.twig', [
            'terrain' => $terrain,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="showTerrain", methods={"GET"})
     */
    public function show(Terrain $terrain): Response
    {

        return $this->render('front_terrain/show.html.twig', [
            'terrain' => $terrain,
        ]);
    }

}
