<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Models;

use Doctrine\ORM\Mapping\Column;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks()
 */
abstract class Persona {

    /**
     * @var string
     * @Column(type="string")
     */
    protected $primerNombre;

    /**
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $segundoNombre;

    /**
     * @var string
     * @Column(type="string")
     */
    protected $primerApellido;

    /**
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $segundoApellido;

    /**
     *
     * @var type string
     * @Column(type="string")
     */
    protected $telefono;

    public function getTelefono()
    {
        return $this->telefono;
    }

    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
        return $this;
    }

        /**
     * @var \DateTime
     * @Column(type="date", nullable=true)
     */
    protected $fechaNacimiento;
    
   /**
     * @var \DateTime
     * @Column(type="datetime", nullable=true)
     */
    protected $fechaEdicion;

    /**
     *
     * @var type \DateTime
     * @Column(type="datetime", nullable=true) 
     */
    protected $fechaCreacion;

    public function getFechaEdicion()
    {
        return $this->fechaEdicion;
    }

    public function setFechaEdicion(\DateTime $fechaEdicion)
    {
        $this->fechaEdicion = $fechaEdicion;
        return $this;
    }

        
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;
        return $this;
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
    
    public function getPrimerNombre()
    {
        return $this->primerNombre;
    }

    public function getSegundoNombre()
    {
        return $this->segundoNombre;
    }

    public function getPrimerApellido()
    {
        return $this->primerApellido;
    }

    public function getSegundoApellido()
    {
        return $this->segundoApellido;
    }

    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    public function setPrimerNombre($primerNombre)
    {
        $this->primerNombre = $primerNombre;
    }

    public function setSegundoNombre($segundoNombre)
    {
        $this->segundoNombre = $segundoNombre;
    }

    public function setPrimerApellido($primerApellido)
    {
        $this->primerApellido = $primerApellido;
    }

    public function setSegundoApellido($segundoApellido)
    {
        $this->segundoApellido = $segundoApellido;
    }

    public function setFechaNacimiento(\DateTime $fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;
    }

}
