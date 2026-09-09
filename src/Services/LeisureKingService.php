<?php

namespace SOSEventsBV\CrownCms\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class LeisureKingService
{
    protected string $baseUrl;
    protected string $version;
    protected string $environment;
    protected string $shophid;

    public function __construct()
    {
        $this->baseUrl = config('crown-cms.services.leisureking.url');
        $this->version = config('crown-cms.services.leisureking.version');
        $this->shophid = config('crown-cms.services.leisureking.shophid');
        $this->environment = config('crown-cms.services.leisureking.environment');
    }
    /**
     * Client for LeisureKing API.
     *
     * @return PendingRequest
     */
    protected function client(): PendingRequest
    {
        return Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'Authorization' => 'Token ' . $this->getToken(),
                'Accept' => 'application/json',
            ]);
    }

    /**
     * Make a request to the LeisureKing API.
     *
     * @param string $endpoint Endpoint to request, without `https://www.api.leisureking.eu/public`, start with / and without version. `https://www.api.leisureking.eu/public/assortment/get/v4` becomes `/assortment/get`.
     * @param array $data The POST data to be added.
     * @param string|null $version The version of the API to use. If not provided, the version from the config will be used.
     * @return array|int|string|null The response data. Returns null if no data is returned.
     * @throws ConnectionException
     * @throws RequestException
     */
    public function request(string $endpoint, array $data = [], ?string $version = null): array|int|string|null
    {
        // Create payload, with required data and given data
        $payload = array_merge($data, [
            'environment' => $this->environment,
            'shophid' => $this->shophid,
        ]);

        // Create the URL, remove / from string
        $url = trim($endpoint, '/') . '/' . ($version ?? $this->version);

        try {
            return $this->client()
                ->post($url, $payload)
                ->throw()
                ->json('data');
        } catch (\Exception $e) {
            Log::error("LeisureKing API Request Error: {$e->getMessage()}", [
                'endpoint' => $endpoint,
                'url' => $url,
                'payload' => $payload,
            ]);
            throw $e;
        }
    }

    /**
     * Get the JWT-token from the LeisureKing API. This token will be cached for 10 minutes.
     *
     * @return string
     */
    protected function getToken(): string
    {
        // Cache the JWT-token for 10 minutes (max LK is 15 minutes)
        return Cache::remember('leisureking_token', 600, function () {
            try {
                $response = Http::post("{$this->baseUrl}/authenticate/{$this->version}", [
                    'username' => config('crown-cms.services.leisureking.username'),
                    'password' => config('crown-cms.services.leisureking.password'),
                    'environment' => $this->environment,
                ]);

                $response->throw(); // Throw error if auth fails

                return $response->json('data.token'); // Return the JWT-token
            } catch (\Exception $e) {
                Log::error("LeisureKing API Auth Error: {$e->getMessage()}", [
                    'url' => "{$this->baseUrl}/authenticate/{$this->version}",
                    'username' => config('crown-cms.services.leisureking.username'),
                ]);
                throw $e;
            }
        });
    }

    /**
     * Set the version of the LesiureKingService.
     *
     * @param string $version
     * @return void
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * Set the environment (test or production) of the LeisureKingService
     *
     * @param string $environment
     * @return void
     */
    public function setEnvironment(string $environment)
    {
        if (!in_array($environment, ['test', 'production'])) {
            throw new InvalidArgumentException(
                sprintf('Invalid environment "%s", expected "test" or "production".', $environment)
            );
        }

        $this->environment = $environment;
    }

    /**
     * Set the shophid of the LeisureKingService
     *
     * @param string $shopHid
     * @return void
     */
    public function setShopHid(string $shopHid)
    {
        $this->shophid = $shopHid;
    }
}
