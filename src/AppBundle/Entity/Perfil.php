<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Perfil
 *
 * @ORM\Table(name="perfil")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PerfilRepository")
 */
class Perfil
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
     * @ORM\Column(name="usuario", type="string", length=255)
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\Column(name="ministerio", type="string", length=255)
     */
    private $ministerio;

    /**
     * @var string
     *
     * @ORM\Column(name="liderInmediato", type="string", length=255)
     */
    private $liderInmediato;

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
     * @var bool
     *
     * @ORM\Column(name="publico", type="boolean")
     */
    private $publico;


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
     * Set usuario
     *
     * @param string $usuario
     *
     * @return Perfil
     */
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return string
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Set ministerio
     *
     * @param string $ministerio
     *
     * @return Perfil
     */
    public function setMinisterio($ministerio)
    {
        $this->ministerio = $ministerio;

        return $this;
    }

    /**
     * Get ministerio
     *
     * @return string
     */
    public function getMinisterio()
    {
        return $this->ministerio;
    }

    /**
     * Set liderInmediato
     *
     * @param string $liderInmediato
     *
     * @return Perfil
     */
    public function setLiderInmediato($liderInmediato)
    {
        $this->liderInmediato = $liderInmediato;

        return $this;
    }

    /**
     * Get liderInmediato
     *
     * @return string
     */
    public function getLiderInmediato()
    {
        return $this->liderInmediato;
    }

    /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Perfil
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
     * @return Perfil
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
     * Set publico
     *
     * @param boolean $publico
     *
     * @return Perfil
     */
    public function setPublico($publico)
    {
        $this->publico = $publico;

        return $this;
    }

    /**
     * Get publico
     *
     * @return bool
     */
    public function getPublico()
    {
        return $this->publico;
    }
}

