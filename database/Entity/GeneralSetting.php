<?php

namespace Database\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "general_setting")]
class GeneralSetting
{
    #region PROPERTIES
    #[Id]
    #[Column(name: "GENERAL_SETTING_ID", type: Types::BIGINT, nullable: false), GeneratedValue()]
    private int $generalSettingId;
    #[Column(name: "GS_NAME", type: Types::STRING, length: 150, nullable: false)]
    private string $gsName;
    #[Column(name: "GS_CODE", type: Types::STRING, length: 15, nullable: false)]
    private string $gsCode;
    #[Column(name: "GS_VALUE", type: Types::STRING, length: 500, nullable: false)]
    private string $gsValue;
    #endregion

    #region RELATION
    public function __construct()
    {
    }
    #endregion

    #region GETTER_SETTER
    public function getGeneralSettingId(): int
    {
        return $this->generalSettingId;
    }

    public function getGsName(): string
    {
        return $this->gsName;
    }

    public function setGsName(string $gsName): void
    {
        $this->gsName = $gsName;
    }

    public function getGsCode(): string
    {
        return $this->gsCode;
    }

    public function setGsCode(string $gsCode): void
    {
        $this->gsCode = $gsCode;
    }

    public function getGsValue(): string
    {
        return $this->gsValue;
    }

    public function setGsValue(string $gsValue): void
    {
        $this->gsValue = $gsValue;
    }
    #endregion
}