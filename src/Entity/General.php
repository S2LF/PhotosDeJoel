<?php

namespace App\Entity;

use App\Repository\GeneralRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GeneralRepository::class)
 */
class General
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titre_du_site_header;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $texte_header;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mot_page_accueil;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo_accueil_path;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $text_footer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitreDuSiteHeader(): ?string
    {
        return $this->titre_du_site_header;
    }

    public function setTitreDuSiteHeader(?string $titre_du_site_header): self
    {
        $this->titre_du_site_header = $titre_du_site_header;

        return $this;
    }

    public function getTexteHeader(): ?string
    {
        return $this->texte_header;
    }

    public function setTexteHeader(?string $texte_header): self
    {
        $this->texte_header = $texte_header;

        return $this;
    }

    public function getMotPageAccueil(): ?string
    {
        return $this->mot_page_accueil;
    }

    public function setMotPageAccueil(?string $mot_page_accueil): self
    {
        $this->mot_page_accueil = $mot_page_accueil;

        return $this;
    }

    public function getPhotoAccueilPath(): ?string
    {
        return $this->photo_accueil_path;
    }

    public function setPhotoAccueilPath(?string $photo_accueil_path): self
    {
        $this->photo_accueil_path = $photo_accueil_path;

        return $this;
    }

    public function getTextFooter(): ?string
    {
        return $this->text_footer;
    }

    public function setTextFooter(?string $text_footer): self
    {
        $this->text_footer = $text_footer;

        return $this;
    }
}
