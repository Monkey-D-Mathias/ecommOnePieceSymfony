<?php

namespace App\Entity;

use App\Repository\SalesOrderLineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalesOrderLineRepository::class)]
class SalesOrderLine
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $unitPrice = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?int $valueAddedTax = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\OneToMany(mappedBy: 'salesOrderLine', targetEntity: SalesOrder::class)]
    private Collection $orderId;

    #[ORM\OneToMany(mappedBy: 'salesOrderLine', targetEntity: Product::class)]
    private Collection $productId;

    public function __construct()
    {
        $this->orderId = new ArrayCollection();
        $this->productId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnitPrice(): ?int
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(int $unitPrice): static
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getValueAddedTax(): ?int
    {
        return $this->valueAddedTax;
    }

    public function setValueAddedTax(int $valueAddedTax): static
    {
        $this->valueAddedTax = $valueAddedTax;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(\DateTimeImmutable $deletedAt): static
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * @return Collection<int, SalesOrder>
     */
    public function getOrderId(): Collection
    {
        return $this->orderId;
    }

    public function addOrderId(SalesOrder $orderId): static
    {
        if (!$this->orderId->contains($orderId)) {
            $this->orderId->add($orderId);
            $orderId->setSalesOrderLine($this);
        }

        return $this;
    }

    public function removeOrderId(SalesOrder $orderId): static
    {
        if ($this->orderId->removeElement($orderId)) {
            // set the owning side to null (unless already changed)
            if ($orderId->getSalesOrderLine() === $this) {
                $orderId->setSalesOrderLine(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProductId(): Collection
    {
        return $this->productId;
    }

    public function addProductId(Product $productId): static
    {
        if (!$this->productId->contains($productId)) {
            $this->productId->add($productId);
            $productId->setSalesOrderLine($this);
        }

        return $this;
    }

    public function removeProductId(Product $productId): static
    {
        if ($this->productId->removeElement($productId)) {
            // set the owning side to null (unless already changed)
            if ($productId->getSalesOrderLine() === $this) {
                $productId->setSalesOrderLine(null);
            }
        }

        return $this;
    }
}
