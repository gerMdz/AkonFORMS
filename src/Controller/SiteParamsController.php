<?php

namespace App\Controller;

use App\Entity\SiteParams;
use App\Form\SiteParamsType;
use App\Repository\SiteParamsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/site/params")
 */
class SiteParamsController extends AbstractController
{
    /**
     * @Route("/", name="app_site_params_index", methods={"GET"})
     */
    public function index(SiteParamsRepository $siteParamsRepository): Response
    {
        return $this->render('site_params/index.html.twig', [
            'site_params' => $siteParamsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_site_params_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SiteParamsRepository $siteParamsRepository): Response
    {
        $siteParam = new SiteParams();
        $form = $this->createForm(SiteParamsType::class, $siteParam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $siteParamsRepository->add($siteParam, true);

            return $this->redirectToRoute('app_site_params_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site_params/new.html.twig', [
            'site_param' => $siteParam,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_site_params_show", methods={"GET"})
     */
    public function show(SiteParams $siteParam): Response
    {
        return $this->render('site_params/show.html.twig', [
            'site_param' => $siteParam,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_site_params_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, SiteParams $siteParam, SiteParamsRepository $siteParamsRepository): Response
    {
        $form = $this->createForm(SiteParamsType::class, $siteParam);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $siteParamsRepository->add($siteParam, true);

            return $this->redirectToRoute('app_site_params_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('site_params/edit.html.twig', [
            'site_param' => $siteParam,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_site_params_delete", methods={"POST"})
     */
    public function delete(Request $request, SiteParams $siteParam, SiteParamsRepository $siteParamsRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$siteParam->getId(), $request->request->get('_token'))) {
            $siteParamsRepository->remove($siteParam, true);
        }

        return $this->redirectToRoute('app_site_params_index', [], Response::HTTP_SEE_OTHER);
    }
}
