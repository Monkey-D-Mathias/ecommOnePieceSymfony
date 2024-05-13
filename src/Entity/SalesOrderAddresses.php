<?php

namespace App\Entity;

use App\Repository\SalesOrderAddressesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalesOrderAddressesRepository::class)]
class SalesOrderAddresses
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(inversedBy: 'salesOrderAddresses')]
    private ?SalesOrder $salesOrderId = null;

    #[ORM\OneToMany(mappedBy: 'salesOrderAddresses', targetEntity: Address::class)]
    private Collection $orderAddressId;

    public function __construct()
    {
        $this->orderAddressId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getSalesOrderId(): ?SalesOrder
    {
        return $this->salesOrderId;
    }

    public function setSalesOrderId(?SalesOrder $salesOrderId): static
    {
        $this->salesOrderId = $salesOrderId;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getOrderAddressId(): Collection
    {
        return $this->orderAddressId;
    }

    public function addOrderAddressId(Address $orderAddressId): static
    {
        if (!$this->orderAddressId->contains($orderAddressId)) {
            $this->orderAddressId->add($orderAddressId);
            $orderAddressId->setSalesOrderAddresses($this);
        }

        return $this;
    }

    public function removeOrderAddressId(Address $orderAddressId): static
    {
        if ($this->orderAddressId->removeElement($orderAddressId)) {
            // set the owning side to null (unless already changed)
            if ($orderAddressId->getSalesOrderAddresses() === $this) {
                $orderAddressId->setSalesOrderAddresses(null);
            }
        }

        return $this;
    }
}
