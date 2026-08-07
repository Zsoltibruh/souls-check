<?php

declare(strict_types=1);

namespace App\UseCase\Shared;

use App\Presentation\ResponseFactory\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\FormModel\FormModel;

/**
 * If you use this trait in another class you still need to add ResponseFactory inside the constructor!
 * 
 * renderSingleForm: renders a single form based on the $form argument inside the $path, 
 * the $key is optional for the name of the $form variable inside the view
 * 
 * renderForm: handles the rendering
 * @property-read ResponseFactory $responseFactory
 * @method ResponseInterface renderForm(FormModel $form, string $path)
 */
trait HasForm
{
    private function renderForm(array $forms, string $path): ResponseInterface
    {
        return $this->responseFactory->render($path, $forms);
    }

    private function renderSingleForm(FormModel $form, string $path, string $key = 'form'): ResponseInterface
    {
        return $this->renderForm([$key => $form], $path);
    }
}
