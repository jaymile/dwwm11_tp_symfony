<?php

namespace App\Form;

use App\Entity\Note;
use App\Entity\Eleve;
use App\Entity\Matiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class NoteType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('note', NumberType::class, [
                'attr' => [ // 'attr' est l'option qui gère les attributs HTML de l'input
                    'min' => 0,
                    'max' => 20,
                    'step' => 0.25
                ]
            ])
            ->add('coefficient', IntegerType::class, [
                'attr' => [ // 'attr' est l'option qui gère les attributs HTML de l'input
                    'min' => 1
                ]
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'input_format' => 'd/M/Y'
            ])
            ->add('matiere', EntityType::class, [
                'class' => Matiere::class,
                'choice_label' => 'nom'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
