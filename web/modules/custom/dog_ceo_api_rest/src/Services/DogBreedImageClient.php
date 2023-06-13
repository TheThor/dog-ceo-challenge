<?php

namespace Drupal\dog_ceo_api_rest\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;

/**
 * Class client for API interaction.
 */
class DogBreedImageClient {

  /**
   * Base URL property that needs to be set for the API.
   *
   * @var string
   *   Base url for API calls.
   */
  private string $baseUrl;

  /**
   * API resource property that needs to be set for the API call.
   *
   * @var string
   *   Resource used for the API calls.
   */
  private string $resource;

  /**
   * API sub resource property that needs to be set for the API call.
   *
   * @var string
   *   Sub resource for the API.
   */
  private string $subResource;

  /**
   * Client property.
   *
   * @var \GuzzleHttp\ClientInterface
   */
  private ClientInterface $client;

  /**
   * Slug used for the resource.
   *
   * @var string
   */
  private string $slug;

  /**
   * Constructor.
   *
   * @param \GuzzleHttp\Client $client
   *   Client injection.
   */
  public function __construct(ClientInterface $client) {
    $this->baseUrl = \Drupal::request()->getSchemeAndHttpHost();
    $this->resource = '/dog-api/API/breed/';
    $this->subResource = '/images/random';
    $this->client = $client;
  }

  /**
   * Setter for slug.
   *
   * @param string $slug
   *   Slug to be used.
   */
  public function setSlug(string $slug): void {
    $this->slug = strtolower(str_replace(' ', '-', $slug));
  }

  /**
   * Execute the request method.
   *
   * @return array
   *   Returns response array.
   */
  public function executeRequest() {
    try {
      $request = $this->client->get($this->baseUrl . $this->resource . $this->slug . $this->subResource);
      $responseBodyAsString = $request->getBody();
    }
    catch (BadResponseException $e) {
      // Handle 500, 400 and too many redirects
      // Refer to
      // https://docs.guzzlephp.org/en/latest/quickstart.html#exceptions
      $response = $e->getResponse();
      $responseBodyAsString = $response->getBody()->getContents();
    }
    catch (ConnectException $e) {
      // Handle network problems (non-existing endpoint for example)
      $responseBodyAsString = json_encode([
        "Message" => "Connection Error for slug " . $this->slug . " or another problem happened",
        "Exception" => $e->getMessage(),
        "HTTP Status" => $e->getCode(),
      ]);
    }

    return json_decode($responseBodyAsString, TRUE);
  }

}
