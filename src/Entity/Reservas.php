<?php

namespace App\Entity;

use App\Repository\ReservasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservasRepository::class)
 */
class Reservas
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hora;

    /**
     * @ORM\Column(type="integer")
     */
    private $nro_personas;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $primero;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $segundo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bebida;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $postre;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\ManyToOne(targetEntity=Restaurantes::class, inversedBy="reservas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurantes;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getHora(): ?string
    {
        return $this->hora;
    }

    public function setHora(string $hora): self
    {
        $this->hora = $hora;

        return $this;
    }

    public function getNroPersonas(): ?int
    {
        return $this->nro_personas;
    }

    public function setNroPersonas(int $nro_personas): self
    {
        $this->nro_personas = $nro_personas;

        return $this;
    }

    public function getPrimero(): ?string
    {
        return $this->primero;
    }

    public function setPrimero(string $primero): self
    {
        $this->primero = $primero;

        return $this;
    }

    public function getSegundo(): ?string
    {
        return $this->segundo;
    }

    public function setSegundo(string $segundo): self
    {
        $this->segundo = $segundo;

        return $this;
    }

    public function getBebida(): ?string
    {
        return $this->bebida;
    }

    public function setBebida(string $bebida): self
    {
        $this->bebida = $bebida;

        return $this;
    }

    public function getPostre(): ?string
    {
        return $this->postre;
    }

    public function setPostre(string $postre): self
    {
        $this->postre = $postre;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getRestaurantes(): ?Restaurantes
    {
        return $this->restaurantes;
    }

    public function setRestaurantes(?Restaurantes $restaurantes): self
    {
        $this->restaurantes = $restaurantes;

        return $this;
    }
}
