<?php

namespace App\Entity;

use App\Repository\MessageVuRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageVuRepository::class)
 */
class MessageVu
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messageVus")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Message::class, inversedBy="messageVus")
     */
    private $message;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $vuAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getMessage(): ?Message
    {
        return $this->message;
    }

    public function setMessage(?Message $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getVuAt(): ?\DateTimeInterface
    {
        return $this->vuAt;
    }

    public function setVuAt(?\DateTimeInterface $vuAt): self
    {
        $this->vuAt = $vuAt;

        return $this;
    }
}
