<?php

namespace SOSEventsBV\CrownCms\FilamentBlocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\CodeEditor;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\HtmlString;

class CustomHtmlBlock
{
    public static function make(): Block
    {
        return Block::make('custom_html_block')
            ->label('HTML blok')
            ->icon(Heroicon::CodeBracket)
            ->schema([
                CodeEditor::make('html')
                    ->hiddenLabel()
                    ->language(CodeEditor\Enums\Language::Html)
                    ->helperText(new HtmlString(
                        '
                        <strong>Let op:</strong> Gebruik in dit veld <u>geen</u> Tailwind classes, maar pas opmaak toe via <strong>inline styles</strong> (bijv. <code>&lt;div style="display: flex; gap: 10px;"&gt;</code>).<br>
                        <br>
                        <strong>Handige bronnen voor HTML & CSS:</strong>
                        <ul style="margin-top: 5px; margin-left: 20px; list-style-type: disc;">
                            <li><a href="https://developer.mozilla.org/nl/docs/Web/HTML" target="_blank" style="text-decoration: underline; color: #006f7c;">MDN Web Docs (Uitgebreide documentatie)</a></li>
                            <li><a href="https://www.w3schools.com/html/" target="_blank" style="text-decoration: underline; color: #006f7c;">W3Schools (Makkelijke tutorials en voorbeelden)</a></li>
                        </ul>
                        '
                    )),
            ]);
    }
}
