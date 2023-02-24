<?php

namespace App\Controller;

use App\Entity\Restaurantes;
use App\Form\RestaurantesType;
use App\Repository\RestaurantesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**

 * @Route("/api/restaurantes")

 */

class ApiRestaurantesController extends AbstractController
{

    /**
 
     * @Route("/", name="app_api_restaurantes_index", methods={"GET"})
 
     */

    public function index(RestaurantesRepository $restaurantesRepository): JsonResponse

    {

        $restaurantes = $restaurantesRepository->findAll();

        $data = [];

        foreach ($restaurantes as $valor) {

            $data[] = [

                'id' => $valor->getId(),

                'localidad' => $valor->getLocalidad(),

                'horario' => $valor->getHorario(),

                'telefono' => $valor->getTelefono(),

                'aforo' => $valor->getAforo(),

                'inventarios' => $valor->getInventarios()

            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**

     * @Route("/new", name="app_api_restaurantes_new", methods={"POST"})

     */

    public function new(Request $request, RestaurantesRepository $restaurantesRepository): JsonResponse

    {

        $data = json_decode($request->getContent(), true);

        $fecha = $data['fecha'];

        $hora = $data['hora'];

        $nro_personas = $data['nro_personas'];

        $primero = $data['primero'];

        $segundo = $data['segundo'];

        $bebida = $data['bebida'];

        $postre = $data['postre'];

        $restaurantes = $data['restaurantes'];

        $user = $data['user'];

        $reserva = new Restaurantes();

        $reserva->setFecha($fecha);

        $reserva->setHora($hora);

        $reserva->setNroPersonas($nro_personas);

        $reserva->setPrimero($primero);

        $reserva->setSegundo($segundo);

        $reserva->setBebida($bebida);

        $reserva->setPostre($postre);

        $reserva->setRestaurantes($restaurantes);

        $reserva->setUser($user);

        $restaurantesRepository->add($reserva, true);

        return new JsonResponse(['status' => 'Reserva Creada'], Response::HTTP_CREATED);
    }


    /**
 
     * @Route("/{id}", name="app_api_restaurantes_show", methods={"GET"})
 
     */

    public function show($id, RestaurantesRepository $restaurantesRepository): JsonResponse
    {
        $restaurantes = $restaurantesRepository->findOneBy(["id" => $id]);
        if ($restaurantes) {
            $data = [

                'id' => $restaurantes->getId(),

                'fecha' => $restaurantes->getFecha(),

                'hora' => $restaurantes->getHora(),

                'nro_personas' => $restaurantes->getNroPersonas(),

                'primero' => $restaurantes->getPrimero(),

                'segundo' => $restaurantes->getSegundo(),

                'bebida' => $restaurantes->getBebida(),

                'postre' => $restaurantes->getPostre(),

                'restaurantes' => $restaurantes->getRestaurantes(),

                'user' => $restaurantes->getUser()


            ];

            return new JsonResponse($data, Response::HTTP_ACCEPTED);
        } else {
            return $this->json(["error" => "No existe esa reserva"], 404);
        }
    }

    /**
 
     * @Route("/edit/{id}", name="app_api_restaurantes_edit", methods={"GET", "PUT"})
 
     */

    public function edit(Request $request, $id, RestaurantesRepository $restaurantesRepository): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $restaurantes = $restaurantesRepository->findOneBy(["id" => $id]);

        $form = $this->createForm(RestaurantesType::class, $restaurantes);

        $form->submit($data);

        if (false === $form->isValid()) {
            return $this->json(["error" => "No existe esa reserva"], 404);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new JsonResponse(['status' => 'Reserva editada'], Response::HTTP_ACCEPTED);
    }


    /**
 
     * @Route("/delete/{id}", name="app_api_restaurantes_delete", methods={"GET", "DELETE"})
 
     */
    public function delete($id, RestaurantesRepository $restaurantesRepository): JsonResponse
    {
        $restaurantes = $restaurantesRepository->findOneBy(["id" => $id]);

        if ($restaurantes) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($restaurantes);
            $entityManager->flush();
            return new JsonResponse(['status' => 'Reserva borrrada'], Response::HTTP_ACCEPTED);
        } else {
            return $this->json(["error" => "No existe ese reserva"], 404);
        }
    }
}
