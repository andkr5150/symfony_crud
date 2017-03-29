<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Article;
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
        $entry = new Article();
        $entry = $this->getDoctrine()->getRepository(Article::class);
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
        $entry = new Article();
        $form = $this->createForm(Article::class, $entry);

        $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entry);
                $em->flush();

                return $this->redirect($this->generateUrl('Create_entry'));
            }

        return $this->render('form/create.html.twig');
    }

    /**
     * @Route("/delete/{id}", name="entry_delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Article::class)->find($id);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('entry_index');
    }

    /**
     * @Route("/edit" , name="entry_edit")
     */
    public function editAction()
    {

        return $this->render('form/edit.html.twig');
    }

}
