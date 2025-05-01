<?php

namespace App\Filament\Admin\Resources\MemberResource\Pages;

use App\Filament\Admin\Resources\MemberResource;
use Filament\Resources\Pages\Page;
use Livewire\Attributes\Layout;

#[Layout('filament-panels::components.layout.base')]
class MemberScanner extends Page
{
    protected static string $resource = MemberResource::class;

    protected static string $view = 'livewire.member-scanner';

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationLabel = 'QR Scanner';

    protected static ?int $navigationSort = 2;
} 