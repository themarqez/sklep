<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Movie;
use AppBundle\Entity\Review;
use AppBundle\Form\MovieType;

/**
 * Movie controller.
 *
 * @Route("/movie")
 */
class MovieController extends Controller
{

    /**
     * Lists all Movie entities.
     *
     * @Route("/", name="movie")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Movie')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * @Route("/", name="review_add")
     * @Method("POST")
     */
    public function addReviewAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $movie = $em->getRepository('AppBundle:Movie')->findOneById($_POST['movie_id']);
        $entity = new Review();
        $entity->setOpinion($_POST['opinion']);
        $entity->setMovie($movie);
        
        $movie->addReview($entity);

        $em->persist($entity);
        $em->flush();

        return new Response("dodałem");
    }
    /**
     * @Route("/", name="purchase_add")
     * @Method("POST")
     */
    public function addPurchaseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $movie = $em->getRepository('AppBundle:Movie')->findOneById($_POST['movie_id']);
        $entity = new Purchase();
        $entity->setOpinion($_POST['address']);
        $entity->setMovie($movie);
        
        $movie->addReview($entity);

        $em->persist($entity);
        $em->flush();

        return new Response("dodałem");
    }
    /**
     * Creates a new Movie entity.
     *
     * @Route("/", name="movie_create")
     * @Method("POST")
     * @Template("AppBundle:Movie:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Movie();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('movie_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Movie entity.
     *
     * @param Movie $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Movie $entity)
    {
        $form = $this->createForm(new MovieType(), $entity, array(
            'action' => $this->generateUrl('movie_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Dodaj film!'));

        return $form;
    }

    /**
     * Displays a form to create a new Movie entity.
     *
     * @Route("/new", name="movie_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Movie();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Movie entity.
     *
     * @Route("/{id}", name="movie_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Movie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movie entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Movie entity.
     *
     * @Route("/{id}/edit", name="movie_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Movie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movie entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Movie entity.
    *
    * @param Movie $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Movie $entity)
    {
        $form = $this->createForm(new MovieType(), $entity, array(
            'action' => $this->generateUrl('movie_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Movie entity.
     *
     * @Route("/{id}", name="movie_update")
     * @Method("PUT")
     * @Template("AppBundle:Movie:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Movie')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Movie entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('movie_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Movie entity.
     *
     * @Route("/{id}", name="movie_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Movie')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Movie entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('movie'));
    }

    /**
     * Creates a form to delete a Movie entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('movie_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
