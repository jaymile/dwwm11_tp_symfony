<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EleveController extends AbstractController {
    /**
     * @Route("/eleves/new", name="create_eleve")
     */
    public function index(Request $request, EntityManagerInterface $em): Response {
        $eleve = new Eleve;
        $formulaire = $this->createForm(EleveType::class, $eleve);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            // J'insère 
            $em->persist($eleve);
            $em->flush();

            return $this->redirectToRoute('home');
        } else {
            return $this->render('eleve/add.html.twig', [
                'formulaire' => $formulaire->createView()
            ]);
        }
    }
}
