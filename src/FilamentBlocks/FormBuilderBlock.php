<?php

namespace SOSEventsBV\CrownCms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Support\Icons\Heroicon;

class FormBuilderBlock
{
    public static function make(): Block
    {
        return Block::make('form_builder_block')
            ->label('Formulier maker')
            ->icon(Heroicon::Bars4)
            ->schema([
                Builder::make('form_inputs')
                    ->label('Formulier inputs')
                    ->schema([
                        // Normal text input
                        Block::make('text_input')
                            ->label('Tekstveld')
                            ->icon(Heroicon::Minus)
                            ->schema([
                                TextInput::make('label')->label('Label')->required(),
                                TextInput::make('placeholder')->label('Placeholder'),
                                Toggle::make('required')->label('Verplicht')->default(true)->inline(false),
                            ])->columns(2),

                        // Text input for email
                        Block::make('email_input')
                            ->label('E-mailveld')
                            ->icon(Heroicon::Envelope)
                            ->schema([
                                TextInput::make('label')->label('Label')->required(),
                                TextInput::make('placeholder')->label('Placeholder'),
                                Toggle::make('required')->label('Verplicht')->default(true)->inline(false),
                            ])->columns(2),

                        // Text input for phone number
                        Block::make('phone_input')
                            ->label('Telefoonnummer')
                            ->icon(Heroicon::Phone)
                            ->schema([
                                TextInput::make('label')->label('Label')->required(),
                                TextInput::make('placeholder')->label('Placeholder'),
                                Toggle::make('required')->label('Verplicht')->default(true)->inline(false),
                            ])->columns(2),

                        // Text input for number
                        Block::make('number_input')
                            ->label('Nummerveld')
                            ->icon(Heroicon::Hashtag)
                            ->schema([
                                TextInput::make('label')->label('Label')->required(),
                                TextInput::make('placeholder')->label('Placeholder'),
                                TextInput::make('min')->label('Minimum')->numeric(),
                                TextInput::make('max')->label('Maximum')->numeric(),
                                Toggle::make('required')->label('Verplicht')->default(true)->inline(false),
                            ])->columns(2),

                        // Field for textarea
                        Block::make('textarea')
                            ->label('Tekstvak')
                            ->icon(Heroicon::Bars3BottomLeft)
                            ->schema([
                                TextInput::make('label')->label('Label')->required(),
                                TextInput::make('placeholder')->label('Placeholder'),
                                Toggle::make('required')->label('Verplicht')->default(true)->inline(false),
                            ])->columns(2),

                        // Field for dropdown / select
                        Block::make('select')
                            ->label('Dropdown')
                            ->icon(Heroicon::ChevronUpDown)
                            ->schema([
                                TextInput::make('label')->label('Label')->required(),
                                Repeater::make('options')
                                    ->label('Opties')
                                    ->schema([
                                        TextInput::make('label')->label('Label')->required(),
                                        TextInput::make('value')->label('Waarde')->required(),
                                    ])
                                    ->columns(2)
                                    ->addActionLabel('Optie toevoegen'),
                                Toggle::make('required')->label('Verplicht')->default(true)->inline(false),
                            ]),

                        // Field for radio
                        Block::make('radio')
                            ->label('Radio')
                            ->icon(Heroicon::Stop)
                            ->schema([
                                TextInput::make('label')->label('Label')->required(),
                                Repeater::make('options')
                                    ->label('Opties')
                                    ->schema([
                                        TextInput::make('label')->label('Label')->required(),
                                        TextInput::make('value')->label('Waarde')->required(),
                                    ])
                                    ->columns(2)
                                    ->addActionLabel('Optie toevoegen'),
                                Toggle::make('required')->label('Verplicht')->default(true)->inline(false),
                            ]),

                        // Field for checkbox
                        Block::make('checkbox')
                            ->label('Checkbox')
                            ->icon(Heroicon::CheckCircle)
                            ->schema([
                                TextInput::make('label')->label('Label')->required(),
                                Toggle::make('required')->label('Verplicht')->default(false)->inline(false),
                            ])->columns(2),

                        // Field for dates
                        Block::make('date_input')
                            ->label('Datum')
                            ->icon(Heroicon::Calendar)
                            ->schema([
                                TextInput::make('label')->label('Label')->required(),
                                Toggle::make('required')->label('Verplicht')->default(true)->inline(false),
                            ])->columns(2),

                    ])
                    ->blockPickerColumns(2)
                    ->addActionLabel('Input toevoegen'),

                // To which email address should the form be sent?
                TextInput::make('email')
                    ->label('Waar moet het naartoe gestuurd worden?')
                    ->prefixIcon(Heroicon::Envelope)
                    ->email()
                    ->required(),

                // Set succes message
                Section::make('Succes bericht')
                    ->schema([
                        TextInput::make('title')->label('Titel')->required(),
                        RichEditor::make('message')->label('Bericht')->required(),
                    ])
            ]);
    }
}
