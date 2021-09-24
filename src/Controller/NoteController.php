<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Eleve;
use App\Form\NoteType;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class NoteController extends AbstractController {
    /**
     * @Route("/notes/new/{id}", name="create_note")
     */
    public function create(Eleve $eleve, Request $request, EntityManagerInterface $em): Response {
        $note = new Note;
        $note->setDate(new DateTime);

        $formulaire = $this->createForm(NoteType::class, $note);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            $note->setEleve($eleve);

            // J'insère 
            $em->persist($note);
            $em->flush();

            return $this->redirectToRoute('details_eleve', [
                'id' => $eleve->getId()
            ]);
        } else {
            return $this->render('note/add.html.twig', [
                'eleve' => $eleve,
                'formulaire' => $formulaire->createView()
            ]);
        }
    }

    /**
     * @Route("/notes/{id}/delete", name="delete_note")
     */
    public function delete(Note $note, EntityManagerInterface $em) {
        $em->remove($note);
        $em->flush();

        return $this->redirectToRoute('home');
    }
}
