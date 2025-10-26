<?php

declare(strict_types=1);

namespace App\Layout\Components;

use Bite\Components\UI\Menu\ToggleMenu;

final class FrontMenu extends ToggleMenu
{
    protected const array MenuItems = [
        '@home' => 'Úvod',
        'sochy-kamenicke-prvky' => 'Sochy a kamenické prvky',
        'kamenne-nahrobky' => 'Kamenné náhrobky',
        'sekani-pisma' => 'Sekání písma',
        'gravirovani-motivu' => 'Gravírování motivů',
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