<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Facture;
use App\Entity\Lignes;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use DateTimeInterface;
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
    public function pay(ManagerRegistry $managerRegistry):Response
    {
        $session = $this->requestStack->getSession();
        $manager = $managerRegistry->getManager();
        $panier = $session->get('panier');
        $facture = new Facture();
        $facture->setIdUser($this->getUser());
        $facture->setDeliveryDate(new \DateTime());
        $manager->persist($facture);
        $manager->flush();
        foreach ($panier as $id=>$quantite){
            $article = new Article();
            $article->setStock($article->getStock() - $quantite);
            $ligne = new Lignes();
            $ligne->setIdFacture($facture);
            $ligne->setIdArticle($article);
            $ligne->setQuantity($quantite);
            $manager->persist($ligne);
        }
        $manager->flush();
        $session->remove('panier');

        $this->addFlash('success', 'Article commandé');
        return $this->redirectToRoute('app_compte_client');

    }
}
