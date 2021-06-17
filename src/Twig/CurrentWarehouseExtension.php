<?php

declare(strict_types=1);

namespace App\Twig;

use App\Form\WarehouseSelectorType;
use App\Infrastructure\Warehouse\CurrentWarehouseService;
use Symfony\Component\Form\FormFactoryInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CurrentWarehouseExtension extends AbstractExtension
{
    public function __construct(
        private CurrentWarehouseService $currentWarehouseService,
        private FormFactoryInterface $formFactory,
    )
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction(
                'currentWarehouseSelector',
                [$this, 'currentWarehouse'],
                ['is_safe' => ['html'], 'needs_environment' => true])
        ];
    }

    public function currentWarehouse(Environment $twig): string
    {
        $currentWarehouse = $this->currentWarehouseService->getCurrentWarehouse();
        $form = $this->formFactory->create(WarehouseSelectorType::class, ['currentWarehouse' => $currentWarehouse]);

        return $twig->render('_warehouse-select.html.twig', ['form' => $form->createView()]);
    }


}