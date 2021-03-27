<?php

namespace App\Controller;

use App\Entity\Cuestionario;
use App\Form\CuestionarioType;
use App\Repository\CuestionarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cuestionario")
 */
class CuestionarioController extends AbstractController
{
    /**
     * @Route("/", name="cuestionario_index", methods={"GET"})
     * @param CuestionarioRepository $cuestionarioRepository
     * @return Response
     */
    public function index(CuestionarioRepository $cuestionarioRepository): Response
    {
        return $this->render('cuestionario/index.html.twig', [
            'cuestionarios' => $cuestionarioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="cuestionario_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $cuestionario = new Cuestionario();
        $form = $this->createForm(CuestionarioType::class, $cuestionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cuestionario);
            $entityManager->flush();

            return $this->redirectToRoute('cuestionario_index');
        }

        return $this->render('cuestionario/new.html.twig', [
            'cuestionario' => $cuestionario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cuestionario_show", methods={"GET"})
     * @param Cuestionario $cuestionario
     * @return Response
     */
    public function show(Cuestionario $cuestionario): Response
    {
        return $this->render('cuestionario/show.html.twig', [
            'cuestionario' => $cuestionario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cuestionario_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Cuestionario $cuestionario
     * @return Response
     */
    public function edit(Request $request, Cuestionario $cuestionario): Response
    {
        $form = $this->createForm(CuestionarioType::class, $cuestionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cuestionario_index');
        }

        return $this->render('cuestionario/edit.html.twig', [
            'cuestionario' => $cuestionario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cuestionario_delete", methods={"POST"})
     * @param Request $request
     * @param Cuestionario $cuestionario
     * @return Response
     */
    public function delete(Request $request, Cuestionario $cuestionario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cuestionario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cuestionario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cuestionario_index');
    }
}
