<?php

namespace SOSEventsBV\CrownCms\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use SOSEventsBV\CrownCms\Mail\PageFormMail;
use SOSEventsBV\CrownCms\Models\Page;

class PageController
{
    /**
     * Show a page by slug from the `pages` table
     *
     * @param string $slug The slug of the page
     * @return View
     */
    public function show(string $slug): View
    {
        $page = Page::where([['slug', $slug], ['is_active', true]])->firstOrFail();

        return view('crown-cms::page.show', [
            'page' => $page
        ]);
    }

    /**
     * Handles the submission of a page form.
     *
     * This method validates the form inputs dynamically based on form configuration,
     * sends an email with the validated form data, and redirects to a success route.
     *
     * @param string $slug The slug of the page.
     * @param Request $request
     * @return RedirectResponse
     */
    public function submitForm(string $slug, Request $request): RedirectResponse
    {
        $page = Page::where([['slug', $slug], ['is_active', true]])->firstOrFail();

        // Find the form block in the page content
        $pageForm = collect($page->content_objects)->firstWhere('type', 'form_builder_block');

        if (!$pageForm || !isset($pageForm->data->form_inputs)) {
            abort(404); // Form block or inputs not found
        }

        // Build validation rules dynamically from the form config
        $rules = collect($pageForm->data->form_inputs)
            ->mapWithKeys(function ($input) {
                $name = Str::slug($input->data->label, '_');
                $required = $input->data->required ?? false;

                return [$name => $required ? 'required' : 'nullable'];
            })
            ->toArray();

        // Add recaptcha validation rule
        $rules['g-recaptcha-response'] = ['required', 'captcha'];

        $validator = Validator::make($request->all(), $rules);

        // If validation fails, redirect back with errors and input, with a fragment to the form
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->withFragment('form');
        }

        // Get validated data without g-recaptcha-response
        $formData = collect($validator->validated())
            ->except('g-recaptcha-response')
            ->toArray();

        // Send email to the given email with form data
        $email = $pageForm->data->email;
        Mail::to($email)->send(new PageFormMail($slug, $formData));

        return redirect()->route('page.success', $slug);
    }

    /**
     * Displays the success page for a page form submission.
     *
     * @param string $slug The slug of the page.
     * @return View
     */
    public function showSuccess(string $slug): View
    {
        $page = Page::where([['slug', $slug], ['is_active', true]])->firstOrFail();

        $formBlock = collect($page->content_objects)->firstWhere('type', 'form_builder_block');

        if (!$formBlock || !$formBlock->data) {
            abort(404); // Form block not found
        }

        $successMessage = $formBlock->data;

        return view('crown-cms::page.success', [
            'page' => $page,
            'title' => $successMessage->title ?? 'Bedankt!',
            'message' => $successMessage->message ?? 'Je formulier is succesvol verzonden.',
        ]);
    }
}
