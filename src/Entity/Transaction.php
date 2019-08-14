<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TransactionRepository")
 * @Serializer\ExclusionPolicy("all")
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
     * @ORM\Column(type="string", length=255)
     *
     * @Serializer\Expose()
     * @Serializer\SerializedName("type")
     * @Serializer\Groups(groups={"create"})
     *
     * @Assert\NotBlank()
     *
     */
    private $type;

    /**
     * @ORM\Column(type="text", nullable=true)
     *
     * @Serializer\Expose()
     * @Serializer\SerializedName("desc")
     * @Serializer\Groups(groups={"create"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Serializer\Expose()
     * @Serializer\SerializedName("statut")
     * @Serializer\Groups(groups={"create"})
     *
     * @Assert\NotNull(groups={"create"})
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     *
     * @Serializer\Expose()
     * @Serializer\SerializedName("created_at")
     * @Serializer\Groups(groups={"create"})
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     *
     * @Assert\NotNull(groups={"create"})
     */
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
