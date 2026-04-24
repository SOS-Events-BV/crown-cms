<?php

namespace SOSEventsBV\CrownCms\Resources\Products\Schemas;

use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use SOSEventsBV\CrownCms\FilamentComponents\SeoSettings;
use SOSEventsBV\CrownCms\Models\Currency;
use SOSEventsBV\CrownCms\Services\LeisureKingService;

class ProductForm
{
    public static function lkApi(): LeisureKingService
    {
        return new LeisureKingService();
    }

    /**
     * Executes the synchronization action with LeisureKing API to fetch assortment data
     * and map it to the local application state.
     *
     * @return Action Returns the configured action for syncing data with LeisureKing.
     */
    public static function executeLkSyncAction(): Action
    {
        return Action::make('fetchAssortment')
            ->icon(Heroicon::ArrowPath)
            ->tooltip('Vul velden in vanuit LeisureKing')
            ->action(function (Get $get, Set $set) {
                $leisurekingId = $get('leisureking_id');
                if (empty($leisurekingId)) return null; // Return null if leisureking_id is empty

                // Function to check if a field is excluded from syncing with LK
                $syncs = fn(string $field): bool => !$get("excluded_fields_lk_sync.{$field}");

                // Get assortment data from LeisureKing
                try {
                    $assortmentData = self::lkApi()->request('/assortment/getAssortmentDataByAssortmentId', [
                        'id_assortment' => $leisurekingId,
                    ]);
                } catch (\Exception $e) {
                    return Notification::make()
                        ->title('LeisureKing Error')
                        ->body($e->getMessage())
                        ->danger()
                        ->send();
                }

                // If prices are not excluded, set the prices from LeisureKing
                if ($syncs('prices')) {
                    $priceGroups = collect($assortmentData['block_options'])
                        ->groupBy(fn($block) => number_format($block['price'], 2, '.'))
                        ->map(fn($blocks) => [
                            'id_block' => $blocks->first()['id_block'],
                            'from' => $blocks->first()['starttime'],
                            'to' => $blocks->last()['starttime'],
                        ]);

                    $euroId = Currency::where('code', 'EUR')->value('id');

                    $prices = $priceGroups->flatMap(function ($group) use ($leisurekingId, $euroId) {
                        $tarifs = self::lkApi()->request('/assortment/getTarif', [
                            'id_assortment' => $leisurekingId,
                            'id_block' => $group['id_block'],
                        ]);

                        return collect($tarifs)->map(fn($tarif) => [
                            'currency_id' => $euroId,
                            'amount' => number_format($tarif['price'] / 100, 2, ','),
                            'label' => $tarif['description'],
                            'includes_vat' => true,
                            'from' => $group['from'] === '00:00:00' ? null : $group['from'],
                            'to' => $group['to'] === '00:00:00' ? null : $group['to'],
                        ]);
                    })->values()->toArray();

                    $set('prices', $prices);
                }

                // Set fields that are not excluded from syncing with LK
                if ($syncs('name') && $assortmentData['display_name']) {
                    $set('name', $assortmentData['display_name']);
                    $set('page_title', $assortmentData['display_name']);
                }
                if ($syncs('description') && $assortmentData['description_long']) {
                    $set('description', $assortmentData['description_long']);
                }
                if ($syncs('summary') && $assortmentData['i18n']['nl']['description_short']) {
                    $set('summary', $assortmentData['i18n']['nl']['description_short']);
                    $set('page_description', $assortmentData['i18n']['nl']['description_short']);
                }
                if ($syncs('min_persons') && $assortmentData['minpax']) {
                    $set('min_persons', $assortmentData['minpax']);
                }
                if ($syncs('max_persons') && $assortmentData['maxpax']) {
                    $set('max_persons', $assortmentData['maxpax']);
                }
                if ($syncs('location') && $assortmentData['start_location'] && is_array($assortmentData['start_location'])) {
                    $loc = $assortmentData['start_location'];
                    $set('location', implode(' ', [
                        $loc['address'] . ',',
                        $loc['postcode'],
                        $loc['city'] . ',',
                        $loc['country']['name'],
                    ]));
                }

                // Returns success notification
                return Notification::make()
                    ->title('LeisureKing')
                    ->body('Velden succesvol ingevuld!')
                    ->success()
                    ->send();
            });
    }

