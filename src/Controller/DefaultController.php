<?php

namespace App\Controller;

use App\Service\ImageManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(ImageManager $imageManager): Response
    {
        $var = 'toto';

        $targetDirectory = $imageManager->getTargetDirectory();

        return $this->render('default/index.html.twig', [
            'controller_name' => $var,
            'target_directory' => $targetDirectory
        ]);
    }

    public function imageStream(int $id, EntityManagerInterface $em): Response
    {
        $image = $em->getRepository(File::class)->find($id);

        return new Response('Fichier ok derrier image->path');
    }
}
