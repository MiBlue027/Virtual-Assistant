<?php

namespace Database\Repository\AppRepository\AdminRepository;

use Doctrine\ORM\EntityManager;

class UserRegisterRepository
{
    private EntityManager $entityManager;
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}