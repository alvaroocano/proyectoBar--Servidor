<?php

namespace App\Entity;

use App\Repository\RestaurantesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestaurantesRepository::class)
 */
class Restaurantes
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
    private $localidad;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $horario;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telefono;

    /**
     * @ORM\Column(type="integer")
     */
    private $aforo;

    /**
     * @ORM\OneToMany(targetEntity=Reservas::class, mappedBy="restaurantes", orphanRemoval=true)
     */
    private $reservas;

    /**
     * @ORM\OneToOne(targetEntity=Inventarios::class, inversedBy="restaurantes", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $inventarios;

    public function __construct()
    {
        $this->reservas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocalidad(): ?string
    {
        return $this->localidad;
    }

    public function setLocalidad(string $localidad): self
    {
        $this->localidad = $localidad;

        return $this;
    }

    public function getHorario(): ?string
    {
        return $this->horario;
    }

    public function setHorario(string $horario): self
    {
        $this->horario = $horario;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    public function getAforo(): ?int
    {
        return $this->aforo;
    }

    public function setAforo(int $aforo): self
    {
        $this->aforo = $aforo;

        return $this;
    }

    /**
     * @return Collection<int, Reservas>
     */
    public function getReservas(): Collection
    {
        return $this->reservas;
    }

    public function addReserva(Reservas $reserva): self
    {
        if (!$this->reservas->contains($reserva)) {
            $this->reservas[] = $reserva;
            $reserva->setRestaurantes($this);
        }

        return $this;
    }

    public function removeReserva(Reservas $reserva): self
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getRestaurantes() === $this) {
                $reserva->setRestaurantes(null);
            }
        }

        return $this;
    }

    public function getInventarios(): ?Inventarios
    {
        return $this->inventarios;
    }

    public function setInventarios(Inventarios $inventarios): self
    {
        $this->inventarios = $inventarios;

        return $this;
    }
}
