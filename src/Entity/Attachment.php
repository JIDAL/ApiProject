<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttachmentRepository")
 * @Serializer\ExclusionPolicy("all")
 */
class Attachment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"assign", "create"})
     *
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotNull()
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"create"})
     */
    private $path;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotNull()
     * @Serializer\Expose()
     * @Serializer\SerializedName("created_at")
     * @Serializer\Type("DateTime<'Y-m-d H:i:s'>")
     * @Serializer\Groups(groups={"create"})
     */
    private $created_at;

    public function __construct($path)
    {
        if($path){
            $this->path = $path;
        }
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

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
