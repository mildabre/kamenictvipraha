<?php

declare(strict_types=1);

namespace App\Modules\Error\RequestError;

use Bite\DI\Config;
use Bite\Exceptions\Request\ContentNotFoundException;
use Bite\Exceptions\Request\FeatureDisabledException;
use Bite\Security\Exceptions\AccessDeniedException;
use Bite\Support\Tools;
use Nette\Application\IPresenter;
use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\Responses;
use Nette\Http;

final class RequestErrorPresenter implements IPresenter
{
    use DebugPanelData;

    private const string FrontModule = 'Front';
    private const string ErrorModule = 'Error';
    private const string HomeAction = 'Home:home';
    private const string ErrorPresenterSuffix = 'Error';

    public function __construct(private readonly Config $config)
    {}

    public function run(Request $request): Response
    {
        $currentModule = self::FrontModule;

        $exception = $request->getParameter('exception');
        $errorType = $exception->getCode() === 403 ? 'ForbiddenType' : 'NotFoundType';
        $title = $message = $homeHref = '';

        if ($errorType === 'NotFoundType') {
            [$title, $message] = match ($exception::class) {
                ContentNotFoundException::class => ['Not Found', $exception->getMessage() ?: 'Stránka nebyla nalezena'],
                FeatureDisabledException::class => ['Disabled', 'Funkce je zablokovaná'],
                default => ['Not Found', 'Stránka nebyla nalezena'],
            };
            $homeHref = ':' . $currentModule . ':' . self::HomeAction;
        }

        if ($errorType === 'ForbiddenType') {
            [$title, $message] = match ($exception::class) {
                AccessDeniedException::class => ['Access Denied', 'Přístup zamítnut'],
                default => ['Forbidden', 'Přístup zamítnut'],
            };
            $homeHref = ':' . self::FrontModule . ':' . self::HomeAction;
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
            'homeHref' => $homeHref,
        ];

        $errorPresenterName = self::ErrorModule.':'.$currentModule.self::ErrorPresenterSuffix;

        $request->setParameters($parameters);
        $request->setPresenterName($errorPresenterName);

        return new Responses\ForwardResponse($request);
    }
}