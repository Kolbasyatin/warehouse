<?php

declare(strict_types=1);


namespace App\Twig;


use App\Repository\WarehouseRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CurrentWarehouseExtension extends AbstractExtension
{
    public function __construct(
        private WarehouseRepository $warehouseRepository,
        private RequestStack $requestStack,
        private string $defaultWarehouseId = 'msk'
    )
    {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('currentWarehouse', [$this, 'currentWarehouse'])
        ];
    }

    public function currentWarehouse()
    {
        $warehouseId = $this->getWarehouseId();
        $warehouse = $this->warehouseRepository->findOneById($warehouseId);

        return $warehouseId;
    }

    private function getWarehouseId(): string
    {
        $session = $this->requestStack->getSession();
        if (!$session->get('currentWarehouseId')) {
            $session->set('currentWarehouseId', $this->defaultWarehouseId);
        }
        $id = $session->get('currentWarehouseId');

        return $session->get('whsId');
    }
}