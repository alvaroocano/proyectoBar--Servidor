<?php

namespace App\Controller;

use App\Entity\Inventarios;
use App\Form\InventariosType;
use App\Repository\InventariosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/inventarios")
 */
class InventariosController extends AbstractController
{
    /**
     * @Route("/", name="app_inventarios_index", methods={"GET"})
     */
    public function index(InventariosRepository $inventariosRepository): Response
    {
        return $this->render('inventarios/index.html.twig', [
            'inventarios' => $inventariosRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_inventarios_new", methods={"GET", "POST"})
     */
    public function new(Request $request, InventariosRepository $inventariosRepository): Response
    {
        $inventario = new Inventarios();
        $form = $this->createForm(InventariosType::class, $inventario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inventariosRepository->add($inventario, true);

            return $this->redirectToRoute('app_inventarios_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inventarios/new.html.twig', [
            'inventario' => $inventario,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_inventarios_show", methods={"GET"})
     */
    public function show(Inventarios $inventario): Response
    {
        return $this->render('inventarios/show.html.twig', [
            'inventario' => $inventario,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_inventarios_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Inventarios $inventario, InventariosRepository $inventariosRepository): Response
    {
        $form = $this->createForm(InventariosType::class, $inventario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $inventariosRepository->add($inventario, true);

            return $this->redirectToRoute('app_inventarios_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('inventarios/edit.html.twig', [
            'inventario' => $inventario,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_inventarios_delete", methods={"POST"})
     */
    public function delete(Request $request, Inventarios $inventario, InventariosRepository $inventariosRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$inventario->getId(), $request->request->get('_token'))) {
            $inventariosRepository->remove($inventario, true);
        }

        return $this->redirectToRoute('app_inventarios_index', [], Response::HTTP_SEE_OTHER);
    }
}
