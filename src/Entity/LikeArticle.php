<?php

namespace App\Entity;

use App\Repository\LikeArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LikeArticleRepository::class)
 */
class LikeArticle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Article::class, inversedBy="likeArticle", cascade={"persist", "remove"})
     */
    private $article;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="likeArticles")
     */
    private $userLike;

    public function __construct()
    {
        $this->userLike = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection|User[]
     */
    public function getUserLike(): Collection
    {
        return $this->userLike;
    }

    public function addUserLike(User $userLike): self
    {
        if (!$this->userLike->contains($userLike)) {
            $this->userLike[] = $userLike;
        }

        return $this;
    }

    public function removeUserLike(User $userLike): self
    {
        $this->userLike->removeElement($userLike);

        return $this;
    }
}
