<?php

namespace App\Entity;

use App\Repository\MinistryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Hashids\Hashids;


/**
 * @ORM\Entity(repositoryClass=MinistryRepository::class)
 */
class Ministry
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=36)
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="ministry")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Cuestionario::class, mappedBy="ministry")
     */
    private $cuestionario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=12)
     */
    private $hashkey;

    /**
     * @ORM\Column(type="string", length=25)
     */
    private $identificador;

    public function __construct()
    {
        $hashids = new Hashids($this->identificador, 12);
        $this->hashkey = $hashids->encode(1, 2, 3);
        $this->user = new ArrayCollection();
        $this->cuestionario = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return Collection|User[]
     */
    public function getUser(): Collection
    {
        return $this->user;
    }

    public function addUser(User $user): self
    {
        if (!$this->user->contains($user)) {
            $this->user[] = $user;
            $user->setMinistry($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->user->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getMinistry() === $this) {
                $user->setMinistry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cuestionario[]
     */
    public function getCuestionario(): Collection
    {
        return $this->cuestionario;
    }

    public function addCuestionario(Cuestionario $cuestionario): self
    {
        if (!$this->cuestionario->contains($cuestionario)) {
            $this->cuestionario[] = $cuestionario;
            $cuestionario->setMinistry($this);
        }

        return $this;
    }

    public function removeCuestionario(Cuestionario $cuestionario): self
    {
        if ($this->cuestionario->removeElement($cuestionario)) {
            // set the owning side to null (unless already changed)
            if ($cuestionario->getMinistry() === $this) {
                $cuestionario->setMinistry(null);
            }
        }

        return $this;
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

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getHashkey(): ?string
    {
        return $this->hashkey;
    }

    public function setHashkey(string $hashkey): self
    {
        $this->hashkey = $hashkey;

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
}
