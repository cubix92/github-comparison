<?php

declare(strict_types=1);

namespace ComparisonTest\Presentation\Controller;

use Comparison\Presentation\Controller\DocumentationController;
use Laminas\Mvc\Controller\AbstractController;
use Laminas\Stdlib\ArrayUtils;
use Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class SwaggerControllerTest extends AbstractHttpControllerTestCase
{
    protected function setUp(): void
    {
        $configOverrides = [];

        $this->setApplicationConfig(ArrayUtils::merge(
            include __DIR__ . '/../../../../../config/application.config.php',
            $configOverrides
        ));

        parent::setUp();

        $sharedManager = $this->getApplication()->getEventManager()->getSharedManager();
        $sharedManager->clearListeners(AbstractController::class);
    }

    public function testDocumentationCanBeAccessed()
    {
        $this->dispatch('/');

        $this->assertResponseStatusCode(200);
        $this->assertModuleName('Comparison');
        $this->assertControllerName(DocumentationController::class);
        $this->assertControllerClass('DocumentationController');
        $this->assertMatchedRouteName('docs');
    }
}
