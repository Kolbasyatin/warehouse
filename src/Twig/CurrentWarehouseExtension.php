<?php

declare(strict_types=1);

namespace App\Twig;

use App\Infrastructure\Warehouse\CurrentWarehouseService;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Forms;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CurrentWarehouseExtension extends AbstractExtension
{
    public function __construct(
        private CurrentWarehouseService $currentWarehouseService,
        private FormFactoryInterface $formFactory
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
//        return $this->currentWarehouseService->getCurrentWarehouse()->getId();
        $data = ['warehouseId' => 'sss'];
        $formBuilder = $this->formFactory->createBuilder(FormType::class, $data);
        $form = $formBuilder
            ->add('warehouseId', TextType::class)
            ->add('OK', SubmitType::class)
            ->getForm()

        ;

        return $form->createView();
    }


}