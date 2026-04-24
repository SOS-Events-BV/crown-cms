<?php

namespace SOSEventsBV\CrownCms\Resources\Pages\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Pboivin\FilamentPeek\Pages\Actions\PreviewAction;
use Pboivin\FilamentPeek\Pages\Concerns\HasPreviewModal;
use SOSEventsBV\CrownCms\Enums\UserRole;
use SOSEventsBV\CrownCms\Models\Page;
use SOSEventsBV\CrownCms\Resources\Pages\PageResource;
use Throwable;

/**
 * @property Page $record
 */
class EditPage extends EditRecord
{
    // This adds the preview modal to this page
    use HasPreviewModal;

    public string $originalSlug = ''; // Original slug before saving

    /**
     * Overwrite the mount method to store the original slug, so we can check later if the slug has changed.
     *
     * @param int|string $record
     * @return void
     */
    public function mount(int|string $record): void
    {
        parent::mount($record);

        // Store the original slug so we can compare it when saving
        $this->originalSlug = $this->record->slug;
    }

    protected static string $resource = PageResource::class;

    /**
     * Overwrite the preview modal view to use the show view.
     *
     * @return string|null
     */
    protected function getPreviewModalView(): ?string
    {
        return 'crown-cms::page.show'; // ← namespace toevoegen
    }

    /**
     * Overwrite the preview modal data record key to use the page record.
     *
     * This changes the key in the preview to $page
     *
     * @param array $data
     * @return array
     */
    protected function mutatePreviewModalData(array $data): array
    {
        $data['page'] = $this->record->toArray();

        return $data;
    }

    /**
     * Overwrite the preview modal view.
     *
     * TODO: This is a hack to make the preview work. We should find a better way to do this.
     *
     * @throws Throwable
     */
    public static function renderPreviewModalView(string $view, array $data): string
    {
        if (isset($data['page']) && is_array($data['page'])) {
            $page = new Page();
            $page->forceFill($data['page']);
            $page->exists = true;
            $data['page'] = $page;
        }

        $view = config('crown-cms.views.page', 'crown-cms::page.show');

        return view($view, $data)->render();
    }


    protected function getHeaderActions(): array
    {
        return [
            PreviewAction::make(), // This adds the preview button to the page
            DeleteAction::make()
                ->authorize(fn($record) => Auth::user()->getRole() === UserRole::Admin),
        ];
    }

    /**
     * Overwrite the save form action to add a modal for slug changes. If the slug has changed,
     * the modal will be shown to remind the user to create a redirect.
     *
     * @return Action
     **/
    protected function getSaveFormAction(): Action
    {
        return Action::make('save')
            ->label('Wijzigingen opslaan')
            ->requiresConfirmation()
            ->modalHidden(fn() => $this->originalSlug === ($this->data['slug'] ?? ''))
            ->modalHeading('Slug wijzigen')
            ->modalDescription(fn() => "De slug wordt gewijzigd van \"{$this->originalSlug}\" naar \"{$this->data['slug']}\". Hierdoor zullen bestaande links naar deze pagina breken. Je kan dit opvangen door een redirect aan te maken via het tabje Redirects. Weet je zeker dat je door wil gaan?")
            ->modalSubmitActionLabel('Ja, wijzig slug')
            ->modalCancelActionLabel('Annuleren')->action(function () {
                $slugChanged = $this->originalSlug !== ($this->data['slug'] ?? '');

                // Update tracked slug, so re-saving without changes won't trigger the modal again
                $this->originalSlug = $this->data['slug'];
                $this->save();

                // Remind the user to create a redirect for the old slug
                if ($slugChanged) {
                    Notification::make()
                        ->warning()
                        ->title('Slug gewijzigd')
                        ->body('Vergeet niet een redirect in te stellen om bestaande links op te vangen.')
                        ->persistent()
                        ->actions([
                            Action::make('createRedirect')
                                ->label('Redirect aanmaken')
                                ->button()
                                ->url(route('filament.admin.resources.redirects.index'))
                        ])
                        ->send();
                }
            })
            ->keyBindings(['mod+s']);
    }
}
