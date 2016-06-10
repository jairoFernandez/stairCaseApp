<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Models\Persona;
/**
 * Perfil
 *
 * @ORM\Table(name="perfil")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PerfilRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Perfil extends Persona
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
     * @ORM\ManyToOne(targetEntity="Usuario")
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Perfil")
     */
    private $ministerio;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Perfil")
     */
    private $liderInmediato;

    /**
     * @var bool
     *
     * @ORM\Column(name="publico", type="boolean", nullable=true)
     */
    private $publico;

    /**
     * [$esLiderDoce description]
     * @var boolean
     * @ORM\Column(name="esLiderDoce", type="boolean", nullable=true)
     */
    private $esLiderDoce;

    /**
     * [$esLiderDoce description]
     * @var boolean
     * @ORM\Column(name="esLider", type="boolean", nullable=true)
     */
    private $esLider;


    /**
     * @var Array
     * @ORM\OneToMany(targetEntity="AmistadUsuario", mappedBy="amigo")
     */
    private $amistad;

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

    /**
     * Set esLiderDoce
     *
     * @param boolean $esLiderDoce
     *
     * @return Perfil
     */
    public function setEsLiderDoce($esLiderDoce)
    {
        $this->esLiderDoce = $esLiderDoce;

        return $this;
    }

    /**
     * Get esLiderDoce
     *
     * @return boolean
     */
    public function getEsLiderDoce()
    {
        return $this->esLiderDoce;
    }

    /**
     * Set esLider
     *
     * @param boolean $esLider
     *
     * @return Perfil
     */
    public function setEsLider($esLider)
    {
        $this->esLider = $esLider;

        return $this;
    }

    /**
     * Get esLider
     *
     * @return boolean
     */
    public function getEsLider()
    {
        return $this->esLider;
    }

    public function __toString()
    {
        return $this->getPrimerNombre()." ".$this->getPrimerApellido();
    }

    /**
     * Set ministerio
     *
     * @param \AppBundle\Entity\Perfil $ministerio
     *
     * @return Perfil
     */
    public function setMinisterio(\AppBundle\Entity\Perfil $ministerio = null)
    {
        $this->ministerio = $ministerio;

        return $this;
    }

    /**
     * Get ministerio
     *
     * @return \AppBundle\Entity\Perfil
     */
    public function getMinisterio()
    {
        return $this->ministerio;
    }

    /**
     * Set liderInmediato
     *
     * @param \AppBundle\Entity\Perfil $liderInmediato
     *
     * @return Perfil
     */
    public function setLiderInmediato(\AppBundle\Entity\Perfil $liderInmediato = null)
    {
        $this->liderInmediato = $liderInmediato;

        return $this;
    }

    /**
     * Get liderInmediato
     *
     * @return \AppBundle\Entity\Perfil
     */
    public function getLiderInmediato()
    {
        return $this->liderInmediato;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Perfil
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario
     */
    public function getUsuario()
    {
        return $this->usuario;
    }

  
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->amistad = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add amistad
     *
     * @param \AppBundle\Entity\AmistadUsuario $amistad
     *
     * @return Perfil
     */
    public function addAmistad(\AppBundle\Entity\AmistadUsuario $amistad)
    {
        $this->amistad[] = $amistad;

        return $this;
    }

    /**
     * Remove amistad
     *
     * @param \AppBundle\Entity\AmistadUsuario $amistad
     */
    public function removeAmistad(\AppBundle\Entity\AmistadUsuario $amistad)
    {
        $this->amistad->removeElement($amistad);
    }

    /**
     * Get amistad
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAmistad()
    {
        return $this->amistad;
    }
}
