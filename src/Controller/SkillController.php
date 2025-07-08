<?php

namespace App\Controller;

use App\Entity\Skill;
use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/skills')]
final class SkillController extends AbstractController
{
    #[Route('', name: 'app_skills' , methods:['GET'])]
    public function getSkillList(SkillRepository $skillRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $skillList = $skillRepository->findAll();
        $jsonSkillList = $serializerInterface->serialize($skillList, 'json', ['groups' => "getSkills"]);

        return new JsonResponse($jsonSkillList, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'app_skill_detail' , methods:['GET'])]
    public function getSkillSlug(Skill $skill, SerializerInterface $serializerInterface): JsonResponse
    {
            $jsonSkill = $serializerInterface->serialize($skill, 'json', ['groups' => "getSkills"]);
            return new JsonResponse($jsonSkill, Response::HTTP_OK, [] , true);
    }
}
