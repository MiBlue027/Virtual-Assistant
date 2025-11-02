<?php

namespace Database\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "ref_doc")]
class RefDoc
{
    #region PROPERTIES
    #[Id]
    #[Column(name: "REF_DOC_ID", type: Types::BIGINT, nullable: false), GeneratedValue()]
    private int $refDocId;
    #[Column(name: "DOC_NAME", type: Types::STRING, length: 150, nullable: false)]
    private string $docName;
    #[Column(name: "DOC_TYPE", type: Types::STRING, nullable: false)]
    private string $docType;
    #[Column(name: "DOC_STAT", type: Types::STRING, length: 5, nullable: false)]
    private string $docStat;
    #[Column(name: "DOC_PATH", type: Types::STRING, length: 150, nullable: false)]
    private string $docPath;
    #endregion

    #region RELATION
    public function __construct()
    {
        $this->docStat = "ACT";
    }
    #endregion

    #region GETTER_SETTER
    public function getRefDocId(): int
    {
        return $this->refDocId;
    }

    public function getDocName(): string
    {
        return $this->docName;
    }

    public function setDocName(string $docName): void
    {
        $this->docName = $docName;
    }

    public function getDocType(): string
    {
        return $this->docType;
    }

    public function setDocType(string $docType): void
    {
        $this->docType = $docType;
    }

    public function getDocStat(): string
    {
        return $this->docStat;
    }

    public function setDocStat(string $docStat): void
    {
        $this->docStat = $docStat;
    }

    public function getDocPath(): string
    {
        return $this->docPath;
    }

    public function setDocPath(string $docPath): void
    {
        $this->docPath = $docPath;
    }
    #endregion
}