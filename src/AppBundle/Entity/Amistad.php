<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Amistad
 *
 * @ORM\Table(name="amistad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AmistadRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Amistad
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
     * @ORM\ManyToOne(targetEntity="Perfil")
     */
    private $solicitante;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Perfil")
     */
    private $amigo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaSolicitud", type="datetime")
     */
    private $fechaSolicitud;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaAceptacion", type="datetime", nullable=true)
     */
    private $fechaAceptacion;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;


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
     * Set fechaSolicitud
     *
     * @param \DateTime $fechaSolicitud
     *
     * @return Amistad
     */
    public function setFechaSolicitud($fechaSolicitud)
    {
        $this->fechaSolicitud = $fechaSolicitud;

        return $this;
    }

    /**
     * Get fechaSolicitud
     *
     * @return \DateTime
     */
    public function getFechaSolicitud()
    {
        return $this->fechaSolicitud;
    }

    /**
     * Set fechaAceptacion
     *
     * @param \DateTime $fechaAceptacion
     *
     * @return Amistad
     */
    public function setFechaAceptacion($fechaAceptacion)
    {
        $this->fechaAceptacion = $fechaAceptacion;

        return $this;
    }

    /**
     * Get fechaAceptacion
     *
     * @return \DateTime
     */
    public function getFechaAceptacion()
    {
        return $this->fechaAceptacion;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return Amistad
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return bool
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * @ORM\PrePersist
     */
    public function setFechaActualiza()
    {
        $this->setFechaSolicitud(new \DateTime()); 
        $this->setEstado(false);
    }

    /**
     * Set solicitante
     *
     * @param \AppBundle\Entity\Perfil $solicitante
     *
     * @return Amistad
     */
    public function setSolicitante(\AppBundle\Entity\Perfil $solicitante = null)
    {
        $this->solicitante = $solicitante;

        return $this;
    }

    /**
     * Get solicitante
     *
     * @return \AppBundle\Entity\Perfil
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * Set amigo
     *
     * @param \AppBundle\Entity\Perfil $amigo
     *
     * @return Amistad
     */
    public function setAmigo(\AppBundle\Entity\Perfil $amigo = null)
    {
        $this->amigo = $amigo;

        return $this;
    }

    /**
     * Get amigo
     *
     * @return \AppBundle\Entity\Perfil
     */
    public function getAmigo()
    {
        return $this->amigo;
    }

    public function __toString()
    {
        return $this->getAmigo()->getPrimerNombre()." ".$this->getAmigo()->getPrimerNombre();
    }
}
