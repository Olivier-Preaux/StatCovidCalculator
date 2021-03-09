<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PopulationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PopulationRepository::class)
 */
class Population
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVaccinatedFirstDose=false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVaccinatedSecondDose=false;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="patients")
     * @ORM\JoinColumn(nullable=true)
     */
    private $doctor;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observations;

    public function __toString()
    {
        return $this->firstName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getIsVaccinatedFirstDose(): ?bool
    {
        return $this->isVaccinatedFirstDose;
    }

    public function setIsVaccinatedFirstDose(bool $isVaccinatedFirstDose): self
    {
        $this->isVaccinatedFirstDose = $isVaccinatedFirstDose;

        return $this;
    }

    public function getIsVaccinatedSecondDose(): ?bool
    {
        return $this->isVaccinatedSecondDose;
    }

    public function setIsVaccinatedSecondDose(bool $isVaccinatedSecondDose): self
    {
        $this->isVaccinatedSecondDose = $isVaccinatedSecondDose;

        return $this;
    }

    public function getDoctor(): ?User
    {
        return $this->doctor;
    }

    public function setDoctor(?User $doctor): self
    {
        $this->doctor = $doctor;

        return $this;
    }

    public function getObservations(): ?string
    {
        return $this->observations;
    }

    public function setObservations(?string $observations): self
    {
        $this->observations = $observations;

        return $this;
    }
}
