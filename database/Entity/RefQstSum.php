<?php

namespace Database\Entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: "ref_qst_sum")]
class RefQstSum
{
    #region PROPERTIES
    #[Id]
    #[Column(name: "REF_QST_SUM_ID", type: Types::BIGINT, nullable: false), GeneratedValue()]
    private int $refQstSumId;
    #[Column(name: "QUESTION", type: Types::STRING, length: 5000, nullable: false)]
    private string $question;
    #[Column(name: "QTY", type: Types::INTEGER, nullable: false)]
    private int $qty;
    #[Column(name: "IS_NTF", type: Types::BOOLEAN, nullable: false)]
    private bool $isNTF;
    #[Column(name: "QST_DT", type: Types::DATETIME_MUTABLE, nullable: false)]
    private \DateTimeInterface $qstDt;
    #endregion

    #region RELATION
    public function __construct()
    {
        $this->qty = 1;
        $this->isNTF = false;
        $this->qstDt = new \DateTime();
    }


    #endregion

    #region GETTER SETTER
    public function getRefQstSumId(): int
    {
        return $this->refQstSumId;
    }

    public function getQuestion(): string
    {
        return $this->question;
    }

    public function setQuestion(string $question): void
    {
        $this->question = $question;
    }

    public function getQty(): int
    {
        return $this->qty;
    }

    public function setQty(int $qty): void
    {
        $this->qty = $qty;
    }

    public function isNTF(): bool
    {
        return $this->isNTF;
    }

    public function setIsNTF(bool $isNTF): void
    {
        $this->isNTF = $isNTF;
    }

    public function getQstDt(): \DateTimeInterface
    {
        return $this->qstDt;
    }

    public function setQstDt(\DateTimeInterface $qstDt): void
    {
        $this->qstDt = $qstDt;
    }

    #endregion
}