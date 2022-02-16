<?php

namespace App\Entity;

use App\Repository\CryptoInvestmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CryptoInvestmentRepository::class)
 */
class CryptoInvestment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $gain;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGain(): ?float
    {
        return $this->gain;
    }

    public function setGain(?float $gain): self
    {
        $this->gain = $gain;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
