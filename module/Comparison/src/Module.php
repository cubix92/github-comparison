<?php

namespace Comparison;

use Comparison\Infrastructure\Listener\ErrorListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $event)
    {
        $serviceManager = $event->getApplication()->getServiceManager();
        $eventManager = $event->getTarget()->getEventManager();

        $errorListener = $serviceManager->get(ErrorListener::class);
        $errorListener->attach($eventManager);
    }
}
