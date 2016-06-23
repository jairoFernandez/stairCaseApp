<?php

namespace AppBundle\Controller\Web;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\Amistad;
use AppBundle\Entity\AmistadUsuario;

/**
 * Default controller.
 *
 * @Route("/admin")
 */
class DefaultController extends Controller
{

     /**
     * @Route("/", name="inicio-admin")
     */
     public function inicioAction()
     {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $detallesQuery = $em->createQuery('
            SELECT a,c,asp,u,p FROM AppBundle:ContactoEscalera a
            JOIN a.contacto c
            JOIN a.aspecto asp
            JOIN c.usuario u
            JOIN u.perfil p
            JOIN p.amistad am
            WHERE am.usuario = :usuarioId and am.estado = 1 AND p.publico = true
            ORDER BY a.fecha DESC
            ');
        $detallesQuery->setParameter('usuarioId', $user->getId());
        $detallesQuery->setMaxResults(50);
        $detalles = $detallesQuery->getResult();
        return $this->render('web/index.html.twig', [
            'detalles' => $detalles
            ]);
    }

    /**
     * @Route("/amigos", name="amigos")
     */
    public function amigosAction()
    {
        // replace this example code with whatever you need
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $perfil = $em->getRepository('AppBundle:Perfil')->findOneBy(array(
            'usuario' => $user->getId()
            ));

        if($perfil == null){
            $this->get('utilidades')->MsgFlash("Por favor completa tu perfil.","warning");
            return $this->redirectToRoute('admin_show', array('id' => $user->getId()));
        }

        $amigosQuery = $em->createQuery('
            SELECT am FROM AppBundle:Amistad am
            INNER JOIN am.solicitante s
            INNER JOIN am.amigo a
            WHERE s.id = :id
            ');
        $amigosQuery->setParameter('id',$perfil->getId());
        $amigos = $amigosQuery->getResult();

        $amigosPorAprobarQuery = $em->createQuery('
            SELECT am FROM AppBundle:Amistad am
            INNER JOIN am.solicitante s
            INNER JOIN am.amigo a
            WHERE a.id = :id AND am.estado = false
            ');
        $amigosPorAprobarQuery->setParameter('id',$perfil->getId());
        $amigosPorAprobar = $amigosPorAprobarQuery->getResult();


        return $this->render('web/amigos.html.twig', [
            'amigos' => $amigos,
            'amigosPorAprobar' => $amigosPorAprobar
            ]);
    }

    /**
     * @Route("/buscar-contactos/{nombres}", name="buscarContactos")
     * @Method("GET")
    */
    public function buscarContactosAction($nombres)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $perfil = $em->getRepository('AppBundle:Perfil')->findOneBy(array(
            'usuario' => $user->getId()
            ));

        $nombreBuscado = $nombres;
        
        $mensajePeticion = "";
        $codigo = "200";       
        
        $result = $em->createQuery('
            SELECT p FROM AppBundle:Perfil p  
            WHERE p.id <> :usuario 
            AND (
            p.primerNombre LIKE :nombres OR 
            p.segundoNombre LIKE :nombres OR
            p.primerApellido LIKE :nombres OR
            p.segundoApellido LIKE :nombres)
            
            ')
        ->setParameter('nombres', '%'.$nombreBuscado.'%')
        ->setParameter('usuario', $perfil->getId())
        ->getArrayResult();

        $response = new JsonResponse();
        
        $response->setData(array(
            'Resultados' => $result,
            'codigo'=> $codigo
            ));

        $response->setStatusCode($codigo);
        return $response;

    }

    /**
    * @Route("/agregar-amigos/{id}", name="agregar-amigos")
    * @Method("POST")
    */
    public function agregarContactosAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $amigo = new Amistad();
        $solicitante = $this->getUser();
        $miPerfil = $em->getRepository('AppBundle:Perfil')->findOneBy(array(
            'usuario'=>$solicitante->getId()
            ));
        $amigo = $em->getRepository('AppBundle:Perfil')->findOneById($id);

        $mensajePeticion = "";
        $codigo = "201";    

        $comprobarAmistad = $em->getRepository('AppBundle:Amistad')->findOneBy(array(
            'solicitante' => $solicitante->getId(),
            'amigo' => $miPerfil->getId()
            ));

        if($comprobarAmistad == null){
            $amistad = new Amistad();
            $amistad->setSolicitante($miPerfil);
            $amistad->setAmigo($amigo);
            $amistad->setEstado(false);
            $em->persist($amistad);

            $amistadUsuario = new AmistadUsuario();
            $amistadUsuario->setUsuario($solicitante);
            $amistadUsuario->setAmigo($amigo);
            $amistadUsuario->setEstado(false);
            $em->persist($amistadUsuario);

            $em->flush();


            $mensajePeticion = $amistad;
        }else{
            $mensajePeticion = "Ya tiene una solicitud con este amigo.";
            $codigo = "200";
        }

        $response = new JsonResponse();
        
        $response->setData(array(
            'Resultados' => $mensajePeticion,
            'codigo'=> $codigo
            ));

        $response->setStatusCode($codigo);
        return $response;

    }

    /**
     * [aprobarAmistad description]
    * @Route("/aprobar-amigos/{idSolicitante}", name="aprobar-amigos")
    * @Method("POST")
     * @param  [Perfil] $idSolicitante [description]
     * @return [type]                [description]
     */
    public function aprobarAmistad($idSolicitante)
    {
        $em = $this->getDoctrine()->getManager();

        $usuario = $this->getUser();
        $miPerfil = $em->getRepository('AppBundle:Perfil')->findOneBy(array(
            'usuario'=>$usuario->getId()
            ));
        // Busco la solicitud que me hicieron
        $solicitud = $em->getRepository('AppBundle:Amistad')->findOneBy(array(
            'solicitante' => $idSolicitante,
            'amigo' => $miPerfil->getId()
            ));
        // La seteo a true!!
        $solicitud->setEstado(true);
        $solicitud->setFechaAceptacion(new \DateTime());
        //Ahora busco el registro de Amistad usuario equivalente
        $usuarioSolicitante = $em->getRepository('AppBundle:Perfil')->findOneBy(array(
            'id' => $idSolicitante
        ));

        $idUsuario = $usuarioSolicitante->getUsuario()->getId();

        $amistadUsuario = $em->getRepository('AppBundle:AmistadUsuario')->findOneBy(array(
            'usuario' => $idUsuario,
            'amigo'   => $miPerfil->getId()
            ));
       
        //Lo seteo a true
        $amistadUsuario->setEstado(true);


        //Agrego este solicitante a mi lista de amistad usuario, primero lo busco 
        $amistadUsuarioAgregado = $em->getRepository('AppBundle:AmistadUsuario')->findOneBy(array(
            'usuario' => $usuario->getId(),
            'amigo'   => $idSolicitante
        ));

        //Busco la amistad desde mi punto de vista
        $solicitudMia = $em->getRepository('AppBundle:Amistad')->findOneBy(array(
            'solicitante' => $miPerfil->getId(),
            'amigo' => $idSolicitante
        ));

        if($solicitudMia == null){
            $solicitudMia2 = new Amistad();
            $solicitudMia2->setFechaAceptacion(new \DateTime());
            $solicitudMia2->setEstado(true);
            $solicitudMia2->setSolicitante($miPerfil);
            $solicitudMia2->setAmigo($usuarioSolicitante);
            $em->persist($solicitudMia2);
        }else{
            $solicitudMia->setEstado(true);
            $solicitudMia->setFechaAceptacion(new \DateTime());
        }

        if($amistadUsuarioAgregado == null){
            $amistadUsuarioAgregado2 = new AmistadUsuario();
            $amistadUsuarioAgregado2->setUsuario($usuario);
            $amistadUsuarioAgregado2->setAmigo($usuarioSolicitante);
            $amistadUsuarioAgregado2->setEstado(true);
            $em->persist($amistadUsuarioAgregado2);
        }else{
            $amistadUsuarioAgregado->setEstado(true);
        }      

        $em->flush();

        $response = new JsonResponse();
        
        $response->setData(array(
            'Resultados' => "Solicitud aprobada.",
            'codigo'=> 201
            ));

        $response->setStatusCode(201);

        return $response;
    }
}
