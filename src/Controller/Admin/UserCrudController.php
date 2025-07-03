<?php
namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->onlyOnIndex();

        yield EmailField::new('email');

        yield TextField::new('username', 'Nom d’utilisateur');

        yield ChoiceField::new('roles')
            ->allowMultipleChoices()
            ->setChoices([
                'Utilisateur' => 'ROLE_USER',
                'Modérateur' => 'ROLE_MODERATOR',
                'Administrateur' => 'ROLE_ADMIN',
            ])
            ->renderExpanded(); // checkbox

    }
}
