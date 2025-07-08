<?php

namespace App\Controller;

use App\Repository\SkillRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class SkillController extends AbstractController
{
    #[Route('/api/skills', name: 'app_skill' , methods:['GET'])]
    public function index(SkillRepository $skillRepository): JsonResponse
    {
        $skillList = $skillRepository->findAll();

        return new JsonResponse([
                'skills' => $skillList,
            ]);
    }
}
