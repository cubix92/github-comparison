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
                        'controller' => Presentation\Controller\DocumentationController::class,
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
                                        'controller' => Presentation\Controller\CompareController::class,
                                        'action' => 'compare'
                                    ]
                                ],
                            ],
                            'specification' => [
                                'type' => Literal::class,
                                'options' => [
                                    'route' => '/specification',
                                    'defaults' => [
                                        'controller' => Presentation\Controller\DocumentationController::class,
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
            Presentation\Controller\CompareController::class => ReflectionBasedAbstractFactory::class,
            Presentation\Controller\DocumentationController::class => InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            ConfigAbstractFactory::class,
        ],
        'factories' => [
            Application\Hydrator\RepositoryHydrator::class => InvokableFactory::class,
            Application\Service\CompareManager::class => ReflectionBasedAbstractFactory::class,
            Application\Service\GithubParser::class => ReflectionBasedAbstractFactory::class,
            Infrastructure\Listener\ErrorListener::class => InvokableFactory::class,
            Infrastructure\Repository\GithubRepository::class => ReflectionBasedAbstractFactory::class,
            GithubClient::class => InvokableFactory::class,
        ],
        'aliases' => [
            Domain\Repository\RepositoryInterface::class => Infrastructure\Repository\GithubRepository::class,
            Application\Hydrator\RepositoryHydratorInterface::class => Application\Hydrator\RepositoryHydrator::class,
            Application\Service\CompareInterface::class => Application\Service\CompareManager::class,
            Application\Service\ParserInterface::class => Application\Service\GithubParser::class,
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
