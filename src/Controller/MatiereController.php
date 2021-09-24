<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Form\MatiereType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatiereController extends AbstractController {
    /**
     * @Route("/matieres/new", name="create_matiere")
     */
    public function index(Request $request, EntityManagerInterface $em): Response {
        $matiere = new Matiere;
        $formulaire = $this->createForm(MatiereType::class, $matiere);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            // J'insère la matière
            $em->persist($matiere);
            $em->flush();

            return $this->redirectToRoute('home');
        } else {
            return $this->render('matiere/add.html.twig', [
                'formulaire' => $formulaire->createView()
            ]);
        }
    }
}
