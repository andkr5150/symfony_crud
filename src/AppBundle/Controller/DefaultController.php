<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/", name="entry_index")
     */
    public function indexAction()
    {
        $entry = $this->getDoctrine()->getRepository(Entity::class);
        $entrys = $entry->findAll();

        return $this->render('form/index.html.twig', array('entrys' =>$entrys));
    }

    /**
     * @Route("/create", name="entry_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction($request)
    {
        $entry = new Entity();
        $form = $this->createForm(Entity::class, $entry);
        $form->handleRequest($request);

        if ($form->isValid()){
            $entry = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($entry);
            $em->flush();
            return $this->redirectToRoute('form/edit.html.twig'.$entry->getId());
        }
        return $this->render('form/create.html.twig');
    }

    /**
     * @Route("/delete/{id}", name="entry_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Entity::class)->find($id);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('form/index.html.twig');
    }

    /**
     * @Route("/edit" , name="entry_edit")
     */
    public function editAction()
    {
        return $this->render('form/edit.html.twig');
    }

}
