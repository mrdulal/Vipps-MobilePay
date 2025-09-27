<?php

namespace Mrdulal\LaravelVipps\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Mrdulal\LaravelVipps\Exceptions\VippsException;
use Mrdulal\LaravelVipps\Exceptions\VippsApiException;

class VippsClient
{
    protected Client $httpClient;
    protected array $config;
    protected ?string $accessToken = null;
    protected string $environment;

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->environment = $config['environment'] ?? 'test';
        
        $this->httpClient = new Client([
            'timeout' => $config['http']['timeout'] ?? 30,
            'connect_timeout' => $config['http']['connect_timeout'] ?? 10,
            'verify' => $config['http']['verify'] ?? true,
            'headers' => $config['http']['headers'] ?? [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        ]);
    }

    /**
     * Get access token for API authentication.
     */
    public function getAccessToken(): string
    {
        $cacheKey = $this->config['cache']['prefix'] . 'access_token';

        if ($this->config['cache']['enabled'] && Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $token = $this->requestAccessToken();
        
        if ($this->config['cache']['enabled']) {
            // Cache for slightly less time than the token expires to ensure we refresh before expiry
            $ttl = ($this->config['cache']['ttl'] ?? 3600) - 60;
            Cache::put($cacheKey, $token, $ttl);
        }

        $this->accessToken = $token;
        return $token;
    }

    /**
     * Request a new access token from Vipps API.
     */
    protected function requestAccessToken(): string
    {
        $endpoint = $this->getApiEndpoint('base_url') . '/accesstoken/get';

        try {
            $response = $this->httpClient->post($endpoint, [
                'headers' => [
                    'client_id' => $this->config['client_id'],
                    'client_secret' => $this->config['client_secret'],
                    'Ocp-Apim-Subscription-Key' => $this->config['subscription_key'],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            
            if (!isset($data['access_token'])) {
                throw new VippsException('Access token not found in response');
            }

            return $data['access_token'];
        } catch (RequestException $e) {
            $this->logError('Failed to get access token', $e);
            throw new VippsApiException('Failed to authenticate with Vipps API', 0, $e);
        }
    }

    /**
     * Make an authenticated request to the Vipps API.
     */
    public function request(string $method, string $url, array $options = []): array
    {
        $token = $this->getAccessToken();
        
        $headers = array_merge($options['headers'] ?? [], [
            'Authorization' => 'Bearer ' . $token,
            'Ocp-Apim-Subscription-Key' => $this->config['subscription_key'],
            'Merchant-Serial-Number' => $this->config['merchant_serial_number'],
        ]);

        $options['headers'] = $headers;

        if ($this->config['logging']['enabled'] && $this->config['logging']['log_requests']) {
            $this->logRequest($method, $url, $options);
        }

        try {
            $response = $this->httpClient->request($method, $url, $options);
            $responseData = json_decode($response->getBody()->getContents(), true);

            if ($this->config['logging']['enabled'] && $this->config['logging']['log_responses']) {
                $this->logResponse($response->getStatusCode(), $responseData);
            }

            return $responseData ?? [];
        } catch (RequestException $e) {
            $this->logError("API request failed: {$method} {$url}", $e);
            
            $response = $e->getResponse();
            if ($response) {
                $errorData = json_decode($response->getBody()->getContents(), true);
                throw new VippsApiException(
                    $errorData['message'] ?? 'API request failed',
                    $response->getStatusCode(),
                    $e,
                    $errorData
                );
            }

            throw new VippsException('Network error occurred', 0, $e);
        }
    }

    /**
     * Make a GET request.
     */
    public function get(string $url, array $options = []): array
    {
        return $this->request('GET', $url, $options);
    }

    /**
     * Make a POST request.
     */
    public function post(string $url, array $data = [], array $options = []): array
    {
        $options['json'] = $data;
        return $this->request('POST', $url, $options);
    }

    /**
     * Make a PUT request.
     */
    public function put(string $url, array $data = [], array $options = []): array
    {
        $options['json'] = $data;
        return $this->request('PUT', $url, $options);
    }

    /**
     * Make a PATCH request.
     */
    public function patch(string $url, array $data = [], array $options = []): array
    {
        $options['json'] = $data;
        return $this->request('PATCH', $url, $options);
    }

    /**
     * Make a DELETE request.
     */
    public function delete(string $url, array $options = []): array
    {
        return $this->request('DELETE', $url, $options);
    }

    /**
     * Get API endpoint URL for the current environment.
     */
    public function getApiEndpoint(string $type = 'base_url'): string
    {
        return $this->config['api_endpoints'][$this->environment][$type] ?? 
               $this->config['api_endpoints']['test'][$type];
    }

    /**
     * Get the current environment.
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * Check if we're in test mode.
     */
    public function isTestMode(): bool
    {
        return $this->environment === 'test';
    }

    /**
     * Log API request.
     */
    protected function logRequest(string $method, string $url, array $options): void
    {
        $logData = [
            'method' => $method,
            'url' => $url,
            'headers' => $this->config['logging']['log_headers'] ? ($options['headers'] ?? []) : '[HIDDEN]',
            'body' => $options['json'] ?? null,
        ];

        Log::channel($this->config['logging']['channel'] ?? 'default')
            ->log($this->config['logging']['level'] ?? 'info', 'Vipps API Request', $logData);
    }

    /**
     * Log API response.
     */
    protected function logResponse(int $statusCode, array $data): void
    {
        $logData = [
            'status_code' => $statusCode,
            'response' => $data,
        ];

        Log::channel($this->config['logging']['channel'] ?? 'default')
            ->log($this->config['logging']['level'] ?? 'info', 'Vipps API Response', $logData);
    }

    /**
     * Log API error.
     */
    protected function logError(string $message, \Throwable $exception): void
    {
        Log::channel($this->config['logging']['channel'] ?? 'default')
            ->error($message, [
                'exception' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);
    }
}