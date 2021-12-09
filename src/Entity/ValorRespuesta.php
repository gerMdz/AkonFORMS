<?php

namespace App\Entity;

use App\Repository\ValorRespuestaRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity(repositoryClass=ValorRespuestaRepository::class)
 */
class ValorRespuesta
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
     * @ORM\Column(type="string", length=4000)
     */
    private $respuesta;

    /**
     * @ORM\ManyToOne(targetEntity=Pregunta::class, inversedBy="valorRespuestas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pregunta;

    /**
     * @ORM\ManyToOne(targetEntity=Formulario::class, inversedBy="valorRespuestas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $formulario;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getRespuesta(): ?string
    {
        return $this->respuesta;
    }

    public function setRespuesta(string $respuesta): self
    {
        $this->respuesta = $respuesta;

        return $this;
    }

    public function getPregunta(): ?Pregunta
    {
        return $this->pregunta;
    }

    public function setPregunta(?Pregunta $pregunta): self
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    public function getFormulario(): ?Formulario
    {
        return $this->formulario;
    }

    public function setFormulario(?Formulario $formulario): self
    {
        $this->formulario = $formulario;

        return $this;
    }
}
