<?php

declare(strict_types=1);

namespace App\Modules\Error\RequestError;

use Bite\DI\Config;
use Bite\Exceptions\Request\ContentNotFoundException;
use Bite\Exceptions\Request\FeatureDisabledException;
use Bite\Security\Exceptions\AccessDeniedException;
use Nette\Application\IPresenter;
use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\Responses;

final class RequestErrorPresenter implements IPresenter
{
    use DebugPanelData;

    private const string HomeLink = ':Front:Content:article';
    private const string ErrorPresenter = 'Error:FrontError';

    public function __construct(private readonly Config $config)
    {}

    public function run(Request $request): Response
    {
        $exception = $request->getParameter('exception');
        $errorType = $exception->getCode() === 403 ? 'ForbiddenType' : 'NotFoundType';
        $title = $message = '';

        if ($errorType === 'NotFoundType') {
            [$title, $message] = match ($exception::class) {
                ContentNotFoundException::class => ['Not Found', $exception->getMessage() ?: 'Stránka nebyla nalezena'],
                FeatureDisabledException::class => ['Disabled', 'Funkce je zablokovaná'],
                default => ['Not Found', 'Stránka nebyla nalezena'],
            };
        }

        if ($errorType === 'ForbiddenType') {
            [$title, $message] = match ($exception::class) {
                AccessDeniedException::class => ['Access Denied', 'Přístup zamítnut'],
                default => ['Forbidden', 'Přístup zamítnut'],
            };
        }

        [$printIdeLink, $ideHref, $ideCaption, $classShortName] = $this->getDebugPanelData($request);

        $parameters = [
            'action' => 'home',
            'title' => $title,
            'message' => $message,
            'classShortName' => $classShortName,
            'printIdeLink' => $printIdeLink,
            'ideCaption' => $ideCaption,
            'ideHref' => $ideHref,
            'homeHref' => self::HomeLink,
        ];

        $request->setParameters($parameters);
        $request->setPresenterName(self::ErrorPresenter);

        return new Responses\ForwardResponse($request);
    }
}