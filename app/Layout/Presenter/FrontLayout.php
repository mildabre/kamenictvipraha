<?php

declare(strict_types=1);

namespace App\Layout\Presenter;

use App\Layout\Components\FrontMenu;
use App\Layout\Presenter\Types\FrontLayoutTemplate;
use Bite\Presenter\AbstractPresenter;
use Bite\Presenter\Traits\Base\BaseCanonization;

/**
 * @mixin AbstractPresenter
 * @property-read FrontLayoutTemplate $template
 */
trait FrontLayout
{
    use BaseCanonization;

    final public function injectFrontLayout(): void
    {
        $this->setLayout('front.layout.latte');
        $this->onRender[] = function() {
            $this->template->isProductionServer = $this->config->isProductionServer;
            if ($this->getComponent('frontMenu', false) === null) {                 // fallback in error presenter
                $this->add(new FrontMenu()->setSid(null));
            }
        };
    }
}