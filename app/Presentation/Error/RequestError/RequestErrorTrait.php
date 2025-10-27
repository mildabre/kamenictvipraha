<?php

declare(strict_types=1);

namespace App\Presentation\Error\RequestError;

use App\Layout\Presenter\BasePresenter;
use Bite\Attributes\Action;
use Nette\Application\BadRequestException;

/**
 * @mixin BasePresenter
 * @property-read  RequestErrorTemplate $template
 */
trait RequestErrorTrait
{
    public const  string TemplateFilePath = __DIR__.'/templates/requestError.latte';

    public function injectRequestError(): void
    {
        $this->onStartup[] = function() {
            $forwarded = $this->getRequest()->isMethod('FORWARD');
            if (!$forwarded) {
                throw new BadRequestException();                        // exclude direct http access
            }
        };
    }

    #[Action]
    public function actionHome(string $title, string $message, string $classShortName, bool $printIdeLink, ?string $ideCaption, ?string $ideHref, string $homeHref): void
    {
        $this->template->setFile(self::TemplateFilePath);

        $this->template->title = $title;
        $this->template->message = $message;
        $this->template->classShortName = $classShortName;
        $this->template->layoutFileName = $this->getLayout();
        $this->template->homeHref = $homeHref;

        $this->template->printIdeLink = $printIdeLink;
        $this->template->ideCaption = $ideCaption;
        $this->template->ideHref = $ideHref;
    }
}