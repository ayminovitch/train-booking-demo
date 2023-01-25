<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/homepage', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('homepage/homepage_content.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

    public function searchTrip(): Response
    {
        return $this->render('homepage/search_trip.html.twig');
    }
}
