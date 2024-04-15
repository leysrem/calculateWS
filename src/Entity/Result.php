<?php

namespace App\Entity;

use App\Repository\ResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultRepository::class)]
class Result
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?String $number = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?String
    {
        return $this->number;
    }

    public function setNumber(String $number): static
    {
        $this->number = $number;

        return $this;
    }
}
