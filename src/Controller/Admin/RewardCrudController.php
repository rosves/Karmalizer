<?php

namespace App\Controller\Admin;

use App\Entity\Reward;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\{IdField, TextField, TextareaField, DateTimeField, ChoiceField, AssociationField};

class RewardCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Reward::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();

        yield TextField::new('name', 'Nom de la récompense');
        yield TextareaField::new('description', 'Description')
            ->setFormTypeOptions([
                'attr' => ['rows' => 5]
            ]);

        yield DateTimeField::new('createdAt', 'Date de création')
            ->onlyOnForms()
            ->setFormTypeOptions([
                'data' => new \DateTimeImmutable(),
            ]);

        yield ChoiceField::new('type', 'Type de récompense')
            ->setChoices([
                'badge' => 'badge',
                'trophy' => 'trophy',
                'coupon' => 'coupon',
            ]);

        // Permettre d'associer les missions de rédemption liées à cette récompense
        yield AssociationField::new('RedemptionMission_id', 'Missions liées')->autocomplete();

        // Si tu veux aussi gérer l'association avec les utilisateurs (souvent pas dans le CRUD admin Rewards)
        // yield AssociationField::new('User_id', 'Utilisateurs')->autocomplete();
    }
}
