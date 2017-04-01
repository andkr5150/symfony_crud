<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Form\ArticleType;
use Doctrine\ORM\Mapping as ORM;
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
        $entry = $this->getDoctrine()->getRepository(Article::class);
        $entrys = $entry->findAll();

        return $this->render('form/index.html.twig', array('entrys' =>$entrys));
    }

    /**
     * @Route("/create", name="entry_create")
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
            $entry = $form->getData();
            $em->persist($entry);
            $em->flush();

            return $this->redirectToRoute('entry_index');
        }

        return $this->render('form/create.html.twig', array(
            'outform' => $form->createView(),
        ));
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
     * @Route("/edit/{id}" , name="entry_edit")
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Article::class)->find($id);

        return $this->render('form/edit.html.twig', array('user' =>$user));
    }

    /**
     * @Route("/update" , name="update_edit")
     */
    public function updateAction(Request $request)
    {
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(Article::class)->find($id);
        $user->setName($request->request->get('name'));
        $user->setDescription($request->request->get('description'));
        $d = \DateTime::createFromFormat('Y-m-d H:i:s',$request->request->get('created_at'));
        $user->setCreatedAt($d);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('entry_index');
    }

}
