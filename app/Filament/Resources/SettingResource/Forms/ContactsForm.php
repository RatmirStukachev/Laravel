<?php

namespace App\Filament\Resources\SettingResource\Forms;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Mohamedsabil83\FilamentFormsTinyeditor\Components\TinyEditor;

class ContactsForm
{
    const NAME = 'Контакты';
    const ICON = 'heroicon-o-document-text';

    public static function get(): array
    {
        return [            
            Section::make('Адреса')->schema([
                // TextInput::make('company_name')
                //     ->label('Название компании'),
                TextInput::make('company_address')
                    ->label('Адрес (страница контактов)'),
                TextInput::make('company_address_pickup_header')
                    ->label('Адрес самовывоза (header)'),
                TextInput::make('company_address_pickup_footer')
                    ->label('Адрес самовывоза (footer)'),
            ])->columns(3),
            Section::make('Время работы')->schema([
                TextInput::make('work_time_header')
                    ->label('Время работы (header)'),
                TextInput::make('work_time_footer')
                    ->label('Время работы (footer)'),
            ])->columns(),
            TinyEditor::make('company_info')
                ->columnSpanFull()
                ->label('О компании (footer)'),
            TextInput::make('email')
                    ->label('Почты для получения заказов (через запятую)'),
            TextInput::make('email_callback')
                    ->label('Почты для обратной связи (через запятую)'),
            TinyEditor::make('company_creds')
                ->columnSpanFull()
                ->label('Реквизиты компании'),
            Repeater::make('contacts_phones')
                ->label('Номера телефонов')
                ->schema([                    
                    Section::make('')->schema([
                        TextInput::make('phone_name')
                            ->label('Подпись телефона'),
                        TextInput::make('phone')
                                ->label('Телефон'),
                    ])->columns(2),
                    Checkbox::make('is_main')
                        ->label('Главный телефон'),
                    Checkbox::make('is_dropdown')
                        ->label('В выпадающем списке'),
                    Checkbox::make('is_whatsapp')
                        ->label('WhatsApp'),
                    Checkbox::make('is_viber')
                        ->label('Viber'),
                    Checkbox::make('is_telegram')
                        ->label('Telegram'),
                ])->createItemButtonLabel('Добавить телефон'),
            Repeater::make('contacts_emails')
                ->label('Email для контактов')
                ->schema([
                    TextInput::make('email')
                        ->label('Email'),
                    Checkbox::make('is_main')
                        ->label('Главный email'),
                ])->createItemButtonLabel('Добавить eamil'),
            Section::make('Социальные сети')->schema([
                TextInput::make('instagram')
                    ->autofocus()
                    ->label('Instagram'),
            ])->columns(3),
            Section::make('Карта')->schema([
                TextInput::make('coords')
                    ->autofocus()
                    ->label('Координаты (широта, долгота)'),
                TextInput::make('coords_name')
                    ->autofocus()
                    ->label('Адрес (на карте)'),
            ])->columns(3),
        ];
    }
}
