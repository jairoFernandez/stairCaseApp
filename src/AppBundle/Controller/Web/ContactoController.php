<?php

namespace AppBundle\Controller\Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use AppBundle\Entity\EscaleraAspectos;
use AppBundle\Entity\ContactoEscalera;
use AppBundle\Entity\Contacto;
use AppBundle\Form\ContactoType;
use AppBundle\Form\EscaleraAspectosType;

/**
 * Contacto controller.
 *
 * @Route("/admin/contacto")
 */
class ContactoController extends Controller
{

    /**
     * Lists all Contacto entities.
     *
     * @Route("/", name="admin_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $contactos = $em->getRepository('AppBundle:Contacto')->findByUsuario($this->getUser());
        
        return $this->render('web/contacto/index.html.twig', array(
            'contactos' => $contactos,
            ));
    }

    /**
     * Creates a new Contacto entity.
     *
     * @Route("/new", name="admin_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $contacto = new Contacto();
        $form = $this->createForm('AppBundle\Form\ContactoType', $contacto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $contacto->setUsuario($this->getUser());
            $em->persist($contacto);
            $em->flush();
            $this->get('utilidades')->MsgFlash("Creado correctamente.","info");

            return $this->redirectToRoute('admin_show', array('id' => $contacto->getId()));
        }

        return $this->render('web/contacto/new.html.twig', array(
            'contacto' => $contacto,
            'form' => $form->createView(),
            ));
    }

    /**
     * Finds and displays a Contacto entity.
     *
     * @Route("/{id}", name="admin_show")
     * @Method("GET")
     */
    public function showAction(Contacto $contacto)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();        
        $deleteForm = $this->createDeleteForm($contacto);
        $pasos = $em->getRepository('AppBundle:Escalera')->findAll();

        $usuarioContacto = $contacto->getUsuario();

        if($usuarioContacto->getId() != $user->getId()){
            $this->get('utilidades')->MsgFlash("Hmmmm este contacto no es tuyo.", "danger");
            return $this->redirectToRoute('admin_index');
        }

        $datos = $em->getRepository('AppBundle:ContactoEscalera')->findBy(array(
            'contacto' => $contacto->getId()
        ));
        dump($datos);

        return $this->render('web/contacto/show.html.twig', array(
            'contacto' => $contacto,
            'delete_form' => $deleteForm->createView(),
            'pasos' => $pasos,
            'datos' => $datos
            ));
    }

    /**
     * Displays a form to edit an existing Contacto entity.
     *
     * @Route("/{id}/edit", name="admin_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Contacto $contacto)
    {
        $deleteForm = $this->createDeleteForm($contacto);
        $editForm = $this->createForm('AppBundle\Form\ContactoType', $contacto);
        $editForm->handleRequest($request);
        $user = $this->getUser();        
        $usuarioContacto = $contacto->getUsuario();

        if($usuarioContacto->getId() != $user->getId()){
            $this->get('utilidades')->MsgFlash("Hmmmm este contacto no es tuyo, que estás tratando de hacer???.", "danger");
            return $this->redirectToRoute('admin_index');
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contacto);
            $em->flush();
            $this->get('utilidades')->MsgFlash("Actualización correcta.");
            return $this->redirectToRoute('admin_edit', array('id' => $contacto->getId()));
        }

        return $this->render('web/contacto/edit.html.twig', array(
            'contacto' => $contacto,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            ));
    }

    /**
     * Deletes a Contacto entity.
     *
     * @Route("/{id}", name="admin_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Contacto $contacto)
    {
        $form = $this->createDeleteForm($contacto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($contacto);
            $em->flush();
            $this->get('utilidades')->MsgFlash("Eliminado correctamente.","danger");
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * Creates a form to delete a Contacto entity.
     *
     * @param Contacto $contacto The Contacto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Contacto $contacto)
    {
        return $this->createFormBuilder()
        ->setAction($this->generateUrl('admin_delete', array('id' => $contacto->getId())))
        ->setMethod('DELETE')
        ->getForm()
        ;
    }

    /**
     * [AgregarDetalle description]
     * @Route("/agregarDetalle", name="agregar-detalle")
     * @Method("POST")
     */
    public function AgregarDetalle(Request $request)
    {
        $idAspecto = $request->request->get('idAspecto');
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
