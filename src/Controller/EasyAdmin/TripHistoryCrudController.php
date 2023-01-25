<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Wed Jan 18 2023
 */

namespace App\Controller\EasyAdmin;

use App\Entity\TripHistory;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TripHistoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TripHistory::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
