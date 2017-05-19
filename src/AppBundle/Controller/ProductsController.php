<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Products;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Product controller.
 *
 * @Route("/")
 */
class ProductsController extends Controller
{
    /**
     * Lists all product entities.
     *
     * @Route("/", name="_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $products = $em->getRepository('AppBundle:Products')->findAll();

        return $this->render('products/index.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * Creates a new product entity.
     *
     * @Route("/new", name="_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

            $product = new Products();
            $product->setName("test");
            $product->setQuantity(2);
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();
            $response = new JsonResponse();
            $response->setData(array('status' => "ok"));
            return $response;
    }

    /**
     * Finds and displays a product entity.
     *
     * @Route("/{id}", name="_show")
     * @Method("GET")
     */
    public function showAction(Products $product)
    {
        $deleteForm = $this->createDeleteForm($product);

        return $this->render('products/show.html.twig', array(
            'product' => $product,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing product entity.
     *
     * @Route("/{id}/edit", name="_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Products $product)
    {
        $deleteForm = $this->createDeleteForm($product);
        $editForm = $this->createForm('AppBundle\Form\ProductsType', $product);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('_edit', array('id' => $product->getId()));
        }

        return $this->render('products/edit.html.twig', array(
            'product' => $product,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a product entity.
     *
     * @Route("/{id}", name="_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Products $product)
    {
        $form = $this->createDeleteForm($product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
        }

        return $this->redirectToRoute('_index');
    }

    /**
     * Creates a form to delete a product entity.
     *
     * @param Products $product The product entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Products $product)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('_delete', array('id' => $product->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
