<?php

namespace App\Controller;

use App\Entity\Stage;
use App\Form\Stage1Type;
use App\Repository\StageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/stage")
 */
class StageController extends AbstractController
{
    /**
     * @Route("/", name="stage_index", methods="GET")
     */
    public function index(StageRepository $stageRepository): Response
    {
        return $this->render('stage/index.html.twig', ['stages' => $stageRepository->findAll()]);
    }

    /**
     * @Route("/new", name="stage_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $stage = new Stage();
        $form = $this->createForm(Stage1Type::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($stage);
            $em->flush();

            return $this->redirectToRoute('stage_index');
        }

        return $this->render('stage/new.html.twig', [
            'stage' => $stage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stage_show", methods="GET")
     */
    public function show(Stage $stage): Response
    {
        return $this->render('stage/show.html.twig', ['stage' => $stage]);
    }

    /**
     * @Route("/{id}/edit", name="stage_edit", methods="GET|POST")
     */
    public function edit(Request $request, Stage $stage): Response
    {
        $form = $this->createForm(Stage1Type::class, $stage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('stage_index', ['id' => $stage->getId()]);
        }

        return $this->render('stage/edit.html.twig', [
            'stage' => $stage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="stage_delete", methods="DELETE")
     */
    public function delete(Request $request, Stage $stage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stage->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($stage);
            $em->flush();
        }

        return $this->redirectToRoute('stage_index');
    }
}
