<?php

namespace App\Entity;

use App\Repository\CuestionarioRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Symfony\Bridge\Doctrine\IdGenerator\UlidGenerator;
use Symfony\Component\Uid\Ulid;
/**
 *
 *
 * Defines the properties of the Cuestionario entity to represent the application cuestionarios.
 * See https://symfony.com/doc/current/doctrine.html#creating-an-entity-class
 *
 * Tip: if you have an existing database, you can generate this entity class automatically.
 * See https://symfony.com/doc/current/doctrine/reverse_engineering.html
 *
 * @author Gerardo Montivero <gerardo.montivero@gmail.com>
 */

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

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cuestionarios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $autor;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $publishedAt;

    /**
     * @ORM\OneToMany(targetEntity=Section::class, mappedBy="cuestionario")
     */
    private $sections;

    public function __construct()
    {
        $this->formularios = new ArrayCollection();
        $this->sections = new ArrayCollection();
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

    public function getAutor(): ?User
    {
        return $this->autor;
    }

    public function setAutor(?User $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    public function setPublishedAt(?DateTimeInterface $publishedAt): self
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * @return Collection|Section[]
     */
    public function getSections(): Collection
    {
        return $this->sections;
    }

    public function addSection(Section $section): self
    {
        if (!$this->sections->contains($section)) {
            $this->sections[] = $section;
            $section->setCuestionario($this);
        }

        return $this;
    }

    public function removeSection(Section $section): self
    {
        if ($this->sections->removeElement($section)) {
            // set the owning side to null (unless already changed)
            if ($section->getCuestionario() === $this) {
                $section->setCuestionario(null);
            }
        }

        return $this;
    }
}
