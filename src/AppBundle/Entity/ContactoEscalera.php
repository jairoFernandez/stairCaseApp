<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactoEscalera
 *
 * @ORM\Table(name="contacto_escalera")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactoEscaleraRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ContactoEscalera
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
     * @ORM\ManyToOne(targetEntity="EscaleraAspectos", inversedBy="contactosEscalera")
     */
    private $aspecto;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Contacto")
     */
    private $contacto;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEdicion", type="datetime", nullable=true)
     */
    private $fechaEdicion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaCreacion", type="datetime", nullable=true)
     */
    private $fechaCreacion;

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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return ContactoEscalera
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return ContactoEscalera
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
     * Set aspecto
     *
     * @param \AppBundle\Entity\EscaleraAspectos $aspecto
     *
     * @return ContactoEscalera
     */
    public function setAspecto(\AppBundle\Entity\EscaleraAspectos $aspecto = null)
    {
        $this->aspecto = $aspecto;

        return $this;
    }

    /**
     * Get aspecto
     *
     * @return \AppBundle\Entity\EscaleraAspectos
     */
    public function getAspecto()
    {
        return $this->aspecto;
    }

    /**
     * Set contacto
     *
     * @param \AppBundle\Entity\Contacto $contacto
     *
     * @return ContactoEscalera
     */
    public function setContacto(\AppBundle\Entity\Contacto $contacto = null)
    {
        $this->contacto = $contacto;

        return $this;
    }

    /**
     * Get contacto
     *
     * @return \AppBundle\Entity\Contacto
     */
    public function getContacto()
    {
        return $this->contacto;
    }

       /**
     * Set fechaEdicion
     *
     * @param \DateTime $fechaEdicion
     *
     * @return EscaleraAspectos
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
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return EscaleraAspectos
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
     * @ORM\PrePersist
     */
    public function setFechaActualiza()
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
}
