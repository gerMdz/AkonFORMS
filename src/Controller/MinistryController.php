<?php

namespace App\Controller;

use App\Entity\Ministry;
use App\Form\MinistryType;
use App\Repository\MinistryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/ministry")
 */
class MinistryController extends AbstractController
{
    /**
     * @Route("/", name="ministry_index", methods={"GET"})
     */
    public function index(MinistryRepository $ministryRepository): Response
    {
        return $this->render('ministry/index.html.twig', [
            'ministries' => $ministryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="ministry_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $ministry = new Ministry();
        $form = $this->createForm(MinistryType::class, $ministry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ministry);
            $entityManager->flush();

            return $this->redirectToRoute('ministry_index');
        }

        return $this->render('ministry/new.html.twig', [
            'ministry' => $ministry,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ministry_show", methods={"GET"})
     */
    public function show(Ministry $ministry): Response
    {
        return $this->render('ministry/show.html.twig', [
            'ministry' => $ministry,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="ministry_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ministry $ministry): Response
    {
        $form = $this->createForm(MinistryType::class, $ministry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ministry_index');
        }

        return $this->render('ministry/edit.html.twig', [
            'ministry' => $ministry,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="ministry_delete", methods={"POST"})
     */
    public function delete(Request $request, Ministry $ministry): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ministry->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ministry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ministry_index');
    }
}
