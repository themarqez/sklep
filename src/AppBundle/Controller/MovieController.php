<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Movie;

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

        return array(
            'entity'      => $entity,
        );
    }
}
