<?php

namespace Drupal\dog_ceo_api_rest\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;

class DogBreedImageClient {
  private string $baseUrl;

  private string $resource;

  private string $subResource;

  /**
   * @var \GuzzleHttp\ClientInterface
   */
  private ClientInterface $client;

  private string $slug;

  /**
   * @param \GuzzleHttp\Client $client
   */
  public function __construct(ClientInterface $client) {
    $this->baseUrl = \Drupal::request()->getSchemeAndHttpHost();
    $this->resource = '/dog-api/API/breed/';
    $this->subResource = '/images/random';
    $this->client = $client;
  }

  /**
   * @param string $slug
   */
  public function setSlug(string $slug): void {
    $this->slug = strtolower(str_replace(' ', '-', $slug));
  }

  /**
   * @return array
   */
  public function executeRequest() {
    try {
      $request = $this->client->get($this->baseUrl . $this->resource . $this->slug . $this->subResource);
      $responseBodyAsString = $request->getBody();
    } catch (BadResponseException $e) {
      //Handle 500, 400 and too many redirects
      //Refer to https://docs.guzzlephp.org/en/latest/quickstart.html#exceptions
      $response = $e->getResponse();
      $responseBodyAsString = $response->getBody()->getContents();
    } catch (ConnectException $e) {
      //Handle network problems (non-existing endpoint for example)
      $responseBodyAsString = json_encode([
        "Message" => "Connection Error for slug ". $this->slug . " or another problem happened",
        "Exception" => $e->getMessage(),
        "HTTP Status" => $e->getCode()
      ]);
    }

    return json_decode($responseBodyAsString, TRUE);
  }
}
