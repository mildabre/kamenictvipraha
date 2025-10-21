<?php

declare(strict_types=1);

namespace App\Layout\Presenter;

use App\Layout\Presenter\Types\FrontLayoutTemplate;
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
        };
    }
}