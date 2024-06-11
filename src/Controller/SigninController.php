<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SigninType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SigninController extends AbstractController
{
    #[Route('/signin', name: 'app_signin')]
    public function index(Request $req, EntityManagerInterface $entityManager, UserPasswordHasherInterface $PasswordHasher): Response
    {
    $user = new User();

    //"createForm"est un function propre symfony qui prend paramettre SigninTypeForm(premier para), deuxieme para qui est User
    $form = $this->createForm(SigninType::class, $user);

    //ça gerer les données qui ont été soumis
    $form->handleRequest($req);

    if($form->isSubmitted() && $form->isValid())
    {
        $user = $form->getData();
       
        //32-38はhasherの一連のくだり
        $plainPassword = $user->getPassword();
        $hashPassword = $PasswordHasher->hashPassword(
            $user,
            $plainPassword
        );
        $user->setPassword($hashPassword);

        $entityManager->persist($user);
        $entityManager->flush();

        // リダイレクトなどの次のアクション
        return $this->render('home_first/index.html.twig'); // 適切なルートにリダイレクト
    }//else後ほど追加

        return $this->render('signin/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
