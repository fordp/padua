<?php

namespace App\Entity;

use DateTimeInterface;

/**
 * The Bank Transaction Entity. This could easily be converted into the doctrine
 * ORM entity for DB storage.
 */
class BankTransaction
{
    private DateTimeInterface $Date;
    private string $TransactionCode;
    private int $CustomerNumber;
    private string $Reference;
    private float $Amount;


    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(?\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getTransactionCode(): ?string
    {
        return $this->TransactionCode;
    }

    public function setTransactionCode(?string $TransactionCode): self
    {
        $this->TransactionCode = $TransactionCode;

        return $this;
    }

    public function getCustomerNumber(): ?int
    {
        return $this->CustomerNumber;
    }

    public function setCustomerNumber(?int $CustomerNumber): self
    {
        $this->CustomerNumber = $CustomerNumber;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->Reference;
    }

    public function setReference(?string $Reference): self
    {
        $this->Reference = $Reference;

        return $this;
    }

    public function getAmount(): ?float
    {
        return $this->Amount;
    }

    public function setAmount(?float $Amount): self
    {
        $this->Amount = $Amount;

        return $this;
    }
}
