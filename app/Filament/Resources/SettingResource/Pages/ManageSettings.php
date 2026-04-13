<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Filament\Forms\Form;
use Filament\Actions\Action;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

/**
Это стандартный шаблон view настроек
 * */
/*

<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        <x-filament-panels::form.actions
            :actions="$this->getFormActions()"
        />
        {{ $this->form }}
        <x-filament-panels::form.actions
            :actions="$this->getFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page>

 * */
class ManageSettings extends Page implements HasForms
{
    protected static string $resource = SettingResource::class;

    protected static string $view = 'filament.manage-settings';
    protected static ?string $title = 'Настройки';

    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public function mount(): void
    {
        $settings = Setting::all()
            ->pluck('data_val', 'data_key')
            ->toArray();
        $this->form->fill($settings);
    }

    public function form(Form $form): Form
    {
        $tabs = [];
        $formsPath = app_path('Filament/Resources/SettingResource/Forms');
        foreach (File::files($formsPath) as $file) {
            $baseName = $file->getFilenameWithoutExtension();

            if (!str_ends_with($baseName, 'Form')) {
                continue;
            }

            $className = 'App\\Filament\\Resources\\SettingResource\\Forms\\' . $baseName;
            $tabName = substr($baseName, 0, -4);
            $tabLabel = lcfirst($tabName); // Приводим к нижнему регистру
            $tabs[] = Tab::make($className::NAME)
                ->schema($className::get())
                ->icon($className::ICON)
                ->statePath($tabLabel);
        }

        return $form
            ->schema([
                Tabs::make('Settings')
                    ->tabs($tabs)
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
            foreach ($data as $key => $value) {
                Setting::updateOrCreate(
                    ['data_key' => $key],
                    ['data_val' => $value]
                );
            }
        } catch (\Exception $exception) {
            Log::error($exception);
            return;
        }
        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }

}
