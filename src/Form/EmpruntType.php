<?php

namespace App\Form;

use App\Entity\Emprunt;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('livre', EntityType::class, [
                'class' => Livre::class,
                'choice_label' => 'titre',
                'label' => 'Livre',
                'placeholder' => 'Choisir un livre',
                'query_builder' => function ($repo) {
                    return $repo->createQueryBuilder('l')
                        ->where('l.disponible = true')
                        ->orderBy('l.titre', 'ASC');
                },
            ])
            ->add('emprunteur', TextType::class, [
                'label' => 'Nom de l\'emprunteur',
                'attr' => ['placeholder' => 'Nom et prénom de l\'étudiant'],
            ])
            ->add('dateEmprunt', DateType::class, [
                'label' => "Date d'emprunt",
                'widget' => 'single_text',
            ])
            ->add('dateRetourPrevue', DateType::class, [
                'label' => 'Date de retour prévue',
                'widget' => 'single_text',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
