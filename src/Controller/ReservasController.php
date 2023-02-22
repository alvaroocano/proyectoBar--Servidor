<?php

namespace App\Controller;

use App\Entity\Reservas;
use App\Form\ReservasType;
use App\Repository\ReservasRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservas")
 */
class ReservasController extends AbstractController
{
    /**
     * @Route("/", name="app_reservas_index", methods={"GET"})
     */
    public function index(ReservasRepository $reservasRepository): Response
    {
        return $this->render('reservas/index.html.twig', [
            'reservas' => $reservasRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_reservas_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ReservasRepository $reservasRepository): Response
    {
        $reserva = new Reservas();
        $form = $this->createForm(ReservasType::class, $reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservasRepository->add($reserva, true);

            return $this->redirectToRoute('app_reservas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservas/new.html.twig', [
            'reserva' => $reserva,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_reservas_show", methods={"GET"})
     */
    public function show(Reservas $reserva): Response
    {
        return $this->render('reservas/show.html.twig', [
            'reserva' => $reserva,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_reservas_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservas $reserva, ReservasRepository $reservasRepository): Response
    {
        $form = $this->createForm(ReservasType::class, $reserva);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservasRepository->add($reserva, true);

            return $this->redirectToRoute('app_reservas_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reservas/edit.html.twig', [
            'reserva' => $reserva,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_reservas_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservas $reserva, ReservasRepository $reservasRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reserva->getId(), $request->request->get('_token'))) {
            $reservasRepository->remove($reserva, true);
        }

        return $this->redirectToRoute('app_reservas_index', [], Response::HTTP_SEE_OTHER);
    }
}
