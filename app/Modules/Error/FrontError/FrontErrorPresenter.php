<?php

declare(strict_types=1);

namespace App\Modules\Error\FrontError;

use App\Layout\Presenter\FrontLayout;
use App\Modules\Error\RequestError\RequestErrorTrait;
use Bite\Attributes\Error;
use Bite\Presenter\AbstractPresenter;

#[Error]
final class FrontErrorPresenter extends AbstractPresenter
{
    use FrontLayout;
    use RequestErrorTrait;
}