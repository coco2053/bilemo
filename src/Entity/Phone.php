<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use JMS\Serializer\Annotation\ExclusionPolicy;

/**
 * This class represents the phone enity.
 * @author Bastien Vacherand.
 *
 * @ORM\Entity(repositoryClass="App\Repository\PhoneRepository")
 * @UniqueEntity(
 * fields= {"modelName"},
 * groups={"Create"},
 * message= "Model name entered already registered !")
 *
 * @ExclusionPolicy("all")
 *
 * @Hateoas\Relation(
 *      "get",
 *      href = @Hateoas\Route(
 *          "product_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      )
 * )
 */
class Phone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     *
     */
    private $modelName;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     *
     */
    private $modelRef;

    /**
     * @ORM\Column(type="smallint")
     *
     * @Serializer\Expose
     * @Serializer\Since("2.0")
     *
     */
    private $memory;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Expose
     * @Serializer\Since("2.0")
     *
     */
    private $color;

    /**
     * @ORM\Column(type="float")
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     *
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     *
     * @Serializer\Expose
     * @Serializer\Since("1.0")
     *
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModelName(): ?string
    {
        return $this->modelName;
    }

    public function setModelName(string $modelName): self
    {
        $this->modelName = $modelName;

        return $this;
    }

    public function getModelRef(): ?string
    {
        return $this->modelRef;
    }

    public function setModelRef(string $modelRef): self
    {
        $this->modelRef = $modelRef;

        return $this;
    }

    public function getMemory(): ?int
    {
        return $this->memory;
    }

    public function setMemory(int $memory): self
    {
        $this->memory = $memory;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

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
}
