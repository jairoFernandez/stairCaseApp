<?php

namespace AppBundle\Controller\Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Contacto;
use AppBundle\Form\ContactoType;

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

        $contactos = $em->getRepository('AppBundle:Contacto')->findAll();

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
            $em->persist($contacto);
            $em->flush();
            $this->MsgFlash("Creado correctamente.","info");
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
        $deleteForm = $this->createDeleteForm($contacto);

        return $this->render('web/contacto/show.html.twig', array(
            'contacto' => $contacto,
            'delete_form' => $deleteForm->createView(),
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

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contacto);
            $em->flush();
            $this->MsgFlash("Actualización correcta.");
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
            $this->MsgFlash("Eliminado correctamente.","danger");
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
    
    private function MsgFlash($mensaje = "Acción Realizada correctamente.", $tipoAlerta = 'success', $tituloAlerta = 'Mensaje: ')
    {
        $this->get('session')->getFlashBag()->add(
                'notice',
                array(
                    'alert' => $tipoAlerta,
                    'title' => $tituloAlerta,
                    'message' => $mensaje
                )
            );
    }
}
