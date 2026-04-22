<?php


namespace SOSEventsBV\CrownCms\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Http;
use Illuminate\Http\Client\ConnectionException;
use SOSEventsBV\CrownCms\Models\Currency;

class FetchCurrencies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crown-cms:fetch-currencies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches the currency exchange rates from the API and stores them in the database.';

    /**
     * Execute the console command.
     * @throws ConnectionException
     */
    public function handle(): void
    {
        $this->info('[START] Fetching currency exchange rates... [' . Carbon::now()->toDateTimeString() . ']');

        try {
            $websiteCurrencies = [
                [
                    'name' => 'Euro',
                    'code' => 'EUR',
                    'symbol' => '€'
                ],
                [
                    'name' => 'US Dollar',
                    'code' => 'USD',
                    'symbol' => '$'
                ],
                [
                    'name' => 'GB Pound',
                    'code' => 'GBP',
                    'symbol' => '£'
                ]
            ];

            $ratesFromEuro = Http::get('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/eur.json')->json('eur');

            foreach ($websiteCurrencies as $currency) {
                // Add or update currency
                Currency::updateOrCreate([
                    'code' => $currency['code'],
                ], [
                    'name' => $currency['name'],
                    'symbol' => $currency['symbol'],
                    'exchange_rate' => $ratesFromEuro[strtolower($currency['code'])],
                ]);
            }
        } catch (\Exception $e) {
            \Log::error("Error occurred during fetching currencies. " . $e->getMessage());
        }

        $this->info('[END] Done fetching currency exchange rates [' . Carbon::now()->toDateTimeString() . ']');
    }
}
