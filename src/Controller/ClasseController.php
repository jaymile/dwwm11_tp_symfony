<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClasseController extends AbstractController {
    /**
     * @Route("/classes/new", name="create_classe")
     */
    public function index(Request $request, EntityManagerInterface $em): Response {
        $classe = new Classe;
        $formulaire = $this->createForm(ClasseType::class, $classe);

        $formulaire->handleRequest($request);

        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            // J'insère
            $em->persist($classe);
            $em->flush();

            return $this->redirectToRoute('home');
        } else {
            return $this->render('classe/add.html.twig', [
                'formulaire' => $formulaire->createView()
            ]);
        }
    }
}
