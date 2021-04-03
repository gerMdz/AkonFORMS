<?php

namespace App\Controller;

use App\Entity\Cuestionario;
use App\Entity\User;
use App\Form\CuestionarioType;
use App\Repository\CuestionarioRepository;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @IsGranted("ROLE_USER")
 *
 * @method User|null getUser()
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
        if ($this->isGranted('ROLE_ADMIN')) {
            $cuestionario = $cuestionarioRepository->findAll();
        } else {
            $user = $this->getUser();
            $cuestionario = $cuestionarioRepository->queryFindByMinistry($user->getMinistry());
        }

        return $this->render('cuestionario/index.html.twig', [
            'cuestionarios' => $cuestionario,
        ]);
    }

    /**
     * @Route("/new", name="cuestionario_new", methods={"GET","POST"})
     * @param Request $request
     * @param string $imagesDir
     * @return Response
     * @throws Exception
     */
    public function new(Request $request, string $imagesDir): Response
    {
        $cuestionario = new Cuestionario();
        $form = $this->createForm(CuestionarioType::class, $cuestionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($photo = $form['image']->getData()) {
                $filename = bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                try {
                    $photo->move($imagesDir, $filename);
                } catch (FileException $e) {
                    // unable to upload the photo, give up
                }
                $cuestionario->setImageFilename($filename);
            }
            $cuestionario->setUser($this->getUser());
            $cuestionario->setMinistry($this->getUser()->getMinistry());
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
     * @throws Exception
     */
    public function show(Cuestionario $cuestionario): Response
    {
        if ($this->getUser()->getMinistry() !== $cuestionario->getMinistry()) {
            throw new Exception('No puede ver este cuestionario', 403);
        }

            return $this->render('cuestionario/show.html.twig', [
                'cuestionario' => $cuestionario,
            ]);

    }

    /**
     * @Route("/{id}/edit", name="cuestionario_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Cuestionario $cuestionario
     * @param string $imagesDir
     * @return Response
     * @throws Exception
     */
    public function edit(Request $request, Cuestionario $cuestionario,string $imagesDir): Response
    {
        if ($this->getUser()->getMinistry() !== $cuestionario->getMinistry()) {
            throw new Exception('No puede editar este cuestionario', 403);
        }

        $form = $this->createForm(CuestionarioType::class, $cuestionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($photo = $form['image']->getData()) {
                $filename = bin2hex(random_bytes(6)).'.'.$photo->guessExtension();
                try {
                    $photo->move($imagesDir, $filename);
                } catch (FileException $e) {
                    // unable to upload the photo, give up
                }
                $cuestionario->setImageFilename($filename);
            }
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
     * @throws Exception
     */
    public function delete(Request $request, Cuestionario $cuestionario): Response
    {
        if ($this->getUser()->getMinistry() !== $cuestionario->getMinistry()) {
            throw new Exception('No puede borrar este cuestionario', 403);
        }
        if ($this->isCsrfTokenValid('delete'.$cuestionario->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cuestionario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cuestionario_index');
    }
}
