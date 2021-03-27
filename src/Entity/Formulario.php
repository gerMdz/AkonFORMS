<?php

namespace App\Entity;

use App\Repository\FormularioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\UuidInterface;
use Ramsey\Uuid\Doctrine\UuidGenerator;

/**
 * @ORM\Entity(repositoryClass=FormularioRepository::class)
 */
class Formulario
{
    use TimestampableEntity;
    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidGenerator::class)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cuestionario::class, inversedBy="formularios")
     */
    private $cuestionario;

    /**
     * @ORM\OneToMany(targetEntity=ValorRespuesta::class, mappedBy="formulario")
     */
    private $valorRespuestas;

    public function __construct()
    {
        $this->valorRespuestas = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
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
            $valorRespuesta->setFormulario($this);
        }

        return $this;
    }

    public function removeValorRespuesta(ValorRespuesta $valorRespuesta): self
    {
        if ($this->valorRespuestas->removeElement($valorRespuesta)) {
            // set the owning side to null (unless already changed)
            if ($valorRespuesta->getFormulario() === $this) {
                $valorRespuesta->setFormulario(null);
            }
        }

        return $this;
    }
}
