<?php

declare(strict_types=1);

namespace App\Layout\Presenter;

use App\Layout\Components\FrontMenu;
use App\Layout\Presenter\Types\FrontLayoutTemplate;

/**
 * @property FrontLayoutTemplate $template
 */
trait FrontLayout
{
    final public function injectFrontLayout(): void
    {
        $this->onStartup[] = fn() => $this->add(new FrontMenu()->setSid(null));
        $this->onRender[] = fn() => $this->template->isProductionServer = $this->config->isProductionServer;
        $this->onRender[] = fn() => $this->setLayout('front.layout.latte');
    }
}