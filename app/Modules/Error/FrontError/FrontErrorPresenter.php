<?php

declare(strict_types=1);

namespace App\Modules\Error\FrontError;

use App\Layout\Presenter\FrontLayout;
use App\Layout\Presenter\Types\FrontLayoutTemplate;
use App\Modules\Error\RequestError\RequestError;
use App\Modules\Error\RequestError\RequestErrorTemplate;
use Bite\Attributes\Error;
use Bite\Presenter\AbstractPresenter;
use Bite\Presenter\Traits\BaseCanonization;

/**
 * @property  RequestErrorTemplate|FrontLayoutTemplate $template
 */
#[Error]
final class FrontErrorPresenter extends AbstractPresenter
{
    use RequestError;
    use BaseCanonization;
    use FrontLayout;
}
