<?php

namespace App\Entity;

use App\Repository\LignesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LignesRepository::class)]
class Lignes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Facture::class, inversedBy: 'lignes')]
    #[ORM\JoinColumn(nullable: false)]
    private $facture;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'lignes')]
    #[ORM\JoinColumn(nullable: false)]
    private $article;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $quantity;


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
