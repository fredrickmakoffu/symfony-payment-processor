<?php

namespace App\Services\Helpers;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpRequestServices
{

	const HEADERS = [
		'Content-Type' => 'application/json',
		'Accept' => 'application/json',
	];

	/**
	 * Constructor
	 *
	 * @param HttpClientInterface $client
	 */

	public function __construct(protected HttpClientInterface $client) {}

	/**
	 * Send a POST request to the specified URL
	 *
	 * @param string $url
	 * @param array $data
	 * @param array $headers
	 *
	 * @return ResponseInterface
	 */
	public function post(string $url, array $data, array $headers = self::HEADERS, array $config = []): ResponseInterface
	{
		// send a POST request to the specified URL
		$options =   [
      'headers' => $headers,
      'body' => $data
    ];

    // merge the options with the config
		return $this->client->request('POST', $url, array_merge($options, $config));
	}
}
