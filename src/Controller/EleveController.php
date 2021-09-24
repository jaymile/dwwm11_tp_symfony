<?php

namespace App\Controller;

use App\Entity\Eleve;
use App\Form\EleveType;
use App\Form\SearchEleveType;
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

            return $this->redirectToRoute('liste_eleve');
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

    /**
     * @Route("/eleves/search", name="search_eleve")
     */
    public function search(EleveRepository $repository, Request $request) {
        $formulaire = $this->createForm(SearchEleveType::class);
        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $eleves = $repository->searchByName($formulaire->get('recherche')->getData());
        } else {
            $eleves = $repository->findAll();
        }

        return $this->render('eleve/liste.html.twig', [
            'formulaire' => $formulaire->createView(),
            'entityName' => 'élèves',
            'eleves' => $eleves
        ]);
    }

    /**
     * @Route("/eleves/{id}/delete", name="delete_eleve")
     */
    public function delete(Eleve $eleve, EntityManagerInterface $em) {
        $em->remove($eleve);
        $em->flush();

        return $this->redirectToRoute('liste_eleve');
    }

    /**
     * @Route("/eleves/{id}", name="details_eleve")
     */
    public function details(Eleve $eleve) {
        $somme_notes_coefficientees = 0;
        $somme_coefs = 0;

        foreach ($eleve->getNotes() as $note) {
            $somme_coefs += $note->getCoefficient();
            $somme_notes_coefficientees += $note->getNote() * $note->getCoefficient();
        }

        if ($somme_coefs == 0) $somme_coefs = 1;

        $moyenne = round($somme_notes_coefficientees / $somme_coefs, 2);

        return $this->render('eleve/details.html.twig', [
            'moyenne' => $moyenne,
            'eleve' => $eleve
        ]);
    }
}
