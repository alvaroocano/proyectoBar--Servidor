<?php

namespace App\Controller;

use App\Entity\Reservas;
use App\Form\ReservasType;
use App\Repository\ReservasRepository;
use App\Repository\RestaurantesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**

 * @Route("/api/reservas")

 */

class ApiReservasController extends AbstractController
{

    /**
 
     * @Route("/", name="app_api_reservas_index", methods={"GET"})
 
     */

    public function index(ReservasRepository $reservasRepository): JsonResponse

    {

        $reservas = $reservasRepository->findAll();

        $data = [];

        foreach ($reservas as $valor) {

            $data[] = [

                'id' => $valor->getId(),

                'fecha' => $valor->getFecha(),

                'hora' => $valor->getHora(),

                'nro_personas' => $valor->getNroPersonas(),

                'primero' => $valor->getPrimero(),

                'segundo' => $valor->getSegundo(),

                'bebida' => $valor->getBebida(),

                'postre' => $valor->getPostre(),

                'restaurantes' => $valor->getRestaurantes(),

                'user' => $valor->getUser()

            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**

     * @Route("/new/{id}/{localidad}", name="app_api_reservas_new", methods={"GET","POST"})

     */

    public function new(Request $request, ReservasRepository $reservasRepository, UserRepository $userRepository, RestaurantesRepository $restaurantesRepository,$id,$localidad): Response

    {

        $data = json_decode($request->getContent(), true);

        $fecha = $data['fecha'];

        $hora = $data['hora'];

        $nro_personas = $data['nro_personas'];

        $primero = $data['primero'];

        $segundo = $data['segundo'];

        $bebida = $data['bebida'];

        $postre = $data['postre'];

        $total = $data['total'];

        $usuario=$userRepository->findOneBy(["id" => $id]);
        $restaurante=$restaurantesRepository->findOneBy(["localidad" => $localidad]);

        if($usuario && $restaurante){
            $reserva = new Reservas();

            $reserva->setFecha($fecha);

            $reserva->setHora($hora);

            $reserva->setNroPersonas($nro_personas);

            $reserva->setPrimero($primero);

            $reserva->setSegundo($segundo);

            $reserva->setBebida($bebida);

            $reserva->setPostre($postre);

            $reserva->setTotal($total);

            $reserva->setRestaurantes($restaurante);

            $reserva->setUser($usuario);

            $reservasRepository->add($reserva, true);
        }
        

        return new Response(Response::HTTP_CREATED);
    }


    /**
 
     * @Route("/{id}", name="app_api_reservas_show", methods={"GET"})
 
     */

    public function show($id, ReservasRepository $reservasRepository): JsonResponse
    {
        $reservas = $reservasRepository->findBy(["user" => $id]);
        if ($reservas) {
            $data = [];

            foreach ($reservas as $valor) {
            $data[] = [

                'id' => $valor->getId(),

                'fecha' => $valor->getFecha(),

                'hora' => $valor->getHora(),

                'nro_personas' => $valor->getNroPersonas(),

                'primero' => $valor->getPrimero(),

                'segundo' => $valor->getSegundo(),

                'bebida' => $valor->getBebida(),

                'postre' => $valor->getPostre(),

                'restaurantes' => $valor->getRestaurantes(),

                'user' => $valor->getUser()
            ];
        }
            return new JsonResponse($data, Response::HTTP_ACCEPTED);
        } else {
            return $this->json(["error" => "No existe esa reserva"], 404);
        }
    }

    /**
 
     * @Route("/edit/{id}", name="app_api_reservas_edit", methods={"GET", "PUT"})
 
     */

    public function edit(Request $request, EntityManagerInterface $reservasRepository,$id, ReservasRepository $repositorio): Response
    {
        $personas=json_decode($request->getContent(),true);
        $reserva=$repositorio->findOneBy(["id"=>$id]);
        if($reserva){
            $reserva->setNroPersonas($personas);
            $reservasRepository->flush();
            return new Response(Response::HTTP_ACCEPTED);
        }else{
            return new Response(Response::HTTP_NOT_ACCEPTABLE);
        }
        
        
    }


    /**
 
     * @Route("/delete/{id}", name="app_api_reservas_delete", methods={"GET", "DELETE"})
 
     */
    public function delete($id, ReservasRepository $reservasRepository): JsonResponse
    {
        $reservas = $reservasRepository->findOneBy(["id" => $id]);

        if ($reservas) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservas);
            $entityManager->flush();
            return new JsonResponse(['status' => 'Reserva borrrada'], Response::HTTP_ACCEPTED);
        } else {
            return $this->json(["error" => "No existe esa reserva"], 404);
        }
    }
}
