<?php

namespace App\Filament\Pages;

use App\Services\AiService;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class AiStudio extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static string $view = 'filament.pages.ai-studio';

    protected static ?string $navigationGroup = 'AI';

    protected static ?string $title = 'AI Studio';

    protected static ?string $navigationLabel = 'AI Generators';

    public ?array $data = [];

    public ?string $output = null;

    public function mount(): void
    {
        $this->form->fill([
            'type' => 'blog',
            'prompt' => 'Benefits of proper well development for Northeast Oklahoma domestic wells',
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')->options([
                    'blog' => 'Blog / content generator',
                    'description' => 'Service / product description',
                    'automation' => 'Automation suggestions',
                    'troubleshoot' => 'Operations troubleshooting',
                ])->required(),
                Forms\Components\Textarea::make('prompt')->required()->rows(4)->columnSpanFull(),
            ])
            ->statePath('data')
            ->columns(1);
    }

    public function generate(AiService $ai): void
    {
        $state = $this->form->getState();
        $this->output = $ai->generate($state['type'], $state['prompt']);
        Notification::make()->title('AI response ready')->success()->send();
    }
}
