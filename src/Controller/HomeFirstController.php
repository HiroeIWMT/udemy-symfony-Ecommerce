<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeFirstController extends AbstractController
{
    #[Route('/home/first', name: 'app_home_first')]
    public function index(): Response
    {
        return $this->render('home_first/index.html.twig', [
            'controller_name' => 'HomeFirstController',
        ]);
    }
}
