<?php

namespace App\Entity;

use App\Repository\CuestionarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Component\Uid\Ulid;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;

/**
 * @ORM\Entity(repositoryClass=CuestionarioRepository::class)
 */
class Cuestionario
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\Column(type="ulid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UlidGenerator::class)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActivo;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $identificador;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cuestionarios")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Pregunta::class, mappedBy="cuestionario")
     */
    private $preguntas;

    /**
     * @ORM\OneToMany(targetEntity=Formulario::class, mappedBy="cuestionario")
     */
    private $formularios;

    /**
     * @ORM\ManyToOne(targetEntity=Ministry::class, inversedBy="cuestionario")
     */
    private $ministry;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageFilename;

    public function __construct()
    {
        $this->preguntas = new ArrayCollection();
        $this->formularios = new ArrayCollection();
    }

    public function getId(): ?Ulid
    {
        return $this->id;
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

    public function getIsActivo(): ?bool
    {
        return $this->isActivo;
    }

    public function setIsActivo(?bool $isActivo): self
    {
        $this->isActivo = $isActivo;

        return $this;
    }

    public function getIdentificador(): ?string
    {
        return $this->identificador;
    }

    public function setIdentificador(string $identificador): self
    {
        $this->identificador = $identificador;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Pregunta[]
     */
    public function getPreguntas(): Collection
    {
        return $this->preguntas;
    }

    public function addPregunta(Pregunta $pregunta): self
    {
        if (!$this->preguntas->contains($pregunta)) {
            $this->preguntas[] = $pregunta;
            $pregunta->setCuestionario($this);
        }

        return $this;
    }

    public function removePregunta(Pregunta $pregunta): self
    {
        if ($this->preguntas->removeElement($pregunta)) {
            // set the owning side to null (unless already changed)
            if ($pregunta->getCuestionario() === $this) {
                $pregunta->setCuestionario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Formulario[]
     */
    public function getFormularios(): Collection
    {
        return $this->formularios;
    }

    public function addFormulario(Formulario $formulario): self
    {
        if (!$this->formularios->contains($formulario)) {
            $this->formularios[] = $formulario;
            $formulario->setCuestionario($this);
        }

        return $this;
    }

    public function removeFormulario(Formulario $formulario): self
    {
        if ($this->formularios->removeElement($formulario)) {
            // set the owning side to null (unless already changed)
            if ($formulario->getCuestionario() === $this) {
                $formulario->setCuestionario(null);
            }
        }

        return $this;
    }

    public function getMinistry(): ?Ministry
    {
        return $this->ministry;
    }

    public function setMinistry(?Ministry $ministry): self
    {
        $this->ministry = $ministry;

        return $this;
    }

    public function getImageFilename(): ?string
    {
        return $this->imageFilename;
    }

    public function setImageFilename(?string $imageFilename): self
    {
        $this->imageFilename = $imageFilename;

        return $this;
    }
}
