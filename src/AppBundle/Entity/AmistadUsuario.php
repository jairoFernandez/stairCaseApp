<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AmistadUsuario
 *
 * @ORM\Table(name="amistad_usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AmistadUsuarioRepository")
 */
class AmistadUsuario
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
     * @ORM\ManyToOne(targetEntity="Usuario", inversedBy="amistad")
     */
    private $usuario;

    /**
     * @var string
     *
     * @ORM\ManyToOne(targetEntity="Perfil", inversedBy="amistad")
     */
    private $amigo;

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
     * Get estado
     *
     * @return bool
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Set estado
     *
     * @param boolean $estado
     *
     * @return AmistadUsuario
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     *
     * @return AmistadUsuario
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
     * Set amigo
     *
     * @param \AppBundle\Entity\Perfil $amigo
     *
     * @return AmistadUsuario
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
}
