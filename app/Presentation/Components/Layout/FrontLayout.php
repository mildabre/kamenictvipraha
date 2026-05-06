<?php

declare(strict_types=1);

namespace App\Presentation\Components\Layout;

use App\Presentation\Components\Controls\FrontMenu;
use App\Presentation\Components\Layout\Types\FrontLayoutTemplate;
use Bite\Presenter\AbstractPresenter;

/**
 * @mixin AbstractPresenter
 * @property-read FrontLayoutTemplate $template
 */
trait FrontLayout
{
    final public function injectFrontLayout(): void
    {
        $this->setLayout('front.layout.latte');
        $this->onRender[] = function() {
            $this->template->isProductionServer = $this->config->isProductionServer;
            if ($this->getComponent('FrontMenu', false) === null) {                 // fallback in error presenter
                $this->attach(new FrontMenu()->setSid(null));
            }
        };
    }
}