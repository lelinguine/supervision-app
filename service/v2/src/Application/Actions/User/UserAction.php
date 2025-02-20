<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;

abstract class UserAction extends Action
{
    protected ContainerInterface $container;

    public function __construct(LoggerInterface $logger, ContainerInterface $container)
    {
        parent::__construct($logger);
        $this->container = $container;
    }
}
