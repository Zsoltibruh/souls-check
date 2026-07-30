<?php

declare(strict_types=1);

namespace App\UseCase\Shared;

use App\Presentation\ResponseFactory\ResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Yiisoft\FormModel\FormModel;

/**
 * If you use this trait in another class you still need to add ResponseFactory inside the constructor!
 * 
 * Add the renderForm method to the class, which renders the form given inside the $form variable.
 * @property-read ResponseFactory $responseFactory
 * @method ResponseInterface renderForm(FormModel $form, string $path)
 */
trait HasForm
{
    private function renderForm(FormModel $form, string $path): ResponseInterface
    {
        return $this->responseFactory->render(
            $path,
            ['form' => $form],
        );
    }
}
