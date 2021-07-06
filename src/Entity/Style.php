<?php

namespace App\Entity;

use App\Repository\StyleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StyleRepository::class)
 */
class Style
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $navColor;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="style", cascade={"persist", "remove"})
     */
    private $userStyle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNavColor(): ?string
    {
        return $this->navColor;
    }

    public function setNavColor(?string $navColor): self
    {
        $this->navColor = $navColor;

        return $this;
    }

    public function getUserStyle(): ?User
    {
        return $this->userStyle;
    }

    public function setUserStyle(?User $userStyle): self
    {
        $this->userStyle = $userStyle;

        return $this;
    }
}
