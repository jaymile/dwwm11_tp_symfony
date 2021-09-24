<?php

namespace App\Controller;

use App\Entity\Classe;
use App\Form\ClasseType;
use App\Repository\ClasseRepository;
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

            return $this->redirectToRoute('liste_classe');
        } else {
            return $this->render('classe/add.html.twig', [
                'formulaire' => $formulaire->createView()
            ]);
        }
    }

    /**
     * @Route("/classes", name="liste_classe")
     */
    public function liste(ClasseRepository $repository) {
        $classes = $repository->findAll();

        return $this->render('classe/liste.html.twig', [
            'entityName' => 'classes',
            'classes' => $classes
        ]);
    }

    /**
     * @Route("/classes/{id}/delete", name="delete_classe")
     */
    public function delete(Classe $classe, EntityManagerInterface $em) {
        $em->remove($classe);
        $em->flush();

        return $this->redirectToRoute('liste_classe');
    }

}
