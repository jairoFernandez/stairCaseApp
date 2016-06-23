<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Escalera
 *
 * @ORM\Table(name="escalera")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EscaleraRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Escalera
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime")
     */
    private $fechaCreacion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEdicion", type="datetime")
     */
    private $fechaEdicion;

    /**
     * [$color description]
     * @var [type]
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * [$color description]
     * @var [type]
     * @ORM\Column(name="icono", type="string", length=255, nullable=true)
     */
    private $icono;

    /**
     * [$aspectos description]
     * @var Array
     * @ORM\OneToMany(targetEntity="EscaleraAspectos", mappedBy="pasoEscalera")
     */
    private $aspectos;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return Escalera
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return Escalera
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Escalera
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    /**
     * Set fechaEdicion
     *
     * @param \DateTime $fechaEdicion
     *
     * @return Escalera
     */
    public function setFechaEdicion($fechaEdicion)
    {
        $this->fechaEdicion = $fechaEdicion;

        return $this;
    }

    /**
     * Get fechaEdicion
     *
     * @return \DateTime
     */
    public function getFechaEdicion()
    {
        return $this->fechaEdicion;
    }
    
      /**
     * @ORM\PrePersist
     */
    public function setFecha()
    {
        $this->setFechaCreacion(new \DateTime());        
        $this->setFechaEdicion(new \DateTime());
    }

    /**
     * @ORM\PreUpdate
     */
    public function setFechaActualizacion()
    {      
        $this->setFechaEdicion(new \DateTime());
    }
    
    public function __toString()
    {
        return $this->getNombre();;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->aspectos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add aspecto
     *
     * @param \AppBundle\Entity\EscaleraAspectos $aspecto
     *
     * @return Escalera
     */
    public function addAspecto(\AppBundle\Entity\EscaleraAspectos $aspecto)
    {
        $this->aspectos[] = $aspecto;

        return $this;
    }

    /**
     * Remove aspecto
     *
     * @param \AppBundle\Entity\EscaleraAspectos $aspecto
     */
    public function removeAspecto(\AppBundle\Entity\EscaleraAspectos $aspecto)
    {
        $this->aspectos->removeElement($aspecto);
    }

    /**
     * Get aspectos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAspectos()
    {
        return $this->aspectos;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Escalera
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set icono
     *
     * @param string $icono
     *
     * @return Escalera
     */
    public function setIcono($icono)
    {
        $this->icono = $icono;

        return $this;
    }

    /**
     * Get icono
     *
     * @return string
     */
    public function getIcono()
    {
        return $this->icono;
    }
}
