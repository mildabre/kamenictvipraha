<?php

declare(strict_types=1);

namespace App\Presentation\Components\BasePresenter;

use Bite\Presenter\AbstractPresenter;
use Bite\Presenter\Traits\Base\BaseCanonization;
use Bite\Presenter\Traits\Base\LatteFunctions;

abstract class BasePresenter extends AbstractPresenter
{
    use BaseCanonization;
    use LatteFunctions;
}