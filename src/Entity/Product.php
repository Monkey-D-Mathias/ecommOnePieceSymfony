<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $price_ht = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deleted_at = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: CartItem::class)]
    private Collection $cartItems;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $categories = null;

    #[ORM\ManyToOne(inversedBy: 'productId')]
    private ?SalesOrderLine $salesOrderLine = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Tax $taxes = null;

    public function __construct()
    {
        $this->cartItems = new ArrayCollection();
    }

    /*
    #[ORM\Column(length: 128, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?float $priceWT = null;

    #[ORM\Column(nullable: true)]
    private ?int $stock = null;
    */

    private string $slug;

    #[ORM\OneToOne(inversedBy: 'product', cascade: ['persist', 'remove'])]
    private ?File $file = null;

    public function getSlug(): string
    {
        return $this->slug;
    }

    //Construction du slugg à la volée
    //public function getSluggerDynamic(): string
    //{
        //$slugger = new AsciiSlugger();
        //$slug = $slugger->slug($this->name);

        //return strtolower($slug);
    //}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    //public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getPriceHt(): ?float
    {
        return $this->price_ht;
    }

    public function setPriceHt(float $price_ht): static
    {
        $this->price_ht = $price_ht;
        return $this;
    }
  
    /*
    public function getPriceWT(): ?float
    {
        return $this->priceWT;
    }

    public function setPriceWT(?float $priceWT): static
    {
        $this->priceWT = $priceWT;
     */

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(?int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeInterface
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeInterface $deleted_at): static
    {
        $this->deleted_at = $deleted_at;

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
            $cartItem->setProduct($this);
        }

        return $this;
    }

    public function removeCartItem(CartItem $cartItem): static
    {
        if ($this->cartItems->removeElement($cartItem)) {
            // set the owning side to null (unless already changed)
            if ($cartItem->getProduct() === $this) {
                $cartItem->setProduct(null);
            }
        }

        return $this;
    }

    public function getCategories(): ?Category
    {
        return $this->categories;
    }

    public function setCategories(?Category $categories): static
    {
        $this->categories = $categories;

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

    public function getTaxes(): ?Tax
    {
        return $this->taxes;
    }

    public function setTaxes(?Tax $taxes): static
    {
        $this->taxes = $taxes;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): static
    {
        $this->file = $file;

        return $this;
    }
}
