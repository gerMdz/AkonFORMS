<?php

namespace App\Controller;

use App\Entity\ValorRespuesta;
use App\Form\ValorRespuestaType;
use App\Repository\ValorRespuestaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/valorrespuesta")
 */
class ValorRespuestaController extends AbstractController
{
    /**
     * @Route("/", name="valor_respuesta_index", methods={"GET"})
     * @param ValorRespuestaRepository $valorRespuestaRepository
     * @return Response
     */
    public function index(ValorRespuestaRepository $valorRespuestaRepository): Response
    {
        return $this->render('valor_respuesta/index.html.twig', [
            'valor_respuestas' => $valorRespuestaRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="valor_respuesta_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $valorRespuestum = new ValorRespuesta();
        $form = $this->createForm(ValorRespuestaType::class, $valorRespuestum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($valorRespuestum);
            $entityManager->flush();

            return $this->redirectToRoute('valor_respuesta_index');
        }

        return $this->render('valor_respuesta/new.html.twig', [
            'valor_respuestum' => $valorRespuestum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="valor_respuesta_show", methods={"GET"})
     * @param ValorRespuesta $valorRespuestum
     * @return Response
     */
    public function show(ValorRespuesta $valorRespuestum): Response
    {
        return $this->render('valor_respuesta/show.html.twig', [
            'valor_respuestum' => $valorRespuestum,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="valor_respuesta_edit", methods={"GET","POST"})
     * @param Request $request
     * @param ValorRespuesta $valorRespuestum
     * @return Response
     */
    public function edit(Request $request, ValorRespuesta $valorRespuestum): Response
    {
        $form = $this->createForm(ValorRespuestaType::class, $valorRespuestum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('valor_respuesta_index');
        }

        return $this->render('valor_respuesta/edit.html.twig', [
            'valor_respuestum' => $valorRespuestum,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="valor_respuesta_delete", methods={"POST"})
     * @param Request $request
     * @param ValorRespuesta $valorRespuestum
     * @return Response
     */
    public function delete(Request $request, ValorRespuesta $valorRespuestum): Response
    {
        if ($this->isCsrfTokenValid('delete'.$valorRespuestum->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($valorRespuestum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('valor_respuesta_index');
    }
}
