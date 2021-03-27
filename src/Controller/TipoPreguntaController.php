<?php

namespace App\Controller;

use App\Entity\TipoPregunta;
use App\Form\TipoPreguntaType;
use App\Repository\TipoPreguntaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tipopregunta")
 */
class TipoPreguntaController extends AbstractController
{
    /**
     * @Route("/", name="tipo_pregunta_index", methods={"GET"})
     * @param TipoPreguntaRepository $tipoPreguntaRepository
     * @return Response
     */
    public function index(TipoPreguntaRepository $tipoPreguntaRepository): Response
    {
        return $this->render('tipo_pregunta/index.html.twig', [
            'tipo_preguntas' => $tipoPreguntaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tipo_pregunta_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $tipoPreguntum = new TipoPregunta();
        $form = $this->createForm(TipoPreguntaType::class, $tipoPreguntum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tipoPreguntum);
            $entityManager->flush();

            return $this->redirectToRoute('tipo_pregunta_index');
        }

        return $this->render('tipo_pregunta/new.html.twig', [
            'tipo_preguntum' => $tipoPreguntum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_pregunta_show", methods={"GET"})
     * @param TipoPregunta $tipoPreguntum
     * @return Response
     */
    public function show(TipoPregunta $tipoPreguntum): Response
    {
        return $this->render('tipo_pregunta/show.html.twig', [
            'tipo_preguntum' => $tipoPreguntum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tipo_pregunta_edit", methods={"GET","POST"})
     * @param Request $request
     * @param TipoPregunta $tipoPreguntum
     * @return Response
     */
    public function edit(Request $request, TipoPregunta $tipoPreguntum): Response
    {
        $form = $this->createForm(TipoPreguntaType::class, $tipoPreguntum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tipo_pregunta_index');
        }

        return $this->render('tipo_pregunta/edit.html.twig', [
            'tipo_preguntum' => $tipoPreguntum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tipo_pregunta_delete", methods={"POST"})
     * @param Request $request
     * @param TipoPregunta $tipoPreguntum
     * @return Response
     */
    public function delete(Request $request, TipoPregunta $tipoPreguntum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tipoPreguntum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tipoPreguntum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tipo_pregunta_index');
    }
}
