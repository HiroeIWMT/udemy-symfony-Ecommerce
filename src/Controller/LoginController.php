<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Security\Model\Authenticator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;//追記したuse

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        //get the login error if there is one (pour mot de passe n'est pas bon)
        $error = $authenticationUtils->getLastAuthenticationError();

        //last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
             'error'    => $error,
        ]);
    }

    
    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        $error = "";
        $lastUsername = "";

        return $this->render('login/index.html.twig', [
         'last_username' => $lastUsername,
         'error'    => $error,
    ]);
    }
}
