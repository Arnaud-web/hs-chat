<?php

namespace App\Entity;

use App\Repository\ArticleVuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleVuRepository::class)
 */
class ArticleVu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Article::class, inversedBy="articleVu", cascade={"persist", "remove"})
     */
    private $article;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="articleVus")
     */
    private $userVu;

    public function __construct()
    {
        $this->userVu = new ArrayCollection();
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
    public function getUserVu(): Collection
    {
        return $this->userVu;
    }

    public function addUserVu(User $userVu): self
    {
        if (!$this->userVu->contains($userVu)) {
            $this->userVu[] = $userVu;
        }

        return $this;
    }

    public function removeUserVu(User $userVu): self
    {
        $this->userVu->removeElement($userVu);

        return $this;
    }
}
