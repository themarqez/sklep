<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Purchase;

/**
 * Purchase controller.
 *
 * @Route("/purchase")
 */
class PurchaseController extends Controller
{

    /**
     * Lists all Purchase entities.
     *
     * @Route("/", name="purchase")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Purchase')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Purchase entity.
     *
     * @Route("/{id}", name="purchase_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Purchase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }

        return array(
            'entity'      => $entity,
        );
    }
}
