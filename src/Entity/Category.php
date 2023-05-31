<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $categorytitle = null;

    #[ORM\Column(length: 255)]
    private ?string $categorydescription = null;

    #[ORM\Column(nullable: true)]
    private ?int $idsarticles = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Article::class)]
    private Collection $articles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorytitle(): ?string
    {
        return $this->categorytitle;
    }

    public function setCategorytitle(string $categorytitle): self
    {
        $this->categorytitle = $categorytitle;

        return $this;
    }

    public function getCategorydescription(): ?string
    {
        return $this->categorydescription;
    }

    public function setCategorydescription(string $categorydescription): self
    {
        $this->categorydescription = $categorydescription;

        return $this;
    }

    public function getIdsarticles(): ?string
    {
        return $this->idsarticles;
    }

    public function setIdsarticles(?string $idsarticles): self
    {
        $this->idsarticles = $idsarticles;

        return $this;
    }

    /**
     * @return Collection<int, Article>
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles->add($article);
            $article->setCategory($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getCategory() === $this) {
                $article->setCategory(null);
            }
        }

        return $this;
    }
}
