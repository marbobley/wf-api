<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Entity\User;
use App\Repository\CategorySkillRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('users')]
final class UserController extends AbstractController
{
    #[Route('', name: 'app_user_post', methods: ['POST'])]
    public function createCategorySkill(
        Request $request,
        SerializerInterface $serializerInterface,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $userPasswordHasherInterface
    ): JsonResponse {
        $user = $serializerInterface->deserialize($request->getContent(), User::class, 'json');

        $newUser = new User();
        $newUser->setEmail($user->getEmail());
        $newUser->setRoles(["ROLE_USER"]);
        $newUser->setPassword($userPasswordHasherInterface->hashPassword($user, $user->getPassword()));

        $em->persist($newUser);
        $em->flush();

        $jsonUser = $serializerInterface->serialize($newUser->getId(), 'json');

        //$location = $urlGeneratorInterface->generate('app_skill_detail', ['id' => $skill->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonUser, Response::HTTP_CREATED, [], true);
    }
}
