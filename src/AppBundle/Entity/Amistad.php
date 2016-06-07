<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Amistad
 *
 * @ORM\Table(name="amistad")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AmistadRepository")
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
     * @ORM\Column(name="solicitante", type="string", length=255)
     */
    private $solicitante;

    /**
     * @var string
     *
     * @ORM\Column(name="amigo", type="string", length=255)
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
     * Set solicitante
     *
     * @param string $solicitante
     *
     * @return Amistad
     */
    public function setSolicitante($solicitante)
    {
        $this->solicitante = $solicitante;

        return $this;
    }

    /**
     * Get solicitante
     *
     * @return string
     */
    public function getSolicitante()
    {
        return $this->solicitante;
    }

    /**
     * Set amigo
     *
     * @param string $amigo
     *
     * @return Amistad
     */
    public function setAmigo($amigo)
    {
        $this->amigo = $amigo;

        return $this;
    }

    /**
     * Get amigo
     *
     * @return string
     */
    public function getAmigo()
    {
        return $this->amigo;
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
}

