<?php

declare(strict_types=1);

namespace App\Presentation\Error\FrontError;

use App\Presentation\Components\Layout\FrontLayout;
use App\Presentation\Error\RequestError\RequestErrorTrait;
use Bite\Presenter\Attributes\Error;
use Bite\Presenter\AbstractPresenter;

#[Error]
final class FrontErrorPresenter extends AbstractPresenter
{
    use FrontLayout;
    use RequestErrorTrait;
}