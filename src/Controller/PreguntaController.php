<?php

namespace App\Controller;

use App\Entity\Pregunta;
use App\Form\PreguntaType;
use App\Repository\PreguntaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pregunta")
 */
class PreguntaController extends AbstractController
{
    /**
     * @Route("/", name="pregunta_index", methods={"GET"})
     * @param PreguntaRepository $preguntaRepository
     * @return Response
     */
    public function index(PreguntaRepository $preguntaRepository): Response
    {
        return $this->render('pregunta/index.html.twig', [
            'preguntas' => $preguntaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pregunta_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $preguntum = new Pregunta();
        $form = $this->createForm(PreguntaType::class, $preguntum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($preguntum);
            $entityManager->flush();

            return $this->redirectToRoute('pregunta_index');
        }

        return $this->render('pregunta/new.html.twig', [
            'preguntum' => $preguntum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pregunta_show", methods={"GET"})
     * @param Pregunta $preguntum
     * @return Response
     */
    public function show(Pregunta $preguntum): Response
    {
        return $this->render('pregunta/show.html.twig', [
            'preguntum' => $preguntum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pregunta_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Pregunta $preguntum
     * @return Response
     */
    public function edit(Request $request, Pregunta $preguntum): Response
    {
        $form = $this->createForm(PreguntaType::class, $preguntum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pregunta_index');
        }

        return $this->render('pregunta/edit.html.twig', [
            'preguntum' => $preguntum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pregunta_delete", methods={"POST"})
     * @param Request $request
     * @param Pregunta $preguntum
     * @return Response
     */
    public function delete(Request $request, Pregunta $preguntum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$preguntum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($preguntum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('pregunta_index');
    }
}
