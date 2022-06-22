<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\User;
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
    #[Route('/admin_user', name: 'app_admin_user')]
    public function index1(ManagerRegistry $managerRegistry): Response
    {
        $repository = $managerRegistry->getRepository(User::class);
        $user = $repository->findAll();

        return $this->render('admin/user.html.twig', [
            'controller_name' => 'AdminController',
            'users' => $user,
        ]);
    }
    #[Route('/edit_article/{id}', name: 'app_edit_article')]
    public function editArticle(ManagerRegistry $managerRegistry, $id): Response
    {

    }
}
