<?php

namespace App\Controller;

use App\Entity\File;
use App\Service\ImageManager;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_default')]
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    // public function index(ImageManager $imageManager): Response
    // {
    //     $var = 'toto';

    //     $targetDirectory = $imageManager->getTargetDirectory();

    //     return $this->render('default/index.html.twig', [
    //         'controller_name' => $var,
    //         'target_directory' => $targetDirectory
    //     ]);
    // }

    public function imageStream(int $id, EntityManagerInterface $em): Response
    {
        $image = $em->getRepository(File::class)->find($id);

        return new Response('Fichier ok derrier image->path');
    }
}
