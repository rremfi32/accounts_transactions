<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 * @UniqueEntity("tid")
 */
class Transaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=32, unique=true)
     * @Assert\Length(min=12, max=32)
     */
    private $tid;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="transactions")
     */
    private $uid;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\Choice({"debit", "credit"})
     */
    private $type;

    /**
     * @ORM\Column(type="datetime")
     */
    private $transaction_date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getTid(): ?string
    {
        return $this->tid;
    }

    public function setTid(string $tid): self
    {
        $this->tid = $tid;

        return $this;
    }

    public function getUid(): ?Account
    {
        return $this->uid;
    }

    public function setUid(?Account $uid): self
    {
        $this->uid = $uid;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getTransactionDate(): ?\DateTimeInterface
    {
        return $this->transaction_date;
    }

    public function setTransactionDate(\DateTimeInterface $transaction_date): self
    {
        $this->transaction_date = $transaction_date;

        return $this;
    }
}