    /**
     * Creates an action to toggle the LK sync status for a given field.
     *
     * @param string $field The field for which the LK sync action is being created.
     * @return Action The configured action instance for toggling the LK sync status.
     */
    public static function lkSyncAction(string $field): Action
    {
        return Action::make('excluded_fields_lk_sync_' . $field)
            ->label(fn(Get $get): string => $get("excluded_fields_lk_sync.{$field}")
                ? 'LK sync uitgeschakeld'
                : 'LK sync ingeschakeld'
            )
            ->tooltip(fn(Get $get): string => $get("excluded_fields_lk_sync.{$field}")
                ? 'LK sync uitgeschakeld'
                : 'LK sync ingeschakeld')
            ->icon(Heroicon::ArrowPath)
            ->color(fn(Get $get): string => $get("excluded_fields_lk_sync.{$field}")
                ? 'gray'
                : 'success'
            )
            ->action(fn(Set $set, Get $get) => $set(
                "excluded_fields_lk_sync.{$field}",
                !$get("excluded_fields_lk_sync.{$field}")
            ));
    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('excluded_fields_lk_sync'), // Hidden field to save fields that do not sync with LK

                Tabs::make('Tabs')
                    ->tabs([

                        // ─── 1. BASIS ────────────────────────────────────────
                        Tabs\Tab::make('Basis')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('slug')
                                        ->label('Pagina slug')
                                        ->afterLabel('Zoals `pagina` of `subpagina/pagina`')
                                        ->required()
                                        ->unique(ignorable: fn($record) => $record),

                                    TextInput::make('name')
                                        ->label('Productnaam')
                                        ->required()
                                        ->suffixAction(static::lkSyncAction('name')),
                                ]),

                                RichEditor::make('summary')
                                    ->label('Samenvatting')
                                    ->columnSpanFull()
                                    ->hintAction(self::lkSyncAction('summary')),

                                RichEditor::make('description')
                                    ->label('Omschrijving')
                                    ->columnSpanFull()
                                    ->hintAction(self::lkSyncAction('description')),

                                SpatieMediaLibraryFileUpload::make('images')
                                    ->label('Afbeeldingen')
                                    ->collection('product')
                                    ->disk('public')
                                    ->multiple()
                                    ->image()
                                    ->imageEditor()
                                    ->reorderable()
                                    ->panelLayout('grid')
                                    ->getUploadedFileNameForStorageUsing(
                                    // UUID-based, unique file name with original title + hash and extension
                                        fn(TemporaryUploadedFile $file): string => Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                                            . '_' . Str::uuid()
                                            . '.' . $file->getClientOriginalExtension()
                                    )
                                    ->appendFiles(),

                                // ── Optionele velden ──────────────────────────
                                Fieldset::make('Optionele velden')
                                    ->schema([
                                        TextInput::make('location')
                                            ->label('Locatie')
                                            ->prefixIcon(Heroicon::MapPin)
                                            ->columnSpanFull()
                                            ->suffixAction(static::lkSyncAction('location')),

                                        TextInput::make('min_persons')
                                            ->minValue(0)
                                            ->label('Minimaal aantal personen')
                                            ->numeric()
                                            ->suffixAction(static::lkSyncAction('min_persons')),

                                        TextInput::make('max_persons')
                                            ->minValue(1)
                                            ->label('Maximaal aantal personen')
                                            ->numeric()
                                            ->suffixAction(static::lkSyncAction('max_persons')),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),

                                // ── Pagina instellingen ───────────────────────
                                Fieldset::make('Pagina instellingen')
                                    ->schema([
                                        Toggle::make('is_active')
                                            ->label('Product actief')
                                            ->inline(false)
                                            ->default(true),

                                        // Clickable URL to the page
                                        TextEntry::make('url')
                                            ->hiddenOn('create')
                                            ->label('Bekijk product')
                                            ->state('Klik hier')
                                            ->url(fn($record) => config('crown-cms.routes.product') ?
                                                route(config('crown-cms.routes.product'), $record->slug) :
                                                null
                                            )
                                            ->hidden(fn(Get $get) => !$get('is_active') || !config('crown-cms.routes.product'))
                                            ->icon(Heroicon::Link)
                                            ->openUrlInNewTab()
                                            ->color('primary'),
                                    ])
                                    ->columns(2)
                                    ->columnSpanFull(),

                                // ── Audit info ────────────────────────────────
                                Grid::make(2)
                                    ->hiddenOn('create')
                                    ->schema([
                                        TextEntry::make('created_at')
                                            ->label('Aangemaakt op')
                                            ->dateTime('d-m-Y H:i')
                                            ->color('gray'),

                                        TextEntry::make('updated_at')
                                            ->label('Gewijzigd op')
                                            ->dateTime('d-m-Y H:i')
                                            ->color('gray'),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        // ─── 2. PRIJZEN & BOEKEN ─────────────────────────────
                        Tabs\Tab::make('Prijzen & boeken')
                            ->schema([
                                Section::make('Prijs instellingen')
                                    ->aside()
                                    ->description('Minimaal 1 prijs in euro is verplicht. Geef aan per prijs of het inclusief of exclusief BTW is. Optioneel kan je andere valuta\'s toevoegen en een label toevoegen.')
                                    ->schema([
                                        Repeater::make('prices')
                                            ->label('Prijzen')
                                            ->relationship('prices')
                                            ->addActionLabel('Prijs toevoegen')
                                            ->collapsed()
                                            ->itemLabel(fn(array $state): ?string => trim(($state['label'] ?? 'Prijs') . ' – ' . ($state['amount'] ?? '')))
                                            ->hintAction(self::lkSyncAction('prices'))
                                            ->grid()
                                            ->minItems(1)
                                            ->rule(
                                                fn() => function (string $attribute, mixed $value, Closure $fail) {
                                                    $euroId = Currency::where('code', 'EUR')->value('id');
                                                    $hasEuro = collect($value)->contains('currency_id', $euroId);
                                                    if (!$hasEuro) {
                                                        $fail('Een prijs in Euro (EUR) is verplicht.');
                                                    }
                                                }
                                            )
                                            ->schema([
                                                Select::make('currency_id')
                                                    ->label('Valuta')
                                                    ->options(Currency::all()->pluck('name', 'id'))
                                                    ->required()
                                                    ->live(),

                                                TextInput::make('amount')
                                                    ->label('Prijs')
                                                    ->inputMode('decimal')
                                                    ->step(0.01)
                                                    ->required()
                                                    ->live()
                                                    ->mask(RawJs::make('$money($input, \',\')'))
                                                    ->formatStateUsing(
                                                        fn($state) => $state
                                                            ? number_format((float)$state, 2, ',', '.')
                                                            : null
                                                    )
                                                    ->dehydrateStateUsing(
                                                        fn($state) => $state
                                                            ? (float)str_replace(',', '.', str_replace('.', '', $state))
                                                            : null
                                                    )
                                                    ->prefix(
                                                        fn($get) => Currency::find($get('currency_id'))?->symbol ?? '?'
                                                    ),

                                                Toggle::make('includes_vat')
                                                    ->label('Inclusief BTW')
                                                    ->default(true),

                                                TextInput::make('label')
                                                    ->label('Label (optioneel)')
                                                    ->belowContent('Bijvoorbeeld: Volwassenentarief of Kindertarief'),

                                                Fieldset::make('Tijdblok (optioneel)')
                                                    ->schema([
                                                        TimePicker::make('from_time')->label('Van'),
                                                        TimePicker::make('to_time')->label('Tot'),
                                                    ])
                                                    ->columns(2)
                                                    ->columnSpanFull(),
                                            ])
                                            ->reorderable()
                                            ->orderColumn('sort_order'),
                                    ])
                                    ->columnSpanFull(),

                                Section::make('Boek optie')
                                    ->aside()
                                    ->description("Kies hoe bezoekers dit product kunnen boeken. Bij 'Boek direct' is een LeisureKing Boeking Module verplicht.")
                                    ->schema([
                                        ToggleButtons::make('book_option')
                                            ->label('Boek optie')
                                            ->inline()
                                            ->live()
                                            ->required()
                                            ->options([
                                                'book_now' => 'Boek direct',
                                                'quotation' => 'Offerte',
                                                'forward' => 'Doorverwijzen naar...',
                                            ])
                                            ->default('book_now'),

                                        TextInput::make('forward_url')
                                            ->label('Doorverwijzen naar URL')
                                            ->required()
                                            ->url()
                                            ->hidden(fn(Get $get) => $get('book_option') !== 'forward'),

                                        TextInput::make('forward_title')
                                            ->label('Titel doorverwijzing')
                                            ->placeholder('Bijvoorbeeld: Je wordt doorverwezen naar de Veluwe Specialist.')
                                            ->required()
                                            ->hidden(fn(Get $get) => $get('book_option') !== 'forward'),

                                        TextInput::make('forward_description')
                                            ->label('Beschrijving doorverwijzing')
                                            ->placeholder('Voorbeeld: Veel plezier op de Veluwe Specialist!')
                                            ->required()
                                            ->hidden(fn(Get $get) => $get('book_option') !== 'forward'),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        // ─── 3. SEO ──────────────────────────────────────────
                        Tabs\Tab::make('SEO')
                            ->schema([
                                Section::make('SEO Instellingen')
                                    ->description('Beheer de SEO instellingen voor dit product.')
                                    ->aside()
                                    ->schema([
                                        SeoSettings::make('product/og'),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        // ─── 4. FAQ ──────────────────────────────────────────
                        Tabs\Tab::make('FAQ')
                            ->schema([
                                Section::make('Veelgestelde vragen')
                                    ->aside()
                                    ->description('Voeg veelgestelde vragen toe die op de productpagina worden getoond.')
                                    ->schema([
                                        Repeater::make('faqs')
                                            ->label('FAQ\'s')
                                            ->addActionLabel('FAQ toevoegen')
                                            ->collapsible()
                                            ->itemLabel(fn(array $state): ?string => $state['question'] ?? null)
                                            ->schema([
                                                TextInput::make('question')
                                                    ->label('Vraag')
                                                    ->required(),
                                                RichEditor::make('answer')
                                                    ->label('Antwoord')
                                                    ->required(),
                                            ])
                                            ->default([]),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                        // ─── 5. PAKKET & INTEGRATIE ──────────────────────────
                        Tabs\Tab::make('Pakket & integratie')
                            ->schema([
                                Section::make('Arrangement instellingen')
                                    ->collapsed()
                                    ->aside()
                                    ->description('Details voor het programma en tijdschema. Alleen van toepassing als dit product een arrangement is.')
                                    ->schema([
                                        Toggle::make('is_package')
                                            ->label('Dit product is een arrangement')
                                            ->reactive(),

                                        Repeater::make('time_schemes')
                                            ->label('Tijdschema\'s')
                                            ->itemLabel(fn(array $state): ?string => $state['name'] ?? null)
                                            ->hidden(fn(Get $get) => !$get('is_package'))
                                            ->schema([
                                                TextInput::make('name')
                                                    ->label('Naam programma')
                                                    ->placeholder('bijv. Ochtendprogramma')
                                                    ->required(),

                                                Repeater::make('rows')
                                                    ->label('Onderdelen')
                                                    ->grid(2)
                                                    ->schema([
                                                        Grid::make(2)->schema([
                                                            TimePicker::make('start_time')
                                                                ->label('Van')
                                                                ->required(),
                                                            TimePicker::make('end_time')
                                                                ->label('Tot')
                                                                ->required(),
                                                        ]),
                                                        TextInput::make('activity')
                                                            ->label('Activiteit')
                                                            ->placeholder('Ontvangst met koffie')
                                                            ->required(),
                                                    ])
                                                    ->addActionLabel('Onderdeel toevoegen'),
                                            ])
                                            ->addActionLabel('Nieuw tijdschema toevoegen'),
                                    ])
                                    ->columnSpanFull(),

                                Section::make('LeisureKing (optioneel)')
                                    ->aside()
                                    ->description('Vul hier het LeisureKing ID in. Hiermee kunnen we al bepaalde velden mee invullen.')
                                    ->schema([
                                        Select::make('leisureking_id')
                                            ->label('LeisureKing ID')
                                            ->searchable()
                                            ->live()
                                            ->options(function () {
                                                $assortment = self::lkApi()->request('/assortment/get');
                                                return collect($assortment)
                                                    ->mapWithKeys(fn($row) => [
                                                        $row['id_assortment'] => $row['display_name'] . ' (' . $row['id_assortment'] . ')'
                                                    ])
                                                    ->toArray();
                                            })
                                            ->suffixAction(self::executeLkSyncAction()),

                                        TextInput::make('leisureking_bookingmodule_hash')
                                            ->label('LeisureKing Boeking Module')
                                            ->afterLabel('Dit is de hash achter /bm/...')
                                            ->requiredIf('book_option', 'book_now'),
                                    ])
                                    ->columnSpanFull(),
                            ]),

                    ])->columnSpanFull(),
            ]);
    }
}
