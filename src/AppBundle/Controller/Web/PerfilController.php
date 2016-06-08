<?php

namespace AppBundle\Controller\Web;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Perfil;
use AppBundle\Form\PerfilType;

/**
 * Perfil controller.
 *
 * @Route("/admin/perfil-propio")
 */
class PerfilController extends Controller
{
    /**
     * Lists all Perfil entities.
     *
     * @Route("/", name="admin_profile_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        
        $perfil = $em->getRepository('AppBundle:Perfil')->findOneBy(array(
            'usuario' => $user->getId()
        ));

        if($perfil == null){
            return $this->redirectToRoute('admin_profile_new');

        }

        return $this->render('web/perfil/show.html.twig', array(
            'perfil' => $perfil,
        ));
    }

    /**
     * Creates a new Perfil entity.
     *
     * @Route("/new", name="admin_profile_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        $perfil = new Perfil();
        $form = $this->createForm('AppBundle\Form\PerfilType', $perfil);
        $form->handleRequest($request);
        $perfil->setUsuario($user);

        $perfilBuscado = $em->getRepository('AppBundle:Perfil')->findOneBy(array(
            'usuario' => $user->getId()
        ));

        if($perfilBuscado != null){
            return $this->redirectToRoute('admin_profile_show',
                 array('id' => $perfilBuscado->getId()));
        }


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($perfil);
            $em->flush();
            $this->get('utilidades')->MsgFlash("Creado correctamente.","info");

            return $this->redirectToRoute('admin_profile_show', array('id' => $perfil->getId()));
        }

        return $this->render('web/perfil/new.html.twig', array(
            'perfil' => $perfil,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Perfil entity.
     *
     * @Route("/{id}", name="admin_profile_show")
     * @Method("GET")
     */
    public function showAction(Perfil $perfil)
    {
        $deleteForm = $this->createDeleteForm($perfil);

        return $this->render('web/perfil/show.html.twig', array(
            'perfil' => $perfil,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Perfil entity.
     *
     * @Route("/{id}/edit", name="admin_profile_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Perfil $perfil)
    {
        $deleteForm = $this->createDeleteForm($perfil);
        $editForm = $this->createForm('AppBundle\Form\PerfilType', $perfil);
        $editForm->handleRequest($request);

        $user = $this->getUser();

        if($perfil->getUsuario() != $user){
            $this->get('utilidades')->MsgFlash("No sé que estás tratando de hacer...","danger");
            return $this->redirectToRoute('admin_profile_index');
        }

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($perfil);
            $em->flush();
            $this->get('utilidades')->MsgFlash("Editado correctamente.","info");

            return $this->redirectToRoute('admin_profile_edit', array('id' => $perfil->getId()));
        }

        return $this->render('web/perfil/edit.html.twig', array(
            'perfil' => $perfil,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Perfil entity.
     *
     * @Route("/{id}", name="admin_profile_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Perfil $perfil)
    {
        $form = $this->createDeleteForm($perfil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($perfil);
            $em->flush();
        }

        return $this->redirectToRoute('admin_profile_index');
    }

    /**
     * Creates a form to delete a Perfil entity.
     *
     * @param Perfil $perfil The Perfil entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Perfil $perfil)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_profile_delete', array('id' => $perfil->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
