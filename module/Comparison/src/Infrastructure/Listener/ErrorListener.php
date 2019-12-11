<?php

declare(strict_types=1);

namespace Comparison\Infrastructure\Listener;

use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\ListenerAggregateInterface;
use Zend\EventManager\ListenerAggregateTrait;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\JsonModel;

class ErrorListener implements ListenerAggregateInterface
{
    use ListenerAggregateTrait;

    public function attach(EventManagerInterface $events, $priority = 1): void
    {
        $events->attach(
            MvcEvent::EVENT_DISPATCH_ERROR,
            [$this, 'onJsonError'],
            $priority
        );

        $events->attach(
            MvcEvent::EVENT_RENDER_ERROR,
            [$this, 'onJsonError'],
            $priority
        );
    }

    public function onJsonError(MvcEvent $event): void
    {
        $exception = $event->getParam('exception');

        $event->setResult(new JsonModel([
            'status' => 'error',
            'code' => !empty($exception) ? $exception->getCode() : $event->getResponse()->getStatusCode(),
            'message' => !empty($exception) ? $exception->getMessage() : $event->getError()
        ]));
    }
}
