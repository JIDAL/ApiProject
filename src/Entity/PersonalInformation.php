<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PersonalInformationRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Serializer\ExclusionPolicy("all")
 * @Vich\Uploadable()
 */
class PersonalInformation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"create"})
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"create"})
     */
    private $full_name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"create"})
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"create"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(groups={"create"})
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"create"})
     */
    private $personal_email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(groups={"create"})
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"create"})
     *
     */
    private $professional_email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"create"})
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"create"})
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"create"})
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"create"})
     */
    private $job;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"create"})
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"create"})
     */
    private $age;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(groups={"create"})
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"create"})
     */
    private $web;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(groups={"create"})
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"create"})
     */
    private $situation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updated_at;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Attachment", cascade={"persist", "remove"})
     * @Serializer\Expose()
     * @Serializer\Groups(groups={"show"})
     */
    private $image;

    public function __construct()
    {
        $this->updated_at = new \DateTime("now");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getPersonalEmail(): ?string
    {
        return $this->personal_email;
    }

    public function setPersonalEmail(string $personal_email): self
    {
        $this->personal_email = $personal_email;

        return $this;
    }

    public function getProfessionalEmail(): ?string
    {
        return $this->professional_email;
    }

    public function setProfessionalEmail(string $professional_email): self
    {
        $this->professional_email = $professional_email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getJob(): ?string
    {
        return $this->job;
    }

    public function setJob(string $job): self
    {
        $this->job = $job;

        return $this;
    }

    public function getAge(): ?string
    {
        return $this->age;
    }

    public function setAge(string $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getWeb(): ?string
    {
        return $this->web;
    }

    public function setWeb(string $web): self
    {
        $this->web = $web;

        return $this;
    }

    public function getSituation(): ?string
    {
        return $this->situation;
    }

    public function setSituation(string $situation): self
    {
        $this->situation = $situation;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at): void
    {
        $this->updated_at = $updated_at;
    }


    public function getImage(): ?Attachment
    {
        return $this->image;
    }

    public function setImage(?Attachment $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function OnPrePersist(){
        $this->updated_at = new \DateTime("now");
    }
}
