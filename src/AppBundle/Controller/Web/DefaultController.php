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
            WHERE am.usuario = :usuarioId and am.estado = 1
            ');
        $detallesQuery->setParameter('usuarioId', $user->getId());
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
            WHERE s.id = :id OR a.id = :id
            ');
        $amigosQuery->setParameter('id',$perfil->getId());
        $amigos = $amigosQuery->getResult();
        return $this->render('web/amigos.html.twig', [
            'amigos' => $amigos
            ]);
    }

    /**
     * @Route("/buscar-contactos/{nombres}", name="buscarContactos")
     * @Method("GET")
    */
    public function buscarContactosAction($nombres)
    {
        $nombreBuscado = $nombres;
        
        $mensajePeticion = "";
        $codigo = "200";       

        $em = $this->getDoctrine()->getManager();
        
        $result = $em->getRepository("AppBundle:Perfil")->createQueryBuilder('p')
        ->where('p.primerNombre LIKE :nombres')
        ->orWhere('p.segundoNombre LIKE :nombres')
        ->orWhere('p.primerApellido LIKE :nombres')
        ->orWhere('p.segundoApellido LIKE :nombres')
        ->setParameter('nombres', '%'.$nombreBuscado.'%')
        ->getQuery()
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
}
