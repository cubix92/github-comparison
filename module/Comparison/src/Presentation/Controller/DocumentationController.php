<?php

declare(strict_types=1);

namespace Comparison\Presentation\Controller;

use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use function Swagger\scan;

class DocumentationController extends AbstractActionController
{
    public function displayAction(): ViewModel
    {
        return (new ViewModel)->setTerminal(true);
    }

    public function specificationAction(): JsonModel
    {
        $swaggerJson = JSON::decode(scan('module'), JSON::TYPE_ARRAY);

        return new JsonModel($swaggerJson);
    }
}
