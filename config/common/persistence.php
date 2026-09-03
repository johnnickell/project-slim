<?php

declare(strict_types=1);

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Tools\DsnParser;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Fight\Common\Adapter\Persistence\Doctrine\DoctrineTransactionalUnitOfWork;
use Fight\Common\Application\Repository\TransactionalUnitOfWork;
use Fight\Common\Application\Service\Container;

return static function (Container $container): void {
    $container->set(Connection::class, static fn (Container $c): Connection => DriverManager::getConnection((new DsnParser(['sqlite' => 'pdo_sqlite']))->parse($c['app.database_url'])));
    $container->set(EntityManagerInterface::class, static function (Container $c): EntityManagerInterface {
        $configuration = ORMSetup::createAttributeMetadataConfiguration([], true);
        $configuration->enableNativeLazyObjects(true);

        return new EntityManager($c->get(Connection::class), $configuration);
    });
    $container->set(TransactionalUnitOfWork::class, static fn (Container $c): TransactionalUnitOfWork => new DoctrineTransactionalUnitOfWork($c->get(EntityManagerInterface::class)));
};
