<?php

declare(strict_types=1);


namespace App\Infrastructure\Workflow;


use App\Entity\Pallet;

final class WorkflowNameMatcher implements WorkflowNameMatchingInterface
{
    /**
     * TODO: Возможно тут стоит называть попросту типа посылок именами workflow
     * но оставляем маневр для переименований workflow без изменений в полях
     * и для возможности изменений сопоставлений.
     * Меня смущает что сущности разные, а уникальность этого поля приходится соблюдать
     * однако чтоб не соблюдать придется пилить доп сервис матчинга имен и усложнять
     * фабрикой либо проверять непосредственно принадлежность к классу.
     */

    /** Workflow name list */
    public const WORKFLOW_NAME_PACKAGE_REGULAR = 'package_regular';
    public const WORKFLOW_NAME_PACKAGE_DELAY = 'package_delay';
    public const WORKFLOW_NAME_PALLET_REGULAR = 'pallet_regular';
    /** Placeable name list */
    /** Packages */
    public const PACKAGE_WORKFLOW_TYPE_REGULAR = 'package_regular';
    public const PACKAGE_WORKFLOW_TYPE_DELAY = 'package_delay';
    /** Pallets */
    public const PALLET_WORKFLOW_TYPE_REGULAR = 'pallet_regular';

    public const WORKFLOW_NAME_MAP = [
        self::PACKAGE_WORKFLOW_TYPE_REGULAR => self::WORKFLOW_NAME_PACKAGE_REGULAR,
        self::PACKAGE_WORKFLOW_TYPE_DELAY => self::WORKFLOW_NAME_PACKAGE_DELAY,
        self::PALLET_WORKFLOW_TYPE_REGULAR => self::WORKFLOW_NAME_PALLET_REGULAR
    ];

    public function match(PlaceableInterface $placeable): string|null
    {
        return self::WORKFLOW_NAME_MAP[$placeable->getWorkflowType()] ?? null;
    }

}