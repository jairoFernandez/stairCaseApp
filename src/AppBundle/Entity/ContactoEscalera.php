<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactoEscalera
 *
 * @ORM\Table(name="contacto_escalera")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactoEscaleraRepository")
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
     * @ORM\ManyToOne(targetEntity="EscaleraAspectos")
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
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;


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
}
