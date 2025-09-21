<?php

declare(strict_types=1);

namespace App\Layout\Components;

use Bite\Components\UI\Menu\FrontModuleMenu;

final class FrontMenu extends FrontModuleMenu
{
    protected const array MenuItems = [
        '@home' => 'Úvod',
        'pismo' => 'Sekání a obnova písma',
        'gravirovani' => 'Gravírování portrétů a motivů',
        'nahrobky' => 'Kamenné náhrobky',
        '@home#provozovna' => 'Provozovna',
        '#kontakt' => 'Kontakt',
    ];

    public function getCurrentKey(): ?string
    {
        if($this->presenter->name === 'Front:Content'){
            return $this->sid ?? self::HomeKey;

        }else{
            return null;
        }
    }
}