<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Tag;
use App\Form\PostType;


use App\Form\Type\TagsInputType;
use App\Repository\TagRepository;

use App\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use Symfony\Component\HttpFoundation\JsonResponse;

use App\Form\TagType;

class TagController extends Controller
{
    /**
     * @Route("/tag", name="tag")
     */
    public function index(TagRepository $tags)
    {
        $latestTags = $tags->findAll();
        return $this->render('tag/index.html.twig', ['tags' => $latestTags]);

    }


    /**
     * Creates a new Tag entity.
     *
     * @Route("/new", name="tag_new")
     * @Method({"GET", "POST"})
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function new(Request $request)
    {

      $tag = new Tag();
      $form = $this->createForm(TagType::class, $tag);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($tag);
          $em->flush();
          return $this->redirectToRoute('tag');
      }
        return $this->render('tag/new.html.twig', array(
          'tag' => $tag,
          'form' => $form->createView(),
      ));

    }

    /**
     * Displays a form to edit an existing Post entity.
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="tag_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Tag $tag)
    {
        $editForm = $this->createForm(TagType::class, $tag);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('tag');
        }
        return $this->render('tag/edit.html.twig', array(
            'demandante' => $tag,
            'edit_form' => $editForm->createView(),
            
        ));



    }










}
