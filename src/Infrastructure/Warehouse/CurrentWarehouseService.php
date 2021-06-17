<?php

declare(strict_types=1);


namespace App\Infrastructure\Warehouse;


use App\Entity\Warehouse;
use App\Repository\WarehouseRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class CurrentWarehouseService
{
    public const SESSION_WAREHOUSE_ID_NAME = 'currentWarehouseId';


    public function __construct(
        private WarehouseRepository $warehouseRepository,
        private RequestStack $requestStack,
        private string $defaultWarehouseId = 'msk'

    )
    {
    }

    public function getCurrentWarehouse(): Warehouse
    {
        $warehouseId = $this->getWarehouseId();

        return $this->warehouseRepository->findOneById($warehouseId);
    }

    public function getCurrentWarehouseId(): string
    {
        return $this->getCurrentWarehouse()->getId();
    }

    public function changeCurrentWarehouse(Warehouse $warehouse): void
    {
        $session = $this->requestStack->getSession();
        $session->set(self::SESSION_WAREHOUSE_ID_NAME, $warehouse->getId());
    }

    private function getWarehouseId(): string
    {
        $session = $this->requestStack->getSession();
        if (!$session->get(self::SESSION_WAREHOUSE_ID_NAME)) {
            $session->set(self::SESSION_WAREHOUSE_ID_NAME, $this->defaultWarehouseId);
        }

        return $session->get(self::SESSION_WAREHOUSE_ID_NAME);
    }
}