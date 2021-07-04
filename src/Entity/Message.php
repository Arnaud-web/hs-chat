<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messagesSend")
     */
    private $userSend;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messagesReceved")
     */
    private $userReceved;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $idm;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $sendAt;

    /**
     * @ORM\OneToMany(targetEntity=MessageVu::class, mappedBy="message")
     */
    private $messageVus;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $new;

    public function __construct()
    {
        $this->messageVus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getUserSend(): ?User
    {
        return $this->userSend;
    }

    public function setUserSend(?User $userSend): self
    {
        $this->userSend = $userSend;

        return $this;
    }

    public function getUserReceved(): ?User
    {
        return $this->userReceved;
    }

    public function setUserReceved(?User $userReceved): self
    {
        $this->userReceved = $userReceved;

        return $this;
    }

    public function getIdm(): ?string
    {
        return $this->idm;
    }

    public function setIdm(string $idm): self
    {
        $this->idm = $idm;

        return $this;
    }

    public function isSender(User $user){
        if ($this->getUserSend()->getId() === $user->getId()){
            return true;
        }
        return false;
    }

    public function getSendAt(): ?\DateTimeInterface
    {
        return $this->sendAt;
    }

    public function setSendAt(\DateTimeInterface $sendAt): self
    {
        $this->sendAt = $sendAt;

        return $this;
    }

    /**
     * @return Collection|MessageVu[]
     */
    public function getMessageVus(): Collection
    {
        return $this->messageVus;
    }

    public function getMessageVu($id)
    {
        $vus =  $this->messageVus;
        foreach ($vus as $vu){
            if ($vu->getUser()->getId()==$id){
                return $vu;
            }
        }
        return [];
    }

    public function addMessageVu(MessageVu $messageVu): self
    {
        if (!$this->messageVus->contains($messageVu)) {
            $this->messageVus[] = $messageVu;
            $messageVu->setMessage($this);
        }

        return $this;
    }

    public function removeMessageVu(MessageVu $messageVu): self
    {
        if ($this->messageVus->removeElement($messageVu)) {
            // set the owning side to null (unless already changed)
            if ($messageVu->getMessage() === $this) {
                $messageVu->setMessage(null);
            }
        }

        return $this;
    }

    public function getNew(): ?bool
    {
        return $this->new;
    }

    public function setNew(?bool $new): self
    {
        $this->new = $new;

        return $this;
    }
}
