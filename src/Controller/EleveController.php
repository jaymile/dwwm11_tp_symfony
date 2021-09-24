<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Repository\EleveRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EleveController extends AbstractController {
    /**
     * @Route("/eleves/new", name="create_eleve")
     */
    public function create(Request $request, EntityManagerInterface $em): Response {
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

    /**
     * @Route("/eleves", name="liste_eleve")
     */
    public function liste(EleveRepository $repository) {
        $eleves = $repository->findAll();

        return $this->render('eleve/liste.html.twig', [
            'entityName' => 'élèves',
            'eleves' => $eleves
        ]);
    }
}
