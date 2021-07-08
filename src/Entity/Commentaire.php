<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Article::class, inversedBy="commentaires")
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaires")
     */
    private $userComment;

    /**
     * @ORM\Column(type="datetime")
     */
    private $commentedAt;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

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

    public function getUserComment(): ?User
    {
        return $this->userComment;
    }

    public function setUserComment(?User $userComment): self
    {
        $this->userComment = $userComment;

        return $this;
    }

    public function getCommentedAt(): ?\DateTimeInterface
    {
        return $this->commentedAt;
    }

    public function setCommentedAt(\DateTimeInterface $commentedAt): self
    {
        $this->commentedAt = $commentedAt;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
