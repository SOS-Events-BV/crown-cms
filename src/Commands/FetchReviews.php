<?php

namespace SOSEventsBV\CrownCms\Commands;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use SOSEventsBV\CrownCms\Models\Review;

class FetchReviews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crown-cms:fetch-reviews {--all-reviews : Get all reviews instead of only yesterday}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches the reviews of the last day of the shop. With the flag --all-reviews you can fetch all reviews.';

    /**
     * Execute the console command.
     * @throws ConnectionException
     */
    public function handle(): void
    {
        $this->info('[START] Fetching reviews... [' . Carbon::now()->toDateTimeString() . ']');

        // Check if we need to fetch all reviews
        if ($this->option('all-reviews')) {
            // Fetch all reviews
            $reviews = Http::baseUrl(config('crown-cms.services.review.url'))
                ->withToken(config('crown-cms.services.review.api_key'))
                ->get("/allReviews/" . config('crown-cms.services.review.shop_id'))
                ->json();
        } else {
            // Fetch reviews since yesterday
            $reviews = Http::baseUrl(config('crown-cms.services.review.url'))
                ->withToken(config('crown-cms.services.review.api_key'))
                ->get("/allReviews/" . config('crown-cms.services.review.shop_id') . "/" . Carbon::now()->subDay()->format('Y-m-d'))
                ->json();
        }

        foreach ($reviews as $review) {
            // Create if reservation_hash doesn't exist, update if it does exist
            Review::updateOrCreate([
                'reservation_hash' => $review['reshid'],
            ], [
                'firstname' => $review['firstname'],
                'lastname' => $review['lastname'],
                'stars' => $review['stars'],
                'review' => $review['review'],
                'reaction' => $review['reaction'],
                'language' => $review['lang'],
                'review_placed' => $review['review_placed'],
                'extra_attributes' => isset($review['extra_questions']) ?
                    collect($review['extra_questions'])->pluck('answer', 'slug')->all()
                    : null
            ]);
        }

        $this->info('[END] Fetching reviews... [' . Carbon::now()->toDateTimeString() . ']');
    }
}
