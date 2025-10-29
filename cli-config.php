<?php
print_r("require");

require __DIR__ . '/michael_ch/core/src/implementation/cli_requirement.php';

use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\Migrations\DependencyFactory;


$config = new PhpFile('migrations.php');

$entityManager = doctrine();
return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));

