<?php

declare(strict_types=1);

namespace App\Layout\Presenter;

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
        $this->onRender[] = fn()  => $this->template->isProductionServer = $this->config->isProductionServer;
    }
}