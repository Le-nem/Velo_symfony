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

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'lignes')]
    private $id_article;

    #[ORM\ManyToOne(targetEntity: Facture::class, inversedBy: 'lignes')]
    private $id_facture;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $quantity;

    public function __construct()
    {
        $this->id_article = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Article>
     */
//    public function getIdArticle(): Collection
//    {
//        return $this->id_article;
//    }

    public function addIdArticle(Article $idArticle): self
    {
        if (!$this->id_article->contains($idArticle)) {
            $this->id_article[] = $idArticle;
            $idArticle->setLignes($this);
        }

        return $this;
    }

    public function removeIdArticle(Article $idArticle): self
    {
        if ($this->id_article->removeElement($idArticle)) {
            // set the owning side to null (unless already changed)
            if ($idArticle->getLignes() === $this) {
                $idArticle->setLignes(null);
            }
        }

        return $this;
    }

    public function getIdFacture(): ?Facture
    {
        return $this->id_facture;
    }

    public function setIdFacture(?Facture $id_facture): self
    {
        $this->id_facture = $id_facture;

        return $this;
    }
    public function getIdArticle(): ?Article
    {
        return $this->id_article;
    }

    public function setIdArticle(?Article $id_article): self
    {
        $this->id_facture = $id_article;

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
