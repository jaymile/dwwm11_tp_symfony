<?php

namespace App\Form;

use App\Entity\Prof;
use App\Entity\Classe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ClasseType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('nom', TextType::class)
            ->add('niveau', TextType::class)
            ->add('professeurPrincipal', EntityType::class, [
                'class' => Prof::class,
                'choice_label' => function (Prof $prof) {
                    // On peut passer une fonction pour savoir quoi afficher pour chaque élève
                    return $prof->getDisplayedName();
                }
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Classe::class,
        ]);
    }
}
