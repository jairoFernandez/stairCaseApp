<?php

namespace AppBundle\Controller\Web;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * [AgregarDetalle description]
     * @Route("/buscar", name="buscarContactos")
     * @Method("POST")
     */
    public function AgregarDetalle(Request $request)
    {
        $nombres = $request->request->get('idAspecto');
        $idContacto = $request->request->get('idContacto');
        $descripcion = $request->request->get('descripcion');
        $fechaRecibida = $request->request->get('fecha');
        $fecha = date_create_from_format('Y-m-d', $fechaRecibida);
        $mensajePeticion = "";
        $codigo = "201";       

        $em = $this->getDoctrine()->getManager();
        $contacto = $em->getRepository('AppBundle:Contacto')->findOneBy(array(
            'id' => $idContacto,
            'usuario' => $this->getUser()->getId()
            ));

        $aspecto = $em->getRepository('AppBundle:EscaleraAspectos')->findOneBy(array(
            'id'=>$idAspecto
            ));

        $contactoEscalera = new ContactoEscalera();         
       
        if($contacto == null || $contacto == ""){
            $mensajePeticion = "Este contacto no le pertenece. ";
            $codigo = "500";
        }else{   
            $contactoEscalera->setAspecto($aspecto);
            $contactoEscalera->setContacto($contacto);
            $contactoEscalera->setFecha($fecha);
            $contactoEscalera->setDescripcion($descripcion);
           
            $em->persist($contactoEscalera);
            $em->flush();
        }

        $response = new JsonResponse();

        $response->setData(array(
            'DetalleAgregado' => "Asignación correcta. ",
            'codigo'=> $codigo
            ));

        $response->setStatusCode($codigo);
        return $response;

    }
}
