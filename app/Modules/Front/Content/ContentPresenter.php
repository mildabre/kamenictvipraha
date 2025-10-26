<?php

declare(strict_types=1);

namespace App\Modules\Front\Content;

use App\Layout\Components\FrontMenu;
use App\Layout\Presenter\FrontLayout;
use App\Layout\Presenter\Types\FrontLayoutTemplate;
use Bite\Exceptions\Request\ContentNotFoundException;
use Bite\Presenter\AbstractPresenter;
use Nette\Application\Attributes\Parameter;

/**
 * @property FrontLayoutTemplate $template
 */
class ContentPresenter extends AbstractPresenter
{
    use FrontLayout;

    #[Parameter]
    public ?string $sid = null;

    public function __construct()
    {}

    public function actionArticle(): void
    {
        $frontMenu = new FrontMenu()->setSid($this->sid);
        $this->add($frontMenu);

        $key = $frontMenu->getCurrentKey();
        $file = __DIR__."/templates/pages/$key.latte";

        if (!is_file($file)) {
            throw new ContentNotFoundException();
        }

        $this->template->setFile($file);
        $this->template->imagePath = $this->config->basePath.'/site/photo';
    }
}