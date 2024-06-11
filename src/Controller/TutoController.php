<?php

namespace App\Controller;


use App\Entity\Tuto;
use App\Repository\TutoRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TutoController extends AbstractController
{
    #[Route('/tuto/{id}', name: 'app_tuto')]
    public function index(TutoRepository $productRepository, int $id): Response
    {
        //"getRepository" pour récyperer un acces class Tuto 
        //On peut utiliser function "find()" qui est equivalant en SQL "Select * from Tuto Where id={id}" 
            //$product=$entityManager->getRepository(Tuto::class)->find($id);

        //19-21行目の記述もOK　２４行目の記述もOK　２種類の書き方がある(Tutorepositoryも定義するのを忘れず！)
        $product=$productRepository->findOneById($id);
        if(!$product){
            throw $this->createNotFoundException(
                'No produit found for id'.$id
            );
        }

        //key&Value->keyに当たる部分がTwigの{{ }}で使用される
        return $this->render('tuto/index.html.twig', [
            'controller_name' => 'TutoController',
            'name' => $product->getName()
        ]);
    }

    
    #[Route('/add-tuto', name: 'create_tuto')]
    public function createTuto(EntityManagerInterface $entityManager): Response
    {
        $product = new Tuto();
        $product->setName('Unity');
        $product->setSlug('tuto-unity');
        $product->setSubtitle('sub title!');
        $product->setDescription('Ergonomic and stylish!');
        $product->setImage('kame1.jpg');
        $product->setVideo('xcZxPlZBwAU');
        $product->setLink('https://symfony.com/doc/current/doctrine.html#persisting-objects-to-the-database');
        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
}
