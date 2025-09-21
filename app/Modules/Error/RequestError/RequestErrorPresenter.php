<?php

declare(strict_types=1);

namespace App\Modules\Error\RequestError;

use Bite\DI\Config;
use Bite\Presenter\AbstractPresenter;
use Bite\Support\Tools;
use Nette\Application\IPresenter;
use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\Responses;
use ReflectionClass;
use ReflectionException;

final class RequestErrorPresenter implements IPresenter
{
    private const string FrontModule = 'Front';
    private const string ErrorModule = 'Error';
    private const string HomeAction = 'Content:article';

    public function __construct(private readonly Config $config)
    {}

    public function run(Request $request): Response
    {
        $exception = $request->getParameter('exception');
        $code = match($exception->getCode()){
            500, 403 => $exception->getCode(),
            default => 404
        };

        /**
         * @var AbstractPresenter|null $previousPresenter
         */
        $previousPresenter = $request->getParameter('previousPresenter');
        $module = $previousPresenter?->module ?? self::FrontModule;
        $homeModule = $code === 403 ? self::FrontModule : $module;
        $homeHref = ":$homeModule:".self::HomeAction;

        [$hasLink, $href, $caption] = $this->getIdeLink($previousPresenter);

        $parameters = [
            'forwarded' => true,
            'action' => 'home',
            'code' => $code,
            'exception' => $exception,
            'hasIdeLink' => $hasLink,
            'ideLinkCaption' => $caption,
            'ideLinkHref' => $href,
            'homeHref' => $homeHref,
            'previousPresenter' => $previousPresenter,
            'previousModule' => $module,
        ];

        $request->setParameters($parameters);
        $forwardedPresenterName = self::ErrorModule.':'.$module.AbstractPresenter::RequestErrorSuffix;
        $request->setPresenterName($forwardedPresenterName);

        return new Responses\ForwardResponse($request);
    }

    private function getIdeLink(?AbstractPresenter $presenter): array
    {
        $hasLink = (bool) $presenter;
        $caption = '';
        $href = '';

        if($hasLink){
            try{
                $rc = new ReflectionClass($presenter);
                $file = $rc->getFileName();
                $caption = Tools::stripBasePath($file, $this->config->appDir);
                $href = '//open/?file='.urlencode($file).'&line=1';

            }catch(ReflectionException){
                $hasLink = false;
            }
        }

        return [$hasLink, $href, $caption];
    }
}
