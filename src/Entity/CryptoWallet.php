<?php

namespace App\Entity;

use App\Repository\CryptoWalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CryptoWalletRepository::class)
 */
class CryptoWallet
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
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    /**
     * @ORM\Column(type="integer")
     */
    private $coef;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="name")
     */
    private $transactions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $symbol;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
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

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }

    public function getCoef(): ?int
    {
        return $this->coef;
    }

    public function setCoef(int $coef): self
    {
        $this->coef = $coef;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setName($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->removeElement($transaction)) {
            // set the owning side to null (unless already changed)
            if ($transaction->getName() === $this) {
                $transaction->setName(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): self
    {
        $this->symbol = $symbol;

        return $this;
    }
}
