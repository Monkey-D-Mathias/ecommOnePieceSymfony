<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CartRepository::class)]
class Cart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $total = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $savedAt = null;

    #[ORM\ManyToOne(inversedBy: 'carts')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: SalesOrder::class)]
    private Collection $salesOrders;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: CartItem::class)]
    private Collection $cartItems;

    public function __construct()
    {
        $this->salesOrders = new ArrayCollection();
        $this->cartItems = new ArrayCollection();
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

    public function getSavedAt(): ?\DateTimeImmutable
    {
        return $this->savedAt;
    }

    public function setSavedAt(?\DateTimeImmutable $savedAt): static
    {
        $this->savedAt = $savedAt;

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

    /**
     * @return Collection<int, SalesOrder>
     */
    public function getSalesOrders(): Collection
    {
        return $this->salesOrders;
    }

    public function addSalesOrder(SalesOrder $salesOrder): static
    {
        if (!$this->salesOrders->contains($salesOrder)) {
            $this->salesOrders->add($salesOrder);
            $salesOrder->setCart($this);
        }

        return $this;
    }

    public function removeSalesOrder(SalesOrder $salesOrder): static
    {
        if ($this->salesOrders->removeElement($salesOrder)) {
            // set the owning side to null (unless already changed)
            if ($salesOrder->getCart() === $this) {
                $salesOrder->setCart(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CartItem>
     */
    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }

    public function addCartItem(CartItem $cartItem): static
    {
        if (!$this->cartItems->contains($cartItem)) {
            $this->cartItems->add($cartItem);
            $cartItem->setCart($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): static
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getCart() === $this) {
                $cartItem->setCart(null);
            }
        }

        return $this;
    }
}
