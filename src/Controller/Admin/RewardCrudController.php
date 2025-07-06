<?php

namespace App\Controller\Admin;

use App\Enum\RewardType;

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
                'badge' => RewardType::badge,
                'coupon' => RewardType::coupon,
                'trophy' => RewardType::trophy,
            ])
             -> renderExpanded(false);

        yield AssociationField::new('RedemptionMission_id', 'Missions liées')->autocomplete();
        yield AssociationField::new('User_id', 'Utilisateurs')->autocomplete();
    }
}
