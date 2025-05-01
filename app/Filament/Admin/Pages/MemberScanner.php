<?php

namespace App\Filament\Admin\Pages;

use App\Livewire\MemberScanner as MemberScannerComponent;
use Filament\Pages\Page;
use Livewire\Attributes\Layout;

#[Layout('filament-panels::components.layout.base')]
class MemberScanner extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $navigationLabel = 'Member Scanner';

    protected static ?string $navigationGroup = 'Member Management';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.member-scanner';

    public function getTitle(): string
    {
        return 'Member QR Scanner';
    }

    public function mount()
    {
        $this->component = MemberScannerComponent::class;
    }
} 