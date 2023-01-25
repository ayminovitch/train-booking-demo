<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Wed Jan 18 2023
 */

namespace App\Controller\EasyAdmin;

use App\Entity\Trip;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;

class TripCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Trip::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('id', 'ID')->onlyOnIndex(),
            Field::new('referenceCode', 'Reference Code')->hideOnForm(),
            TextEditorField::new('description', 'Description')->hideOnIndex(),
            AssociationField::new('stationFrom', 'Station From'),
            AssociationField::new('stationTo', 'Station To'),
            TimeField::new('departureTime', 'Departure Time'),
            TimeField::new('arrivalTime', 'Arrival Time'),
            Field::new('createdAt', 'Created At')->hideOnForm(),
            Field::new('updatedAt', 'Updated At')->hideOnForm()->hideOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Trip')
            ->setEntityLabelInPlural('Trips')
            ->setSearchFields(['referenceCode'])
            ->setEntityPermission('ROLE_ADMIN')
            ->setEntityPermission('ROLE_CONDUCTOR', Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermissions([Action::DELETE => 'ROLE_ADMIN', Action::EDIT => 'ROLE_ADMIN', Action::NEW => 'ROLE_ADMIN', Action::DETAIL => 'ROLE_CONDUCTOR']);
    }
}
