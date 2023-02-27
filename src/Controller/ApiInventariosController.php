<?php

namespace App\Controller;

use App\Entity\Inventarios;
use App\Form\InventariosType;
use App\Repository\InventariosRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**

 * @Route("/api/inventarios")

 */

class ApiInventariosController extends AbstractController
{

    /**
 
     * @Route("/", name="app_api_inventarios_index", methods={"GET"})
 
     */

    public function index(InventariosRepository $inventariosRepository): JsonResponse

    {

        $inventarios = $inventariosRepository->findAll();

        $data = [];

        foreach ($inventarios as $valor) {

            $data[] = [

                'id' => $valor->getId(),

                'nombre' => $valor->getNombre(),

                'precio' => $valor->getPrecio(),

                'cantidad' => $valor->getCantidad(),

                'restaurantes' => $valor->getRestaurantes()

            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**

     * @Route("/new", name="app_api_inventarios_new", methods={"POST"})

     */

    public function new(Request $request, InventariosRepository $inventariosRepository): JsonResponse

    {

        $data = json_decode($request->getContent(), true);

        $nombre = $data['nombre'];

        $precio = $data['precio'];

        $cantidad = $data['cantidad'];

        $resestaurantes = $data['resestaurantes'];

        $inventario = new Inventarios();

        $inventario->setNombre($nombre);

        $inventario->setPrecio($precio);

        $inventario->setCantidad($cantidad);

        $inventario->setRestaurantes($resestaurantes);

        $inventariosRepository->add($inventario, true);

        return new JsonResponse(['status' => 'Inventario Creado'], Response::HTTP_CREATED);
    }


    /**
 
     * @Route("/{id}", name="app_api_inventarios_show", methods={"GET"})
 
     */

    public function show($id, InventariosRepository $inventariosRepository): JsonResponse
    {
        $inventarios = $inventariosRepository->findOneBy(["id" => $id]);
        if ($inventarios) {
            $data[] = [

                'id' => $inventarios->getId(),

                'nombre' => $inventarios->getNombre(),

                'precio' => $inventarios->getPrecio(),

                'cantidad' => $inventarios->getCantidad(),

                'restaurantes' => $inventarios->getRestaurantes()

            ];

            return new JsonResponse($data, Response::HTTP_ACCEPTED);
        } else {
            return $this->json(["error" => "No existe ese inventario"], 404);
        }
    }

    /**
 
     * @Route("/edit/{id}", name="app_api_inventarios_edit", methods={"GET", "PUT"})
 
     */

    public function edit(Request $request, $id, InventariosRepository $inventariosRepository): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $inventarios = $inventariosRepository->findOneBy(["id" => $id]);

        $form = $this->createForm(InventariosType::class, $inventarios);

        $form->submit($data);

        if (false === $form->isValid()) {
            return $this->json(["error" => "No existe ese inventario"], 404);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return new JsonResponse(['status' => 'Inventario editado'], Response::HTTP_ACCEPTED);
    }


    /**
 
     * @Route("/delete/{id}", name="app_api_inventarios_delete", methods={"GET", "DELETE"})
 
     */
    public function delete($id, InventariosRepository $inventariosRepository): JsonResponse
    {
        $inventarios = $inventariosRepository->findOneBy(["id" => $id]);

        if ($inventarios) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($inventarios);
            $entityManager->flush();
            return new JsonResponse(['status' => 'Inventario borrrado'], Response::HTTP_ACCEPTED);
        } else {
            return $this->json(["error" => "No existe ese inventario"], 404);
        }
    }
}
