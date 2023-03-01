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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**

 * @Route("/api/user")

 */

 class ApiUserController extends AbstractController
 {
    
    private $encoder;
    private $userRepository;

    public function __construct(UserRepository $userRepository,UserPasswordEncoderInterface $encoder){
        $this->userRepository=$userRepository;
        $this->encoder=$encoder;
    }

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

     * @Route("/new", name="app_api_user_new", methods={"GET","POST"})

     */

     public function new(Request $request, UserRepository $userRepository): Response

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

         $pass=$this->encoder->encodePassword($usuario,$password);
         $usuario->setPassword($pass);
 
         $userRepository->add($usuario, true);
 
         return new Response(Response::HTTP_CREATED);
 
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

    /**
     * @Route("/login", name="app_api_user_login",methods={"GET","POST"})
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $data=json_decode($request->getContent(),true);
        $email=$data["email"];
        $password=$data["password"];
        return ($email.$password);
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


 }
