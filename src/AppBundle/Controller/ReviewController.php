<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Review;

/**
 * Review controller.
 *
 * @Route("/review")
 */
class ReviewController extends Controller
{

    /**
     * Lists all Review entities.
     *
     * @Route("/", name="review")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Review')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Review entity.
     *
     * @Route("/{id}", name="review_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Review')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Review entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
