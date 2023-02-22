<?php

namespace App\Controller;

use App\Entity\Restaurantes;
use App\Form\RestaurantesType;
use App\Repository\RestaurantesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/restaurantes")
 */
class RestaurantesController extends AbstractController
{
    /**
     * @Route("/", name="app_restaurantes_index", methods={"GET"})
     */
    public function index(RestaurantesRepository $restaurantesRepository): Response
    {
        return $this->render('restaurantes/index.html.twig', [
            'restaurantes' => $restaurantesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_restaurantes_new", methods={"GET", "POST"})
     */
    public function new(Request $request, RestaurantesRepository $restaurantesRepository): Response
    {
        $restaurante = new Restaurantes();
        $form = $this->createForm(RestaurantesType::class, $restaurante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurantesRepository->add($restaurante, true);

            return $this->redirectToRoute('app_restaurantes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restaurantes/new.html.twig', [
            'restaurante' => $restaurante,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_restaurantes_show", methods={"GET"})
     */
    public function show(Restaurantes $restaurante): Response
    {
        return $this->render('restaurantes/show.html.twig', [
            'restaurante' => $restaurante,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_restaurantes_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Restaurantes $restaurante, RestaurantesRepository $restaurantesRepository): Response
    {
        $form = $this->createForm(RestaurantesType::class, $restaurante);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $restaurantesRepository->add($restaurante, true);

            return $this->redirectToRoute('app_restaurantes_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('restaurantes/edit.html.twig', [
            'restaurante' => $restaurante,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_restaurantes_delete", methods={"POST"})
     */
    public function delete(Request $request, Restaurantes $restaurante, RestaurantesRepository $restaurantesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurante->getId(), $request->request->get('_token'))) {
            $restaurantesRepository->remove($restaurante, true);
        }

        return $this->redirectToRoute('app_restaurantes_index', [], Response::HTTP_SEE_OTHER);
    }
}
