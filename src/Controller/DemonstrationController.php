<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\WarehouseSelectorType;
use App\Infrastructure\Warehouse\CurrentWarehouseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/demo')]
class DemonstrationController extends AbstractController
{
    public function __construct(
        private CurrentWarehouseService $currentWarehouseService
    )
    {
    }
    #[Route('/changeWarehouse', name: 'change-current-warehouse', methods: ['POST'])]
    public function changeCurrentWarehouse(Request $request)
    {
        $form = $this->createForm(WarehouseSelectorType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $currentWarehouse = $form->getData()['currentWarehouse'];
            if ($currentWarehouse->getId() !== $this->currentWarehouseService->getCurrentWarehouseId()) {
                $this->currentWarehouseService->changeCurrentWarehouse($currentWarehouse);
                $this->addFlash('info', 'Warehouse was changed to ' . $this->currentWarehouseService->getCurrentWarehouse()->getName());
            }
        }

        return $this->redirectToRoute('index');
    }
}
