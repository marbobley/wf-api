<?php

namespace App\Controller;

use App\Entity\CategorySkill;
use App\Repository\CategorySkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('api/category')]
final class CategorySkillController extends AbstractController
{
    #[Route('', name: 'app_category' , methods:['GET'])]
    public function getSkillList(CategorySkillRepository $categorySkillRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $categorySkillList = $categorySkillRepository->findAll();
        $jsoncategorySkillList = $serializerInterface->serialize($categorySkillList, 'json', ['groups' => "getSkills"]);

        return new JsonResponse($jsoncategorySkillList, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'app_category_detail' , methods:['GET'])]
    public function getSkillSlug(CategorySkill $categorySkill, SerializerInterface $serializerInterface): JsonResponse
    {
            $jsonSkill = $serializerInterface->serialize($categorySkill, 'json', ['groups' => "getSkills"]);
            return new JsonResponse($jsonSkill, Response::HTTP_OK, [] , true);
    }
}
