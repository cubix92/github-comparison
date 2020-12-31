<?php

namespace Comparison;

use Github\Client as GithubClient;
use Laminas\Router\Http\Literal;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'docs' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Infrastructure\Controller\DocumentationController::class,
                        'action' => 'display'
                    ],
                ],
            ],
            'api' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/api',
                ],
                'may_terminate' => false,
                'child_routes' => [
                    'v1' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/v1'
                        ],
                        'may_terminate' => false,
                        'child_routes' => [
                            'compare' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/compare',
                                    'defaults' => [
                                        'controller' => Infrastructure\Controller\CompareController::class,
                                        'action' => 'compare'
                                    ]
                                ],
                            ],
                            'specification' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/specification',
                                    'defaults' => [
                                        'controller' => Infrastructure\Controller\DocumentationController::class,
                                        'action' => 'specification',
                                    ],
                                ]
                            ],
                        ]
                    ]
                ]
            ]
        ],
    ],
    'controllers' => [
        'factories' => [
            Infrastructure\Controller\CompareController::class => ReflectionBasedAbstractFactory::class,
            Infrastructure\Controller\DocumentationController::class => InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            ConfigAbstractFactory::class,
        ],
        'factories' => [
            Application\Service\CompareManager::class => ReflectionBasedAbstractFactory::class,
            Infrastructure\Utils\GithubParser::class => ReflectionBasedAbstractFactory::class,
            Infrastructure\Listener\ErrorListener::class => InvokableFactory::class,
            Infrastructure\Repository\GithubRepository::class => ReflectionBasedAbstractFactory::class,
            GithubClient::class => InvokableFactory::class,
        ],
        'aliases' => [
            Domain\Repository\RepositoryInterface::class => Infrastructure\Repository\GithubRepository::class,
            Infrastructure\Utils\ParserInterface::class => Infrastructure\Utils\GithubParser::class,
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
