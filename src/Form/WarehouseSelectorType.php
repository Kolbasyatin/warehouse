<?php

declare(strict_types=1);


namespace App\Form;


use App\Entity\Warehouse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class WarehouseSelectorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentWarehouse', EntityType::class, [
                'class' => Warehouse::class,
                'choice_label' => 'name'
            ])
        ;

    }
}