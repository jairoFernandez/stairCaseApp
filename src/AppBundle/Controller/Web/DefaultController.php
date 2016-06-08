<?php

namespace AppBundle\Controller\Web;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;

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

        return $this->render('web/index.html.twig', [

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
}
