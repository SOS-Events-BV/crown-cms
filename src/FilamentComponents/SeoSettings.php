<?php

namespace SOSEventsBV\CrownCms\FilamentComponents;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class SeoSettings
{
    /**
     * Reusable form component for SEO Settings. Make sure the model has a `seo` relationship.
     *
     * @param string $ogDirectory The directory where the OG image must be saved.
     * @return Group
     */
    public static function make(string $ogDirectory): Group
    {
        return Group::make([
            TextInput::make('page_title')
                ->label('Pagina titel')
                ->required()
                ->debounce()
                ->hint(fn($state) => strlen($state) . ' tekens')
                ->hintColor(fn($state) => match (true) {
                    strlen($state) > 60 => 'danger',
                    strlen($state) > 50 => 'warning',
                    default => 'success'
                })
                ->belowContent('Een goede pagina titel is tot 50/60 tekens'),

            Textarea::make('page_description')
                ->label('Meta description')
                ->required()
                ->debounce()
                ->hint(fn($state) => strlen($state) . ' tekens')
                ->hintColor(fn($state) => match (true) {
                    strlen($state) > 160 => 'danger',
                    strlen($state) > 150 => 'warning',
                    default => 'success'
                })
                ->autosize()
                ->maxLength(255)
                ->belowContent('Een goede meta description is tot 150/160 tekens'),

            TagsInput::make('page_keywords')
                ->label('Meta keywords (optioneel)')
                ->separator(', ')
                ->helperText('Google gebruikt keywords niet meer, maar ze zijn soms nog steeds relevant voor andere zoekmachines.')
                ->placeholder('Voeg een keyword toe...'),

            // Open Graph settings
            Section::make('Open Graph (og:)')
                ->description('Optionele social media preview instellingen')
                ->collapsed()
                ->schema([
                    // OG Title
                    TextInput::make('og_title')
                        ->label('OG Titel')
                        ->debounce()
                        ->hint(fn($state) => strlen($state) . ' tekens')
                        ->hintColor(fn($state) => match (true) {
                            strlen($state) > 60 => 'danger',
                            strlen($state) > 50 => 'warning',
                            default => 'success'
                        })
                        ->extraInputAttributes(fn($state) => [
                            'class' => match (true) {
                                strlen($state) > 60 => 'border-red-500',
                                strlen($state) > 50 => 'border-orange-500',
                                default => 'border-green-500',
                            }
                        ])
                        ->belowContent('Laat leeg om de pagina titel te gebruiken'),

                    // OG Description
                    TextInput::make('og_description')
                        ->label('OG Omschrijving')
                        ->debounce()
                        ->hint(fn($state) => strlen($state) . ' tekens')
                        ->hintColor(fn($state) => match (true) {
                            strlen($state) > 160 => 'danger',
                            strlen($state) > 150 => 'warning',
                            default => 'success'
                        })
                        ->extraInputAttributes(fn($state) => [
                            'class' => match (true) {
                                strlen($state) > 160 => 'border-red-500',
                                strlen($state) > 150 => 'border-orange-500',
                                default => 'border-green-500',
                            }
                        ])
                        ->belowContent('Laat leeg om de meta description te gebruiken'),

                    // OG Image
                    FileUpload::make('og_image')
                        ->label('OG Afbeelding')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory($ogDirectory)
                        ->getUploadedFileNameForStorageUsing(
                        // UUID-based, unique file name with original title + hash and extension
                            fn(TemporaryUploadedFile $file): string => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                                . '_' . Str::uuid()
                                . '.' . $file->getClientOriginalExtension()
                        )
                        ->helperText('Aanbevolen formaat: 1200x630px'),
                ]),
        ])->relationship('seo');
    }
}
