<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use App\Enum\PlatformType;

class AnalyseForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('AnalysePost', TextareaType::class, [
                'label' => 'Post à analyser',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Entrez le texte du post à analyser',
                    'class' => 'form-control',
                    'rows' => 5,
                ],
                'constraints' => [
                    new notBlank([
                        'message' => 'Le post ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'La longueur minimale du post est de {{ limit }} caractères.',
                        'max' => 4096,
                    ]),

                ],
            ])
            ->add('Plateforme', EnumType::class, [
                'class' => PlatformType::class,
                'label' => 'Plateforme du post',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Sélectionnez la plateforme',
                'constraints' => [
                    new NotBlank([
                        'message' => 'La plateforme est obligatoire.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
