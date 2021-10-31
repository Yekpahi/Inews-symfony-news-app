<?php

namespace App\Entity;

use App\Repository\ImageALaUneRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImageALaUneRepository::class)
 */
class ImageALaUne
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Laune::class, inversedBy="images")
     * @ORM\JoinColumn(nullable=false)
     */
    private $launes;



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

    public function getLaunes(): ?Laune
    {
        return $this->launes;
    }

    public function setLaunes(?Laune $launes): self
    {
        $this->launes = $launes;

        return $this;
    }
}
