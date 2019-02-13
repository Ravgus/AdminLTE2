<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @UniqueEntity(fields="title", message="This title is already used")
 * @ORM\Table()
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="255")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotEqualTo("<p>&nbsp;</p>", message="This value should not be empty")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @ORM\Column(type="float", options={"unsigned"=true})
     * @Assert\Type(type="numeric", message="The value {{ value }} must be numeric")
     * @Assert\Range(min="0", max="4294967295")
     * @Assert\NotBlank()
     */
    private $price;

    /**
     * @ORM\Column(type="integer", options={"unsigned"=true})
     * @Assert\Type(type="numeric", message="The value {{ value }} must be numeric")
     * @Assert\Range(min="0", max="4294967295")
     * @Assert\NotBlank()
     */
    private $count;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @Assert\Image(maxSize="5M", maxSizeMessage="The image has to be less than 5 MB")
     */
    private $image;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image): void
    {
        $this->image = $image;
    }

    /**
     * Generates the magic method
     *
     */
    public function __toString()
    {
        return $this->title;
    }
}
