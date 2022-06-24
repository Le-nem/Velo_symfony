<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Facture;
use App\Entity\Lignes;
use App\Repository\ArticleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class ArticleController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    #[Route('/article', name: 'app_article')]
    public function index(ManagerRegistry $managerRegistry): Response
    {

        $repository = $managerRegistry->getRepository(Article::class);

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $repository->findAll(),
        ]);
    }

    #[Route('/order/{id<\d+>}', name: 'app_order')]
        public function order(Article $article):Response
    {
        $id = $article->getId();
        $session = $this->requestStack->getSession();
        $panier = $session->get('panier',[]);
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }
        $session->set('panier' , $panier);
        $this->addFlash('success', 'Article ajouté au panier');
        return $this->redirectToRoute('app_panier');

    }
    #[Route('/remove/{id<\d+>}', name: 'app_remove')]
    public function remove(Article $article):Response
    {
        $id = $article->getId();
        $session = $this->requestStack->getSession();
        $panier = $session->get('panier',[]);
        if(!empty($panier[$id])){
            if($panier[$id] >1 ){
                $panier[$id]-- ;
            }else{
                unset($panier[$id]);
            }
        }else{
        }
        $session->set('panier' , $panier);
        $this->addFlash('success', 'Article ajouté au panier');
        return $this->redirectToRoute('app_panier');

    }
    #[Route('/delete/{id<\d+>}', name: 'app_delete')]
    public function delete(Article $article):Response
    {
        $id = $article->getId();
        $session = $this->requestStack->getSession();
        $panier = $session->get('panier',[]);
        if(!empty($panier[$id])){
            unset($panier[$id]);
        }
        $session->set('panier' , $panier);
        $this->addFlash('success', 'Article ajouté au panier');
        return $this->redirectToRoute('app_panier');

    }
    #[Route('/pay', name: 'app_pay')]
    public function pay(ManagerRegistry $managerRegistry,ArticleRepository $article):Response
    {
        $session = $this->requestStack->getSession();
        $manager = $managerRegistry->getManager();
        $panier = $session->get('panier');
        $total = $session->get('total');
        $commande[] = date("F j, Y, g:i a");
        foreach ($panier as $id=>$quantite) {
            $arti = $article->find($id);
            $com[] = array(
               'description' => $arti->getDescription(),
               'prix' => $arti->getPrix(),
               'quantite'  => $quantite,
                );
        }
        $commande[] = $com;
        $commande[] = $total;
        json_encode($commande);
        $facture = new Facture();
        $facture->setIdUser($this->getUser());
        $facture->setDeliveryDate(new \DateTime());
        $facture->setCommannde($commande);
        foreach ($panier as $id=>$quantite){
            $art = $article->find($id);
            $art->setStock($art->getStock() - $quantite);
            $ligne = new Lignes();
            $ligne->setFacture($facture);
            $ligne->setArticle($art);
            $ligne->setQuantity($quantite);
            $manager->persist($facture);
            $manager->persist($ligne);
            $manager->persist($art);
        }
        $manager->flush();
        $session->remove('panier');

        $this->addFlash('success', 'Article commandé');
        return $this->redirectToRoute('app_compte_client');

    }
}
