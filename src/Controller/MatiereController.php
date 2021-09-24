<?php

namespace App\Controller;

use App\Entity\Matiere;
use App\Form\MatiereType;
use App\Repository\MatiereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatiereController extends AbstractController {
    /**
     * @Route("/matieres/new", name="create_matiere")
     */
    public function create(Request $request, EntityManagerInterface $em): Response {
        $matiere = new Matiere;
        $formulaire = $this->createForm(MatiereType::class, $matiere);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            // J'insère la matière
            $em->persist($matiere);
            $em->flush();

            return $this->redirectToRoute('liste_matiere');
        } else {
            return $this->render('matiere/add.html.twig', [
                'formulaire' => $formulaire->createView()
            ]);
        }
    }

    /**
     * @Route("/matieres", name="liste_matiere")
     */
    public function liste(MatiereRepository $repository) {
        $matieres = $repository->findAll();

        return $this->render('matiere/liste.html.twig', [
            'entityName' => 'matières',
            'matieres' => $matieres
        ]);
    }

    /**
     * @Route("/matieres/{id}/delete", name="delete_matiere")
     */
    public function delete(Matiere $matiere, EntityManagerInterface $em) {
        $em->remove($matiere);
        $em->flush();

        return $this->redirectToRoute('liste_matiere');
    }

}
