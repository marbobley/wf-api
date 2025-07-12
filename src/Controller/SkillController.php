<?php

namespace App\Controller;

use App\Entity\CategorySkill;
use App\Entity\Skill;
use App\Repository\CategorySkillRepository;
use App\Repository\SkillRepository;
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

#[Route('skills')]
final class SkillController extends AbstractController
{
    #[Route('', name: 'app_skills', methods: ['GET'])]
    public function getSkillList(SkillRepository $skillRepository, SerializerInterface $serializerInterface): JsonResponse
    {
        $skillList = $skillRepository->findAll();
        $jsonSkillList = $serializerInterface->serialize($skillList, 'json', ['groups' => "getSkills"]);

        return new JsonResponse($jsonSkillList, Response::HTTP_OK, [], true);
    }
    #[Route('/{id}', name: 'app_skill_detail', methods: ['GET'])]
    public function getSkill(Skill $skill, SerializerInterface $serializerInterface): JsonResponse
    {
        $jsonSkill = $serializerInterface->serialize($skill, 'json', ['groups' => "getSkills"]);
        return new JsonResponse($jsonSkill, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'app_skill_delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous ne possédez pas les droits suffisant pour supprimer une compétences')]
    public function deleteSkill(Skill $skill, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($skill);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    #[Route('', name: 'app_skill_post', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous ne possédez pas les droits suffisant pour poster une compétences')]
    public function createCategorySkill(
        Request $request,
        SerializerInterface $serializerInterface,
        EntityManagerInterface $em,
        UrlGeneratorInterface $urlGeneratorInterface,
        CategorySkillRepository $categorySkillRepository
    ): JsonResponse {
        $skill = $serializerInterface->deserialize($request->getContent(), Skill::class, 'json');

        $skillCats = $skill->getCategorySkill();
        foreach ($skillCats as $skillCat) {
            $curCatSkill = $categorySkillRepository->findOneBy(['name' => $skillCat->getName()]);
            $skill->removeCategorySkill($skillCat);

            if($curCatSkill != null)
                $skill->addCategorySkill($curCatSkill);
            else
                $skill->addCategorySkill($skillCat);
        }

        $em->persist($skill);
        $em->flush();

        $jsonSkill = $serializerInterface->serialize($skill, 'json', ['groups' => 'getSkills']);

        $location = $urlGeneratorInterface->generate('app_skill_detail', ['id' => $skill->getId()], UrlGeneratorInterface::ABSOLUTE_URL);

        return new JsonResponse($jsonSkill, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    
    #[Route('/{id}', name: "app_update_skill", methods: ['PUT'])]
    #[IsGranted('ROLE_ADMIN', message: 'Vous ne possédez pas les droits suffisant pour mettre à jour la compétence')]
    public function updateSkill(Request $request, SerializerInterface $serializerInterface, Skill $currentSkill, EntityManagerInterface $em): JsonResponse
    {
        $updateSkill = $serializerInterface->deserialize(
            $request->getContent(),
            Skill::class,
            'json',
            [AbstractNormalizer::OBJECT_TO_POPULATE => $currentSkill]
        );

        $em->persist($updateSkill);
        $em->flush();
        return new JsonResponse(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
