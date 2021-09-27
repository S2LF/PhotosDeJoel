<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $exifs = [];

    /**
     * @ORM\ManyToOne(targetEntity=PhotoCategorie::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $photo_categorie;

    /**
     * @ORM\Column(type="integer")
     */
    private $position;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
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

    public function getExifs(): ?array
    {
        return $this->exifs;
    }

    public function setExifs(?array $exifs): self
    {
        $this->exifs = $exifs;

        return $this;
    }

    public function getPhotoCategorie(): ?PhotoCategorie
    {
        return $this->photo_categorie;
    }

    public function setPhotoCategorie(?PhotoCategorie $photo_categorie): self
    {
        $this->photo_categorie = $photo_categorie;

        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }
}
