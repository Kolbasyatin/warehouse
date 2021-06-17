<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Package;
use App\Entity\Warehouse;
use App\Exceptions\CurrentWarehouseServiceException;
use App\Form\WarehouseSelectorType;
use App\Infrastructure\Warehouse\CurrentWarehouseService;
use App\Repository\PackageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/changeWarehouse', name: 'change-current-warehouse', methods: ['POST'])]
    public function changeCurrentWarehouse(Request $request, CurrentWarehouseService $currentWarehouseService)
    {
        $form = $this->createForm(WarehouseSelectorType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $currentWarehouse = $form->getData()['currentWarehouse'];
            if ($currentWarehouse->getId() !== $currentWarehouseService->getCurrentWarehouseId()) {
                $currentWarehouseService->changeCurrentWarehouse($currentWarehouse);
                $this->addFlash('info', 'Warehouse was changed to '. $currentWarehouseService->getCurrentWarehouse()->getName());
            }
        }

        return $this->redirectToRoute('index');
    }
}
