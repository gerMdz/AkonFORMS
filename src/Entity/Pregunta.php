<?php

namespace App\Entity;

use App\Repository\PreguntaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PreguntaRepository::class)
 */
class Pregunta
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

    public function getId(): ?int
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
}
