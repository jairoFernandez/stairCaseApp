<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\Models;
use Doctrine\ORM\Mapping\Column; 
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @MappedSuperclass
 */
abstract class Persona
{
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
    protected $aprimerApellido;
    
    /**
     * @var string
     * @Column(type="string", nullable=true)
     */
    protected $segundoApellido;

    /**
     * @var \DateTime
     * @Column(type="datetime", nullable=true)
     */
    protected $fechaNacimiento;
    
    public function getPrimerNombre()
    {
        return $this->primerNombre;
    }

    public function getSegundoNombre()
    {
        return $this->segundoNombre;
    }

    public function getAprimerApellido()
    {
        return $this->aprimerApellido;
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

    public function setAprimerApellido($aprimerApellido)
    {
        $this->aprimerApellido = $aprimerApellido;
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
