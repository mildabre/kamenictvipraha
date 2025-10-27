<?php

declare(strict_types=1);

namespace App\Presentation\Error\ServerError;

use App\Presentation\Error\RequestError\DebugPanelData;
use Bite\DI\Config;
use Nette\Application\IPresenter;
use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\Responses\CallbackResponse;
use Nette\Http\IRequest;
use Nette\Http\IResponse;
use Tracy\ILogger;

final class ServerErrorPresenter implements IPresenter
{
    use DebugPanelData;

    public const string TemplateFilePath = __DIR__.'/templates/serverErrorPage.php';

    public function __construct(private readonly ILogger $logger, private readonly Config $config)
    {}

    public function run(Request $request): Response
    {
        $exception = $request->getParameter('exception');
        $this->logger->log($exception, ILogger::EXCEPTION);

        $renderErrorPage = function(IRequest $httpRequest, IResponse $httpResponse) use ($request): void {
            $isHtmlResponse = preg_match('#^text/html(?:;|$)#', (string) $httpResponse->getHeader('Content-Type'));
            if ($isHtmlResponse) {
                $debugMode = $this->config->debugMode;
                $basePath = $this->config->basePath;
                [$printLink, $href, $caption, $classShortName, $message] = $this->getDebugPanelData($request);
                require self::TemplateFilePath;
            }
        };

        return new CallbackResponse($renderErrorPage);
    }
}