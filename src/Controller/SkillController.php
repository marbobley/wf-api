<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class SkillController extends AbstractController
{
    #[Route('/api/skills', name: 'app_skills' , methods:['GET'])]
    public function getSkillList(SkillRepository $skillRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $skillList = $skillRepository->findAll();
        $jsonSkillList = $serializerInterface->serialize($skillList, 'json');

        return new JsonResponse($jsonSkillList, Response::HTTP_OK, [], true);
    }
    #[Route('/api/skills/{id}', name: 'app_skill_detail' , methods:['GET'])]
    public function getSkill(int $id, SkillRepository $skillRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $skill = $skillRepository->find($id);
        if($skill)
        {
            $jsonSkill = $serializerInterface->serialize($skill, 'json');
            return new JsonResponse($jsonSkill, Response::HTTP_OK, [] , true);
        }
        return new JsonResponse(null, Response::HTTP_NOT_FOUND, );
    }
}
