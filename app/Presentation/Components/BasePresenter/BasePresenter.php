<?php

declare(strict_types=1);

namespace app\Presentation\Components\BasePresenter;

use Bite\Presenter\AbstractPresenter;
use Bite\Presenter\Traits\Base\BaseCanonization;

abstract class BasePresenter extends AbstractPresenter
{
    use BaseCanonization;
}