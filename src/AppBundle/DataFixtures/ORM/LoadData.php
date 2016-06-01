<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\Usuario;
use AppBundle\Entity\Contacto;
use AppBundle\Entity\Escalera;
use AppBundle\Entity\EscaleraAspectos;
use AppBundle\Entity\ContactoEscalera;

class LoadData implements FixtureInterface, ContainerAwareInterface
{
     /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        
        $userManager = $this->container->get('fos_user.user_manager');

        // Create our user and set details
        $user = $userManager->createUser();
        $user->setUsername('jairog12');
        $user->setEmail('jairog12@outlook.com');
        $user->setPlainPassword('123456');
        //$user->setPassword('3NCRYPT3D-V3R51ON');
        $user->setEnabled(true);
        $user->setRoles(array('ROLE_USER'));

        // Update the user
        $userManager->updateUser($user, true);
       // $manager->persist($user);
        
        for ($i=0; $i<12; $i++){
            $contacto = new Contacto();
            $contacto->setPrimerApellido('Apellido '.$i);
            $contacto->setPrimerNombre('Contacto '.$i);
            $contacto->setTelefono('317 6569802');
            $contacto->setUsuario($user);
            $manager->persist($contacto);
        }
        
        $ganar = new Escalera();
        $ganar->setNombre('Ganar');
        $ganar->setDescripcion('Proceso inicial...');
        $ganar->setFecha(new \DateTime());

        $consolidar = new Escalera();
        $consolidar->setNombre('Consolidar');
        $consolidar->setDescripcion('Proceso inicial...');
        $consolidar->setFecha(new \DateTime());
        
        $discipular = new Escalera();
        $discipular->setNombre('Discipular');
        $discipular->setDescripcion('Proceso formación en capacitación destino...');
        $discipular->setFecha(new \DateTime());
        
        $enviar = new Escalera();
        $enviar->setNombre('Enviar');
        $enviar->setDescripcion('Abrir célula.');
        $enviar->setFecha(new \DateTime());
        
        $manager->persist($ganar);
        $manager->persist($consolidar);
        $manager->persist($discipular);
        $manager->persist($enviar);

        $ganarPaso1 = new EscaleraAspectos();
        $ganarPaso1->setNombre('Compartir la palabra');
        $ganarPaso1->setDescripcion('La primera vez que le compartiste.');
        $ganarPaso1->setPasoEscalera($ganar);
        $manager->persist($ganarPaso1);
        
        $ganarPaso2 = new EscaleraAspectos();
        $ganarPaso2->setNombre('Invitación a la iglesia.');
        $ganarPaso2->setDescripcion('Primera vez que fue a la iglesia.');
        $ganarPaso2->setPasoEscalera($ganar);
        $manager->persist($ganarPaso2);
                
        $consolidarPaso0 = new EscaleraAspectos();
        $consolidarPaso0->setNombre('Invitación a la célula.');
        $consolidarPaso0->setDescripcion('Primera vez que fue a célula.');
        $consolidarPaso0->setPasoEscalera($consolidar);
        $manager->persist($consolidarPaso0); 
        
        $consolidarPaso1 = new EscaleraAspectos();
        $consolidarPaso1->setNombre('PRE Encuentro.');
        $consolidarPaso1->setDescripcion('Su encuentro personal con Jesús.');
        $consolidarPaso1->setPasoEscalera($consolidar);
        $manager->persist($consolidarPaso1); 
        
        $consolidarPaso2 = new EscaleraAspectos();
        $consolidarPaso2->setNombre('Encuentro.');
        $consolidarPaso2->setDescripcion('Su encuentro personal con Jesús.');
        $consolidarPaso2->setPasoEscalera($consolidar);
        $manager->persist($consolidarPaso2); 
        
        $discipularPaso1 = new EscaleraAspectos();
        $discipularPaso1->setNombre('POS Encuentro.');
        $discipularPaso1->setDescripcion('Su encuentro personal con Jesús.');
        $discipularPaso1->setPasoEscalera($discipular);
        $manager->persist($discipularPaso1); 
        
        $discipularPaso2 = new EscaleraAspectos();
        $discipularPaso2->setNombre('Capacitación Destino Módulo 1.');
        $discipularPaso2->setDescripcion('Pastoreados en su amor y el Poder de una Visión.');
        $discipularPaso2->setPasoEscalera($discipular);
        $manager->persist($discipularPaso2); 

        $discipularPaso3 = new EscaleraAspectos();
        $discipularPaso3->setNombre('Capacitación Destino Módulo 2.');
        $discipularPaso3->setDescripcion('....');
        $discipularPaso3->setPasoEscalera($discipular);
        $manager->persist($discipularPaso3); 

        $discipularPaso4 = new EscaleraAspectos();
        $discipularPaso4->setNombre('Capacitación Destino Módulo 3.');
        $discipularPaso4->setDescripcion('....');
        $discipularPaso4->setPasoEscalera($discipular);
        $manager->persist($discipularPaso4); 
        
        $discipularPaso5 = new EscaleraAspectos();
        $discipularPaso5->setNombre('Capacitación Destino Módulo 4.');
        $discipularPaso5->setDescripcion('....');
        $discipularPaso5->setPasoEscalera($discipular);
        $manager->persist($discipularPaso5);
        
        $enviar1 = new EscaleraAspectos();
        $enviar1->setNombre('Abrir Célula.');
        $enviar1->setDescripcion('....');
        $enviar1->setPasoEscalera($enviar);
        $manager->persist($enviar1);
        
        $manager->flush();

    }
}