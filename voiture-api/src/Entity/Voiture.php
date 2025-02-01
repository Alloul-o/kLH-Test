<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups; 
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 * @ORM\Table(name="voiture") // Ensure Doctrine uses the correct table name
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Groups("voiture:read")
     */
    #[Assert\NotBlank(message: "Le modèle est obligatoire.")]
    private ?string $model = null;

    /**
     * @ORM\Column(type="integer", nullable=false)
     * @Groups("voiture:read")
     */
    #[Assert\NotBlank(message: "La vitesse est obligatoire.")]
    #[Assert\Positive(message: "La vitesse doit être un nombre positif.")]
    private ?int $kmh = null;

    /**
     * @ORM\Column(type="json", nullable=true)
     * @Groups("voiture:read")
     */
    private ?array $characteristics = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): ?string { return $this->model; }
    public function setModel(string $model): self { $this->model = $model; return $this; }

    public function getKmh(): ?int { return $this->kmh; }
    public function setKmh(int $kmh): self { $this->kmh = $kmh; return $this; }

    public function getCharacteristics(): ?array { return $this->characteristics; }
    public function setCharacteristics(?array $characteristics): self { $this->characteristics = $characteristics; return $this; }
}
