<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends AbstractController
{
    #[Route('/trips', name: 'app_trip')]
    public function index(): Response
    {
        return $this->render('trip/list.html.twig');
    }

    #[Route('/trips/create', name: 'app_trip_create')]
    public function create(): Response
    {
        return $this->render('trip/trip-booking.html.twig');
    }

    #[Route('/trips/payment', name: 'app_trip_payment')]
    public function createConfirm(): Response
    {
        return $this->render('trip/trip-payment.html.twig');
    }
}
