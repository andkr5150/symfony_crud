<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Doctrine\ORM\Mapping as ORM;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="admin")
     */
    public function adminAction()
    {
        return $this->render('form/admin.html.twig');
    }

    /**
     * @Route("/", name="_security_check")
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function security_checkAction(Request $request)
    {
        if ($this->get($request)->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $this->get($request)->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $this->get($request)->getSession()->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('form/admin.html.twig', array(
            'last_username' => $this->get($request)->getSession()->get(SecurityContext::LAST_USERNAME),
            'error' => $error
        ));
    }


    /**
     * @Route("/admin", name="entry_index")
     */
    public function indexAction()
    {
        $entry = $this->getDoctrine()->getRepository(Article::class);
        $entrys = $entry->findAll();

        return $this->render('form/index.html.twig', array('entrys' =>$entrys));
    }

    /**
     * @Route("admin/create", name="entry_create")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $entry = new Article();
        $entry->setCreatedAt(new \DateTime('tomorrow'));
        $form = $this->createForm(ArticleType::class ,$entry);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entry);
            $em->flush();

            return $this->redirectToRoute('entry_index');
        }

        return $this->render('form/create.html.twig', array(
            'outform' => $form->createView(),
        ));
    }

    /**
     * @Route("admin/delete/{id}", name="entry_delete")
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
     * @Route("admin/edit/{id}" , name="entry_edit")
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');
        $user = $em->getRepository(Article::class)->find($id);
        $editform = $this->createForm(ArticleType::class, $user);
        $editform->handleRequest($request);

        if ($editform->isValid()) {
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('entry_index');
        }

        return $this->render('form/edit.html.twig', array(
            'edit_form' => $editform->createView(),
        ));
    }
}
