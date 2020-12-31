<?php

declare(strict_types=1);

namespace ComparisonTest\Features\Bootstrap;

use Comparison\Infrastructure\Controller\CompareController;
use Noiselabs\Behat\ZfTestCaseExtension\Context\ZfTestCaseAwareContext;
use Noiselabs\Behat\ZfTestCaseExtension\TestCase\HttpControllerTestCase;

/**
 * Defines application features from the specific context.
 */
class CompareContext implements ZfTestCaseAwareContext
{
    /**
     * @var string $compare;
     */
    protected $compare;

    protected $to;

    /**
     * @var HttpControllerTestCase
     */
    private $testCase;

    public function setTestCase(HttpControllerTestCase $testCase)
    {
        $this->testCase = $testCase;
    }

    /**
     * @Given there is a repository :repository
     */
    public function thereIsARepository(string $repository): void
    {
        $this->compare = $repository;
    }

    /**
     * @Given there is another repository :repository
     */
    public function thereIsAnotherRepository(string $repository): void
    {
        $this->to = $repository;
    }

    /**
     * @When I compare them
     */
    public function iCompareThem(): void
    {
        $params = [
            'compare' => $this->compare,
            'to' => $this->to
        ];

        $this->testCase->dispatch('/api/v1/compare', 'GET', $params);
    }

    /**
     * @Then the result should be correct
     */
    public function theResultShouldBeCorrect(): void
    {
        $this->testCase->assertResponseStatusCode(200);
        $this->testCase->assertModuleName('Comparison');
        $this->testCase->assertControllerName(CompareController::class);
        $this->testCase->assertControllerClass('CompareController');
        $this->testCase->assertMatchedRouteName('api/v1/compare');
    }
}
