<?php

namespace App\Entity;

use App\Repository\PreguntaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity(repositoryClass=PreguntaRepository::class)
 */
class Pregunta
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
    private $texto;

    /**
     * @ORM\Column(type="integer")
     */
    private $orden;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isActivo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $parametros;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isObligatoria;

    /**
     * @ORM\ManyToOne(targetEntity=Cuestionario::class, inversedBy="preguntas")
     */
    private $cuestionario;

    /**
     * @ORM\OneToMany(targetEntity=ValorRespuesta::class, mappedBy="pregunta", orphanRemoval=true)
     */
    private $valorRespuestas;

    /**
     * @ORM\ManyToOne(targetEntity=TipoPregunta::class, inversedBy="pregunta")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipoPregunta;

    /**
     * @ORM\ManyToOne(targetEntity=Section::class, inversedBy="preguntas")
     */
    private $section;

    public function __construct()
    {
        $this->valorRespuestas = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

        return $this;
    }

    public function getOrden(): ?int
    {
        return $this->orden;
    }

    public function setOrden(int $orden): self
    {
        $this->orden = $orden;

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

    public function getParametros(): ?string
    {
        return $this->parametros;
    }

    public function setParametros(?string $parametros): self
    {
        $this->parametros = $parametros;

        return $this;
    }

    public function getIsObligatoria(): ?bool
    {
        return $this->isObligatoria;
    }

    public function setIsObligatoria(?bool $isObligatoria): self
    {
        $this->isObligatoria = $isObligatoria;

        return $this;
    }

    public function getCuestionario(): ?Cuestionario
    {
        return $this->cuestionario;
    }

    public function setCuestionario(?Cuestionario $cuestionario): self
    {
        $this->cuestionario = $cuestionario;

        return $this;
    }

    /**
     * @return Collection|ValorRespuesta[]
     */
    public function getValorRespuestas(): Collection
    {
        return $this->valorRespuestas;
    }

    public function addValorRespuesta(ValorRespuesta $valorRespuesta): self
    {
        if (!$this->valorRespuestas->contains($valorRespuesta)) {
            $this->valorRespuestas[] = $valorRespuesta;
            $valorRespuesta->setPregunta($this);
        }

        return $this;
    }

    public function removeValorRespuesta(ValorRespuesta $valorRespuesta): self
    {
        if ($this->valorRespuestas->removeElement($valorRespuesta)) {
            // set the owning side to null (unless already changed)
            if ($valorRespuesta->getPregunta() === $this) {
                $valorRespuesta->setPregunta(null);
            }
        }

        return $this;
    }

    public function getTipoPregunta(): ?TipoPregunta
    {
        return $this->tipoPregunta;
    }

    public function setTipoPregunta(?TipoPregunta $tipoPregunta): self
    {
        $this->tipoPregunta = $tipoPregunta;

        return $this;
    }

    public function getSection(): ?Section
    {
        return $this->section;
    }

    public function setSection(?Section $section): self
    {
        $this->section = $section;

        return $this;
    }
}
