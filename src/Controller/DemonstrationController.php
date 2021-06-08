<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemonstrationController extends AbstractController
{
    #[Route('/demonstration', name: 'demonstration')]
    public function index(): Response
    {
        return $this->render('demonstration/index.html.twig', [
            'controller_name' => 'DemonstrationController',
        ]);
    }
}
