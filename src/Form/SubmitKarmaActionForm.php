<?php

namespace App\Form;

use App\Entity\KarmaAction;
use App\Entity\Offense;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use App\Enum\KarmaActionType;


class SubmitKarmaActionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Type', EnumType::class, [
                'class' => KarmaActionType::class,
                'label' => 'Type d\'action',
                'placeholder' => 'Sélectionnez une action',
                'attr' => [
                    'class' => 'w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => KarmaAction::class,
        ]);
    }
}
