<?php

namespace App\Controller;

use App\Entity\CategorySkill;
use App\Repository\CategorySkillRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use  Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('api/categories')]
final class CategorySkillController extends AbstractController
{
    #[Route('', name: 'app_category', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous ne possédez pas les droits suffisant pour voir les catégories de compétences')]
    public function getCategorySkillList(CategorySkillRepository $categorySkillRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $categorySkillList = $categorySkillRepository->findAll();
        $jsoncategorySkillList = $serializerInterface->serialize($categorySkillList, 'json', ['groups' => "getSkills"]);

        return new JsonResponse($jsoncategorySkillList, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'app_category_detail', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous ne possédez pas les droits suffisant pour voir la catégorie de compétences')]
    public function getCategorySkill(CategorySkill $categorySkill, SerializerInterface $serializerInterface): JsonResponse
    {
        $jsonSkill = $serializerInterface->serialize($categorySkill, 'json', ['groups' => "getSkills"]);
        return new JsonResponse($jsonSkill, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'app_category_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous ne possédez pas les droits suffisant pour supprimer la catégorie de compétences')]
    public function deleteCategorySkill(CategorySkill $categorySkill, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($categorySkill);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('', name: 'app_create_category', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous ne possédez pas les droits suffisant pour créer une catégorie de compétences')]
    public function createCategorySkill(Request $request, SerializerInterface $serializerInterface, EntityManagerInterface $em, UrlGeneratorInterface $urlGeneratorInterface, ValidatorInterface $validatorInterface): JsonResponse
    {
        $categorySkill = $serializerInterface->deserialize($request->getContent(), CategorySkill::class, 'json');

        $errors = $validatorInterface->validate($categorySkill);

        if ($errors->count() > 0) {
            return new JsonResponse($serializerInterface->serialize($errors, 'json'), JsonResponse::HTTP_BAD_REQUEST, [], true);
        }

        $em->persist($categorySkill);
        $em->flush();

        $jsonCategorySkill = $serializerInterface->serialize($categorySkill, 'json', ['groups' => 'getSkills']);

        $location = $urlGeneratorInterface->generate('app_category_detail', ['id' => $categorySkill->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonCategorySkill, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/{id}', name: "app_update_category", methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous ne possédez pas les droits suffisant pour mettre à jour la catégorie de compétences')]
    public function updateCategorySkill(Request $request, SerializerInterface $serializerInterface, CategorySkill $currentCategorySkill, EntityManagerInterface $em): JsonResponse
    {
        $updateCategorySkill = $serializerInterface->deserialize(
            $request->getContent(),
            CategorySkill::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentCategorySkill]
        );

        $em->persist($updateCategorySkill);
        $em->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
