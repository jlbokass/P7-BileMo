<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 *
 * @ExclusionPolicy("all")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *     "app_product_show",
 *     parameters={"id" = "expr(object.getId())"},
 *     absolute=true
 *     )
 * )
 *
 */
class Product
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Serializer\Since("1.0")
     *
     * @Serializer\Expose
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Serializer\Since("1.0")
     *
     * @Serializer\Expose
     */
    private $memory;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Serializer\Since("1.0")
     *
     * @Serializer\Expose
     */
    private $color;

    /**
     * @ORM\Column(type="text")
     *
     * @Serializer\Since("1.0")
     *
     * @Serializer\Expose
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Serializer\Since("2.0")
     *
     * @Serializer\Expose
     */
    private $weight;

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

    public function getMemory(): ?string
    {
        return $this->memory;
    }

    public function setMemory(string $memory): self
    {
        $this->memory = $memory;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->colr;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

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

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }
}
