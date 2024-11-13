<?php

namespace App\Form;

use App\Entity\Voiture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom de la voiture'])
            ->add('description')
            ->add('monthlyPrice', NumberType::class, ['label' => 'Prix mensuel'])
            ->add('dailyPrice', NumberType::class, ['label' => 'Prix journalier'])
            ->add('places', ChoiceType::class, [
                'label' => 'Nombre de places',
                'choices' => range(1, 9),
                'choice_label' => function ($choice) {
                    return $choice;
                },
            ])
            ->add('automatic', ChoiceType::class, [
                'label' => 'Boîte de vitesses',
                'choices' => [
                    'Manuelle' => false,
                    'Automatique' => true,
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
