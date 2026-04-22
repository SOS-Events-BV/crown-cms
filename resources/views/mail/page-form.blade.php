<x-crown-cms::mail>
    <p>Beste,</p>
    <p>
        Er is een nieuw formulier verzonden op de pagina <a href="{{ route('page', $slug) }}">/{{ $slug }}</a>,
        op de website van {{ config('app.name') }}. Hieronder vind je alle gegevens:
    </p>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0"
        style="width: 100%; border-collapse: collapse; margin-top: 16px;">
        @foreach ($formData as $key => $value)
            <tr style="border-bottom: 1px solid #eaebed;">
                <th style="font-family: Helvetica, sans-serif; font-size: 14px; font-weight: 600; text-align: left; padding: 10px 12px; background-color: #f4f5f6; width: 35%; vertical-align: top;">
                    {{ Str::ucfirst(str_replace('_', ' ', $key)) }}
                </th>
                <td style="font-family: Helvetica, sans-serif; font-size: 14px; text-align: left; padding: 10px 12px; vertical-align: top;">
                    {!! nl2br($value) !!}
                </td>
            </tr>
        @endforeach
    </table>

    <p>
        Met vriendelijke groet,
        <br>
        {{ config('app.name') }}
    </p>
</x-crown-cms::mail>

