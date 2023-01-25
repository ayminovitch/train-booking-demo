<?php

/*
 * (c) Aymen Hammami <hello@aymen-hammami.com> 
 *
 * Github: https://github.com/ayminovitch
 * Created at: Wed Jan 18 2023
 */

namespace App\Controller\EasyAdmin;

use App\Entity\Station;
use App\Entity\Ticket;
use App\Entity\Train;
use App\Entity\Trip;
use App\Entity\TripHistory;
use App\Entity\User;
use App\Entity\Zone;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    #[Route(path: '/admin', name: 'easyadmin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('TER Demo');
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            ->setDateTimeFormat('medium', 'short');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getFullName());
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class);

        yield MenuItem::section('Travel');
        yield MenuItem::linkToCrud('Tickets', 'fa fa-ticket', Ticket::class);

        yield MenuItem::section('Train Network');
        yield MenuItem::linkToCrud('Train', 'fa fa-train', Train::class);
        yield MenuItem::linkToCrud('Station', 'fa fa-place-of-worship', Station::class);
        yield MenuItem::linkToCrud('Zone', 'fa fa-ruler-horizontal', Zone::class);

        yield MenuItem::section('Trip');
        yield MenuItem::linkToCrud('Trips', 'fa fa-route', Trip::class);
        yield MenuItem::linkToCrud('Trip History', 'fa fa-timeline', TripHistory::class);
    }
}
