<?php

namespace App\Controller;

use App\Entity\Terrain;
use App\Form\TerrainType;
use App\Repository\TerrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/terrain")
 */
class TerrainController extends AbstractController
{
    /**
     * @Route("/", name="terrain_index", methods={"GET"})
     */
    public function index(TerrainRepository $terrainRepository, SerializerInterface $serializer): Response
    {
      /* $terrains= $terrainRepository->findAll();
       $json=$serializer->serialize($terrains,'json',['groups'=>'terrain']);
       dump($json);
       die;*/
          return $this->render('terrain/index.html.twig', [
           'terrains' => $terrainRepository->findAll(),
        ]);

    }

    /**
     * @Route("/new", name="terrain_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $terrain = new Terrain();
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($terrain);
            $entityManager->flush();
            $this->addFlash(
                'info',
                'added successfully !'
            );

            return $this->redirectToRoute('terrain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('terrain/new.html.twig', [
            'terrain' => $terrain,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="terrain_show", methods={"GET"})
     */
    public function show(Terrain $terrain): Response
    {
        return $this->render('terrain/show.html.twig', [
            'terrain' => $terrain,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="terrain_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Terrain $terrain, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TerrainType::class, $terrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('terrain_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('terrain/edit.html.twig', [
            'terrain' => $terrain,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="terrain_delete", methods={"POST"})
     */
    public function delete(Request $request, Terrain $terrain, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$terrain->getId(), $request->request->get('_token'))) {
            $entityManager->remove($terrain);
            $entityManager->flush();
        }

        return $this->redirectToRoute('terrain_index', [], Response::HTTP_SEE_OTHER);
    }


}
