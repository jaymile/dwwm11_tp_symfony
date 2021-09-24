<?php

namespace App\Controller;

use App\Entity\Prof;
use App\Form\ProfType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfController extends AbstractController {
    /**
     * @Route("/professeurs/new", name="create_prof")
     */
    public function index(Request $request, EntityManagerInterface $em): Response {
        $prof = new Prof;
        $formulaire = $this->createForm(ProfType::class, $prof);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            // J'insère 
            $em->persist($prof);
            $em->flush();

            return $this->redirectToRoute('home');
        } else {
            return $this->render('prof/add.html.twig', [
                'formulaire' => $formulaire->createView()
            ]);
        }
    }
}
