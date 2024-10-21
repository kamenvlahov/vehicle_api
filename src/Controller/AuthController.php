<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Form\UserRegistrationType;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\SerializerInterface;


class AuthController extends AbstractController
{

    #[Route('/api/me', name: 'api_me', methods: ['GET'])]
    public function me(SerializerInterface $serializer): JsonResponse
    {
        /** @var UserInterface $user */
        $user = $this->getUser();
        if (!$user) {
            return new JsonResponse(['error' => 'Unauthorized access.'], JsonResponse::HTTP_UNAUTHORIZED);
        }
        $json = $serializer->serialize($user, 'json', ['groups' => ['user:read']]);

        return new JsonResponse($json, Response::HTTP_OK, [], true);

    }

    #[Route('/login', name: 'api_login', methods: ['POST', 'OPTIONS'])]
    public function login(
        Request                     $request,
        UserRepository              $userRepository,
        UserPasswordHasherInterface $passwordEncoder,
        JWTTokenManagerInterface    $JWTManager
    ): JsonResponse
    {

        $form = $this->createForm(LoginType::class);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();
            $user = $userRepository->findOneBy(['email' => $email]);
            if (!$user || !$passwordEncoder->isPasswordValid($user, $password)) {
                return new JsonResponse(['error' => 'Invalid credentials.'], 401);
            }
            $token = $JWTManager->create($user);

            return new JsonResponse(['token' => $token, 'roles' => $user->getRoles()]);
        }
        return new JsonResponse(['errors' => ''], 400);
    }

    #[Route('/register', name: 'app_auth', methods: ['POST', 'OPTIONS'])]
    public function register(
        Request                  $request,
        UserRepository           $userRepository,
        JWTTokenManagerInterface $JWTManager,
    ): JsonResponse
    {
        $form = $this->createForm(UserRegistrationType::class);
        $data = json_decode($request->getContent(), true);
        $form->submit($data);


        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user = $userRepository->createUser($user, $data['password']);
            if (!$user) {
                return new JsonResponse(['errors' => 'Error'], 400);
            }
            $token = $JWTManager->create($user);
            return new JsonResponse([
                'message' => 'User successfully registered.',
                'token' => $token,
                'roles' => $user->getRoles()
            ]);
        }

        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return new JsonResponse(['errors' => $errors], 400);
    }
}
