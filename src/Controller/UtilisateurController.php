<?php


namespace App\Controller;
use App\Entity\Utilisateur;
use App\Form\ReviewType;
use App\Entity\Reviews;
use App\Form\EventType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Entity\Event;
use App\Repository\EventRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur', name: 'utilisateur')]
    public function index(): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtulisateurController',
        ]);
    }
     /**
         * @Route("/home", name="home")
         */
        public function home(Request $request ){

            return $this->render("home/index.html.twig");
        }

    public function getUtilisateur(ManagerRegistry $doctrine){
        $user=$doctrine->getRepository(UtilisateurRepository::class)->find(1);
        return $user;
    }
}
