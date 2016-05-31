<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Models\Persona;
/**
 * Contacto
 *
 * @ORM\Table(name="contacto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContactoRepository")
 */
class Contacto extends Persona
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
     *
     * @var type string
     * @ORM\ManyToOne(targetEntity="Usuario")
     */
    private $usuario;

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
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return Contacto
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
    
    public function __toString()
    {
        return $this->getPrimerNombre()." ".$this->getPrimerApellido();
    }
}
