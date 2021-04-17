<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\Cuestionario;
use App\Form\CuestionarioType;
use App\Repository\CuestionarioRepository;
use App\Security\Voter\CuestionarioVoter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Controller used to manage cuestionarios contents in the backend.
 *
 * Please note that the application backend is developed manually for learning
 * purposes. However, in your real Symfony application you should use any of the
 * existing bundles that let you generate ready-to-use backends without effort.
 *
 * See http://knpbundles.com/keyword/admin
 *
 * @Route("/admin/cuestionario")
 * @IsGranted("ROLE_ADMIN")
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Gerardo J. Montivero <gerardo.montivero@gmail.com>
 */
class FormController extends AbstractController
{
    /**
     * Lists all Cuestionarios entities.
     *
     * This controller responds to two different routes with the same URL:
     *   * 'admin_cuestionario_index' is the route with a name that follows the same
     *     structure as the rest of the controllers of this class.
     *   * 'admin_index' is a nice shortcut to the backend homepage. This allows
     *     to create simpler links in the templates. Moreover, in the future we
     *     could move this annotation to any other controller while maintaining
     *     the route name and therefore, without breaking any existing link.
     *
     * @Route("/", methods="GET", name="admin_index")
     * @Route("/", methods="GET", name="admin_cuestionario_index")
     */
    public function index(CuestionarioRepository $cuestionarios): Response
    {
        $autorCs = $cuestionarios->findBy(['autor' => $this->getUser()], ['publishedAt' => 'DESC']);

        return $this->render('admin/form/index.html.twig', ['cuestionarios' => $autorCs]);
    }

    /**
     * Creates a new Cuestionario entity.
     *
     * @Route("/new", methods="GET|POST", name="admin_cuestionario_new")
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function new(Request $request): Response
    {
        $cuestionario = new Cuestionario();
        $cuestionario->setAutor($this->getUser());

        // See https://symfony.com/doc/current/form/multiple_buttons.html
        $form = $this->createForm(CuestionarioType::class, $cuestionario)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See https://symfony.com/doc/current/forms.html#processing-forms
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cuestionario);
            $em->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/controller.html#flash-messages
            $this->addFlash('success', 'cuestionario.created_successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('admin_cuestionario_new');
            }

            return $this->redirectToRoute('admin_cuestionario_index');
        }

        return $this->render('admin/form/new.html.twig', [
            'cuestionario' => $cuestionario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Cuestionario entity.
     *
     * @Route("/{id<\d+>}", methods="GET", name="admin_cuestionario_show")
     */
    public function show(Cuestionario $cuestionario): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Cuestionario can only be shown to their authors.")
        $this->denyAccessUnlessGranted(CuestionarioVoter::SHOW, $cuestionario, 'Cuestionario can only be shown to their authors.');

        return $this->render('admin/form/show.html.twig', [
            'cuestionario' => $cuestionario,
        ]);
    }

    /**
     * Displays a form to edit an existing Cuestionario entity.
     *
     * @Route("/{id<\d+>}/edit", methods="GET|POST", name="admin_cuestionario_edit")
     * @IsGranted("edit", subject="cuestionario", message="Cuestionario can only be edited by their authors.")
     */
    public function edit(Request $request, Cuestionario $cuestionario): Response
    {
        $form = $this->createForm(CuestionarioType::class, $cuestionario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'cuestionario.updated_successfully');

            return $this->redirectToRoute('admin_cuestionario_edit', ['id' => $cuestionario->getId()]);
        }

        return $this->render('admin/form/edit.html.twig', [
            'cuestionario' => $cuestionario,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Deletes a Post entity.
     *
     * @Route("/{id}/delete", methods="POST", name="admin_cuestionario_delete")
     * @IsGranted("delete", subject="post")
     */
    public function delete(Request $request, Cuestionario $cuestionario): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('admin_cuestionario_index');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($cuestionario);
        $em->flush();

        $this->addFlash('success', 'cuestionario.deleted_successfully');

        return $this->redirectToRoute('admin_cuestionario_index');
    }
}
