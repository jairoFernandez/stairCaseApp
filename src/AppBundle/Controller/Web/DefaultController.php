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

        return $this->render('web/amigos.html.twig', [

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
