<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/client/compte', name: 'app_compte_client')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $email = $this->getUser()->getUserIdentifier();
        $repository = $managerRegistry->getRepository(User::class);
        $user = $repository->getAllByEmail($email);


        return $this->render('client/compte.html.twig', [
            'controller_name' => 'ClientController',
            'user_info' => $user[0],
        ]);
    }

    #[Route('/client/panier', name: 'app_panier')]
    public function cart(ArticleRepository $articleRepository):Response
    {
        $session = $this->requestStack->getSession();
        $panier = $session->get('panier',[]);
        $dataCart = [];
        $total = 0;
        foreach ($panier as $id => $quantite){
            $article = $articleRepository->find($id);
            $dataCart[] = [
                'produit' => $article,
                'quantite' => $quantite
            ];
            $total += $article->getPrix() * $quantite;
        }


        return $this->render('/client/panier.html.twig' , compact('dataCart','total'));
    }
}
