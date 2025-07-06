<?php

namespace App\Controller\Admin;

use App\Entity\RedemptionMission;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class RedemptionMissionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return RedemptionMission::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Mission karmique')
            ->setEntityLabelInPlural('Missions karmiques')
            ->setDefaultSort(['id' => 'DESC'])
            ->setPageTitle('index', 'Gestion des missions karmiques');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();

        yield TextField::new('title', 'Titre de la mission')
            ->setRequired(true);

        yield TextareaField::new('description', 'Description')
            ->setRequired(true)
            ->setHelp('Décrire la mission karmique en détail.');

        yield AssociationField::new('Offenses', 'Posts problématiques liés')
            ->setFormTypeOptions(['by_reference' => false])
            ->setHelp('Sélectionner les offenses associées à cette mission.');

        yield AssociationField::new('rewards', 'Récompenses liées')
            ->setFormTypeOptions(['by_reference' => false])
            ->setHelp('Sélectionner les récompenses associées à cette mission.');

        yield IntegerField::new('severity_min', 'Sévérité minimale requise')
            ->setHelp('Indique la sévérité minimale des offenses pour déclencher cette mission.');
    }
}
