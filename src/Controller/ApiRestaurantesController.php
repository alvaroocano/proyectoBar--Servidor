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

        $localidad = $data['localidad'];

        $horario = $data['horario'];

        $telefono = $data['telefono'];

        $aforo = $data['aforo'];

        $inventarios = $data['inventarios'];

        $restaurante = new Restaurantes();

        $restaurante->setLocalidad($localidad);

        $restaurante->setHorario($horario);

        $restaurante->setTelefono($telefono);

        $restaurante->setAforo($aforo);

        $restaurante->setInventarios($inventarios);

        $restaurantesRepository->add($restaurante, true);

        return new JsonResponse(['status' => 'Restaurante Creado'], Response::HTTP_CREATED);
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

                'localidad' => $restaurantes->getLocalidad(),

                'horario' => $restaurantes->getHorario(),

                'telefono' => $restaurantes->getTelefono(),

                'aforo' => $restaurantes->getAforo(),

                'inventarios' => $restaurantes->getInventarios()


            ];

            return new JsonResponse($data, Response::HTTP_ACCEPTED);
        } else {
            return $this->json(["error" => "No existe ese restaurante"], 404);
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
            return $this->json(["error" => "No existe ese restaurante"], 404);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new JsonResponse(['status' => 'Restaurante editado'], Response::HTTP_ACCEPTED);
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
            return new JsonResponse(['status' => 'Restaurante borrrado'], Response::HTTP_ACCEPTED);
        } else {
            return $this->json(["error" => "No existe ese restaurante"], 404);
        }
    }
}
