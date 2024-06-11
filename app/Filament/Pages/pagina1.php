<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class pagina1 extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.pagina1';

    protected static ?string $navigationGroup = 'BIENES';

    protected static ?int $navigationSort = 1; 

}
