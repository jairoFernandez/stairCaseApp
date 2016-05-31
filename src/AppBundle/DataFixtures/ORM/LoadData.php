<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Usuario;
use AppBundle\Entity\Contacto;

class LoadData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $manager->persist($user);
        
        for ($i=0; $i<10; $i++){
            $contacto = new Contacto();
            $contacto->setPrimerApellido('Apellido '.$i);
            $contacto->setPrimerNombre('Contacto '.$i);
            $contacto->setTelefono('317 6569802');
            $contacto->setUsuario($user);
            $manager->persist($contacto);
        }
        
        $manager->flush();

    }
}