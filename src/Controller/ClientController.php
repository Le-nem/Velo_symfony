<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
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
}
