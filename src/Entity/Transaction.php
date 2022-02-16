<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=CryptoWallet::class, inversedBy="transactions")
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?CryptoWallet
    {
        return $this->name;
    }

    public function setName(?CryptoWallet $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }


}
