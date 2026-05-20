<?php

namespace App\Form;

use App\Entity\Abonne;
use App\Entity\Emprunt;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmpruntType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_emprunt')
            ->add('date_retour_prevue')
            ->add('date_retour_effective')
            ->add('livre', EntityType::class, [
                'class' => Livre::class,
                'choice_label' => 'titre',
                'query_builder' => function ($repo) {
                    return $repo->createQueryBuilder('l')
                        ->where('l.disponible = :disponible')
                        ->setParameter('disponible', true)
                        ->orderBy('l.titre', 'ASC');
                },
            ])
            ->add('abonne', EntityType::class, [
                'class' => Abonne::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Emprunt::class,
        ]);
    }
}
