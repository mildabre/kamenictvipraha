<?php

declare(strict_types=1);

namespace App\Modules\Error\ServerError;

use Bite\DI\Config;
use Bite\Support\Tools;
use Nette\Application\IPresenter;
use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\Responses\CallbackResponse;
use Nette\Http\IRequest;
use Nette\Http\IResponse;
use Tracy\ILogger;

final class ServerErrorPresenter implements IPresenter
{
    public function __construct(
        private readonly ILogger $logger,
        private readonly Config $config,
    )
    {}

    public function run(Request $request): Response
    {
        $exception = $request->getParameter('exception');
        $this->logger->log($exception, ILogger::EXCEPTION);
        return new CallbackResponse(function(IRequest $httpRequest, IResponse $httpResponse) use($exception): void {
            if(preg_match('#^text/html(?:;|$)#', (string) $httpResponse->getHeader('Content-Type'))){
                $debugMode = $this->config->debugMode;
                $exceptionClass = $exception::class;
                $exceptionMessage = $exception->getMessage();

                $file = Tools::stripBasePath($exception->getFile(), $this->config->appDir);
                $href = '//open/?file='.urlencode($exception->getFile()).'&line='.$exception->getLine();

                require __DIR__.'/serverError.php';
            }
        });
    }
}
