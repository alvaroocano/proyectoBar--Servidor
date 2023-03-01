<?php

namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;



/**

 * @Route("/api/user")

 */

 class ApiUserController extends AbstractController
 {
 
     /**
 
      * @Route("/", name="app_api_user_index", methods={"GET"})
 
      */
 
     public function index(UserRepository $userRepository): JsonResponse
 
     {
 
         $user= $userRepository->findAll();
 
         $data=[];
 
         foreach($user as $valor){
 
            $data[]=[
 
             'id'=> $valor->getId(),
 
             'email'=> $valor->getEmail(),
 
             'roles'=> $valor->getRoles(),
 
             'password'=> $valor->getPassword(),

             'nombre'=> $valor->getNombre(),
 
             'reservas'=> $valor->getReservas()
 
            ];
 
         }
 
         return new JsonResponse($data, Response::HTTP_OK);
 
     }
    
 /**

     * @Route("/new", name="app_api_user_new", methods={"POST"})

     */

     public function new(Request $request, UserRepository $userRepository): JsonResponse

     {
 
         $data= json_decode($request->getContent(),true);       
 
         $email = $data['email'];
 
         $roles = $data['roles'];

         $password = $data['password'];

         $nombre = $data['nombre'];
 
         $usuario = new User();
        
         $usuario->setEmail($email);

         $usuario->setRoles($roles);

         $usuario->setNombre($nombre);

         $usuario->setPassword($password);
 
         $userRepository->add($usuario, true);
 
         return new JsonResponse(['status'=>'Usuario Creado'], Response::HTTP_CREATED);
 
     }
 
 
     /**
 
      * @Route("/{id}", name="app_api_user_show", methods={"GET"})
 
      */
 
      public function show($id, UserRepository $userRepository): JsonResponse
      {
          $user = $userRepository->findOneBy(["id" => $id]);
          if ($user) {
            $data=[
 
                'id'=> $user->getId(),
    
                'email'=> $user->getEmail(),
    
                'roles'=> $user->getRoles(),
    
                'password'=> $user->getPassword(),
   
                'nombre'=> $user->getNombre(),
    
                'reservas'=> $user->getReservas()
    
               ];

               return new JsonResponse($data, Response::HTTP_ACCEPTED);
          } else {
              return $this->json(["error" => "No existe ese usuario"], 404);
          }
      }
     
     /**
 
      * @Route("/edit/{id}", name="app_api_user_edit", methods={"GET", "PUT"})
 
      */
 
     public function edit(Request $request, $id, UserRepository $userRepository): JsonResponse
     {

        $data = json_decode($request->getContent(),true);

        $user = $userRepository->findOneBy(["id" => $id]);

        $form = $this->createForm(UserType::class, $user);

        $form->submit($data);
        
        if (false === $form->isValid()) {
            return $this->json(["error" => "No existe ese usuario"], 404);
        }

        $entityManager=$this->getDoctrine()->getManager();
        $entityManager->flush();

        return new JsonResponse(['status'=>'Usuario editado'], Response::HTTP_ACCEPTED);
      }
 
 
     /**
 
      * @Route("/delete/{id}", name="app_api_user_delete", methods={"GET", "DELETE"})
 
      */
    public function delete($id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(["id" => $id]);

        if($user){
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
            return new JsonResponse(['status'=>'Usuario borrrau'], Response::HTTP_ACCEPTED);
        }else{
            return $this->json(["error" => "No existe ese usuario"], 404);
        }
        

        
    }


 }
