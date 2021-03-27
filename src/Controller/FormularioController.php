<?php

namespace App\Controller;

use App\Entity\Formulario;
use App\Form\FormularioType;
use App\Repository\FormularioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/formulario")
 */
class FormularioController extends AbstractController
{
    /**
     * @Route("/", name="formulario_index", methods={"GET"})
     * @param FormularioRepository $formularioRepository
     * @return Response
     */
    public function index(FormularioRepository $formularioRepository): Response
    {
        return $this->render('formulario/index.html.twig', [
            'formularios' => $formularioRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="formulario_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $formulario = new Formulario();
        $form = $this->createForm(FormularioType::class, $formulario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formulario);
            $entityManager->flush();

            return $this->redirectToRoute('formulario_index');
        }

        return $this->render('formulario/new.html.twig', [
            'formulario' => $formulario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formulario_show", methods={"GET"})
     * @param Formulario $formulario
     * @return Response
     */
    public function show(Formulario $formulario): Response
    {
        return $this->render('formulario/show.html.twig', [
            'formulario' => $formulario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="formulario_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Formulario $formulario
     * @return Response
     */
    public function edit(Request $request, Formulario $formulario): Response
    {
        $form = $this->createForm(FormularioType::class, $formulario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('formulario_index');
        }

        return $this->render('formulario/edit.html.twig', [
            'formulario' => $formulario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formulario_delete", methods={"POST"})
     * @param Request $request
     * @param Formulario $formulario
     * @return Response
     */
    public function delete(Request $request, Formulario $formulario): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formulario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($formulario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formulario_index');
    }
}
