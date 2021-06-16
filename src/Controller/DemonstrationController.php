<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Package;
use App\Repository\PackageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/demo')]
class DemonstrationController extends AbstractController
{
    public function __construct(private PackageRepository $packageRepository)
    {
    }

    #[Route('/index', name: 'demonstration')]
    public function index(): Response
    {
        $packages = $this->packageRepository->findAll();

        return $this->render('demonstration/index.html.twig', [
            'packages' => $packages,
        ]);
    }

    #[Route('/show/package/{id}', name: 'show-package')]
    public function packageShow(Package $package): Response
    {
        return $this->render('demonstration/package.html.twig', [
            'package' => $package,
        ]);
    }
}
