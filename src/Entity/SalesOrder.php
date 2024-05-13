<?php

namespace App\Entity;

use App\Repository\SalesOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalesOrderRepository::class)]
class SalesOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $total = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(length: 255)]
    private ?string $recipient = null;

    #[ORM\ManyToOne(inversedBy: 'salesOrders')]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'salesOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cart $cart = null;

    #[ORM\OneToMany(mappedBy: 'orders', targetEntity: Delivery::class)]
    private Collection $deliveries;

    #[ORM\OneToMany(mappedBy: 'salesOrderId', targetEntity: Payment::class)]
    private Collection $payments;

    #[ORM\ManyToOne(inversedBy: 'orderId')]
    private ?SalesOrderLine $salesOrderLine = null;

    #[ORM\OneToMany(mappedBy: 'salesOrderId', targetEntity: SalesOrderAddresses::class)]
    private Collection $salesOrderAddresses;

    public function __construct()
    {
        $this->deliveries = new ArrayCollection();
        $this->payments = new ArrayCollection();
        $this->salesOrderAddresses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

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

    public function getRecipient(): ?string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): static
    {
        $this->cart = $cart;

        return $this;
    }

    /**
     * @return Collection<int, Delivery>
     */
    public function getDeliveries(): Collection
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery): static
    {
        if (!$this->deliveries->contains($delivery)) {
            $this->deliveries->add($delivery);
            $delivery->setOrders($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): static
    {
        if ($this->deliveries->removeElement($delivery)) {
            // set the owning side to null (unless already changed)
            if ($delivery->getOrders() === $this) {
                $delivery->setOrders(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Payment>
     */
    public function getPayments(): Collection
    {
        return $this->payments;
    }

    public function addPayment(Payment $payment): static
    {
        if (!$this->payments->contains($payment)) {
            $this->payments->add($payment);
            $payment->setSalesOrderId($this);
        }

        return $this;
    }

    public function removePayment(Payment $payment): static
    {
        if ($this->payments->removeElement($payment)) {
            // set the owning side to null (unless already changed)
            if ($payment->getSalesOrderId() === $this) {
                $payment->setSalesOrderId(null);
            }
        }

        return $this;
    }

    public function getSalesOrderLine(): ?SalesOrderLine
    {
        return $this->salesOrderLine;
    }

    public function setSalesOrderLine(?SalesOrderLine $salesOrderLine): static
    {
        $this->salesOrderLine = $salesOrderLine;

        return $this;
    }

    /**
     * @return Collection<int, SalesOrderAddresses>
     */
    public function getSalesOrderAddresses(): Collection
    {
        return $this->salesOrderAddresses;
    }

    public function addSalesOrderAddress(SalesOrderAddresses $salesOrderAddress): static
    {
        if (!$this->salesOrderAddresses->contains($salesOrderAddress)) {
            $this->salesOrderAddresses->add($salesOrderAddress);
            $salesOrderAddress->setSalesOrderId($this);
        }

        return $this;
    }

    public function removeSalesOrderAddress(SalesOrderAddresses $salesOrderAddress): static
    {
        if ($this->salesOrderAddresses->removeElement($salesOrderAddress)) {
            // set the owning side to null (unless already changed)
            if ($salesOrderAddress->getSalesOrderId() === $this) {
                $salesOrderAddress->setSalesOrderId(null);
            }
        }

        return $this;
    }
}
