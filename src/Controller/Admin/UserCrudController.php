<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();

        yield EmailField::new('email', 'Adresse email');

        yield TextField::new('username', 'Nom d’utilisateur');

        yield ChoiceField::new('roles', 'Rôles')
            ->allowMultipleChoices()
            ->setChoices([
                'Utilisateur' => 'ROLE_USER',
                'Modérateur' => 'ROLE_MODERATOR',
                'Administrateur' => 'ROLE_ADMIN',
            ])
            ->renderExpanded();

        yield AssociationField::new('rewards', 'Récompenses obtenues')
            ->autocomplete()
            ->setHelp('Récompenses karmiques reçues par l’utilisateur.')
            ->setFormTypeOptions([
                'by_reference' => false,
            ]);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::DELETE); // Désactiver la création et la suppression d'utilisateurs; 
    }
}
