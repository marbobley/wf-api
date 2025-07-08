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
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/categories')]
final class CategorySkillController extends AbstractController
{
    #[Route('', name: 'app_category' , methods:['GET'])]
    public function getCategorySkillList(CategorySkillRepository $categorySkillRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $categorySkillList = $categorySkillRepository->findAll();
        $jsoncategorySkillList = $serializerInterface->serialize($categorySkillList, 'json', ['groups' => "getSkills"]);

        return new JsonResponse($jsoncategorySkillList, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'app_category_detail' , methods:['GET'])]
    public function getCategorySkill(CategorySkill $categorySkill, SerializerInterface $serializerInterface): JsonResponse
    {
            $jsonSkill = $serializerInterface->serialize($categorySkill, 'json', ['groups' => "getSkills"]);
            return new JsonResponse($jsonSkill, Response::HTTP_OK, [] , true);
    }
    #[Route('/{id}', name: 'app_category_delete', methods:['DELETE'])]
    public function deleteCategorySkill(CategorySkill $categorySkill, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($categorySkill);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('', name:'app_create_category', methods:['POST'])]
    public function createCategorySkill(Request $request, SerializerInterface $serializerInterface, EntityManagerInterface $em, UrlGeneratorInterface $urlGeneratorInterface): JsonResponse
    {
        $categorySkill = $serializerInterface->deserialize($request->getContent(), CategorySkill::class, 'json');
        $em->persist($categorySkill);
        $em->flush();

        $jsonCategorySkill = $serializerInterface->serialize($categorySkill, 'json', ['groups' => 'getSkills']);

        $location = $urlGeneratorInterface->generate('detailSkill', ['id' => $categorySkill->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonCategorySkill, Response::HTTP_CREATED, ["Location" => $location], true);
    }
}
