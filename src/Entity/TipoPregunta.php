<?php

namespace App\Entity;

use App\Repository\TipoPreguntaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=TipoPreguntaRepository::class)
 */
class TipoPregunta
{
    use TimestampableEntity;
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="string", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */

    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=510, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\OneToMany(targetEntity=Pregunta::class, mappedBy="tipoPregunta")
     */
    private $pregunta;

    /**
     * @ORM\Column(type="string", length=510, nullable=true)
     */
    private $cssClass;

    public function __construct()
    {
        $this->pregunta = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getType(): ?Uuid
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection|Pregunta[]
     */
    public function getPregunta(): Collection
    {
        return $this->pregunta;
    }

    public function addPreguntum(Pregunta $preguntum): self
    {
        if (!$this->pregunta->contains($preguntum)) {
            $this->pregunta[] = $preguntum;
            $preguntum->setTipoPregunta($this);
        }

        return $this;
    }

    public function removePreguntum(Pregunta $preguntum): self
    {
        if ($this->pregunta->removeElement($preguntum)) {
            // set the owning side to null (unless already changed)
            if ($preguntum->getTipoPregunta() === $this) {
                $preguntum->setTipoPregunta(null);
            }
        }

        return $this;
    }

    public function getCssClass(): ?string
    {
        return $this->cssClass;
    }

    public function setCssClass(?string $cssClass): self
    {
        $this->cssClass = $cssClass;

        return $this;
    }
}
