<?php

namespace App\Entity;

use App\Repository\InventariosRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InventariosRepository::class)
 */
class Inventarios
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    public function __toString()
    {
        return $this->nombre;        
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="float")
     */
    private $precio;

    /**
     * @ORM\Column(type="integer")
     */
    private $cantidad;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    /**
     * @ORM\OneToOne(targetEntity=Restaurantes::class, mappedBy="inventarios", cascade={"persist", "remove"})
     */
    private $restaurantes;

    public function getId(): ?int
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

    public function getPrecio(): ?float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getRestaurantes(): ?Restaurantes
    {
        return $this->restaurantes;
    }

    public function setRestaurantes(Restaurantes $restaurantes): self
    {
        // set the owning side of the relation if necessary
        if ($restaurantes->getInventarios() !== $this) {
            $restaurantes->setInventarios($this);
        }

        $this->restaurantes = $restaurantes;

        return $this;
    }
}
