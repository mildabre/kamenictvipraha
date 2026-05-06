<?php

declare(strict_types=1);

namespace App\Presentation\Front\Content;

use App\Presentation\Components\BasePresenter\BasePresenter;
use App\Presentation\Components\Controls\FrontMenu;
use App\Presentation\Components\Layout\FrontLayout;
use Bite\Exceptions\Http\ContentNotFoundException;
use Bite\Presenter\Http\Route;
use Nette\Application\Attributes\Parameter;

final class ContentPresenter extends BasePresenter
{
    use FrontLayout;

    #[Parameter]
    public ?string $sid = null;

    #[Route]
    public function actionArticle(): void
    {
        $frontMenu = new FrontMenu()->setSid($this->sid);
        $this->attach($frontMenu);

        $key = $frontMenu->getCurrentKey();
        $file = __DIR__ . "/templates/pages/$key.latte";

        if (!is_file($file)) {
            throw new ContentNotFoundException();
        }

        $this->template->setFile($file);
        $this->template->imagePath = $this->config->basePath.'/site/photo';
    }
}