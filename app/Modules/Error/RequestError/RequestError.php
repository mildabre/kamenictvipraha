<?php

declare(strict_types=1);

namespace App\Modules\Error\RequestError;

use Bite\Attributes\Action;
use Bite\Exceptions\Request\ContentNotFoundException;
use Bite\Exceptions\Request\DisabledException;
use Bite\Security\Exceptions\AccessDeniedException;
use Exception;
use Nette\Application\BadRequestException;
use Nette\Application\ForbiddenRequestException;

/**
 * @property  RequestErrorTemplate $template
 */
trait RequestError
{
    public const  string TemplateFilePath = __DIR__.'/requestError.latte';

    #[Action]
    public function actionHome(
        bool $forwarded,
        int $code,
        Exception $exception,
        bool $hasIdeLink,
        ?string $ideLinkCaption,
        ?string $ideLinkHref,
        string $homeHref,
    ): void
    {
        if($forwarded){
            [$title, $message] = match($exception::class){
                BadRequestException::class => ['Not Found', 'Stránka nebyla nalezena'],
                ContentNotFoundException::class => ['Not Found', $exception->getMessage() ?: 'Stránka nebyla nalezena'],
                AccessDeniedException::class => ['Access Denied', 'Přístup zamítnut'],
                DisabledException::class => ['Disabled', 'Funkce je zablokovaná'],
                ForbiddenRequestException::class => ['Forbidden', 'Funkce je zakázaná'],
                default => ['Not Found', ''],
            };

            $this->template->exception = $exception;
            $this->template->title = $title;
            $this->template->message = $message;
            $this->template->debugMode = $this->config->debugMode;
            $this->template->ideLinkCaption = $ideLinkCaption;
            $this->template->ideLinkHref = $ideLinkHref;

        }else{
            $this->template->debugMode = false;
        }
        $this->template->forwarded = $forwarded;
        $this->template->code = $code;
        $this->template->hasIdeLink = $hasIdeLink;
        $this->template->homeHref = $homeHref;
        $this->template->setFile(self::TemplateFilePath);
        $this->template->presenterName = $this->name;
    }
}
