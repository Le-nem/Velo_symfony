<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin_produit', name: 'app_admin_produit')]
    public function index(ManagerRegistry $managerRegistry): Response
    {
        $repository = $managerRegistry->getRepository(Article::class);
        $article = $repository->findAll();

        return $this->render('admin/produit.html.twig', [
            'controller_name' => 'AdminController',
            'article' => $article,
        ]);
    }
}
