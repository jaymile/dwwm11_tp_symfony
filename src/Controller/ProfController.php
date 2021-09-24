<?php

namespace App\Controller;

use App\Entity\Prof;
use App\Form\ProfType;
use App\Repository\ProfRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfController extends AbstractController {
    /**
     * @Route("/professeurs/new", name="create_prof")
     */
    public function create(Request $request, EntityManagerInterface $em): Response {
        $prof = new Prof;
        $formulaire = $this->createForm(ProfType::class, $prof);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            // J'insère 
            $em->persist($prof);
            $em->flush();

            return $this->redirectToRoute('liste_prof');
        } else {
            return $this->render('prof/add.html.twig', [
                'formulaire' => $formulaire->createView()
            ]);
        }
    }

    /**
     * @Route("/profs", name="liste_prof")
     */
    public function liste(ProfRepository $repository) {
        $profs = $repository->findAll();

        return $this->render('prof/liste.html.twig', [
            'entityName' => 'professeurs',
            'profs' => $profs
        ]);
    }

    /**
     * @Route("/profs/{id}/delete", name="delete_prof")
     */
    public function delete(Prof $prof, EntityManagerInterface $em) {
        if ($prof->getClasesPrincipales()->isEmpty()) {
            $em->remove($prof);
            $em->flush();
        }

        return $this->redirectToRoute('liste_prof');
    }
}
