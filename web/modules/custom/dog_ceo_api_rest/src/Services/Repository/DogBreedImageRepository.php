<?php

namespace Drupal\dog_ceo_api_rest\Services\Repository;

use Drupal\dog_ceo_api_rest\Services\DogBreedImageClient;

/**
 * Dog breed image repository layer.
 */
class DogBreedImageRepository {

  /**
   * Dog breed API client property.
   *
   * @var \Drupal\dog_ceo_api_rest\Services\DogBreedImageClient
   */
  protected DogBreedImageClient $client;

  /**
   * Constructor.
   *
   * @param \Drupal\dog_ceo_api_rest\Services\DogBreedImageClient $breedImageClient
   *   Breed image client injection.
   */
  public function __construct(DogBreedImageClient $breedImageClient) {
    $this->client = $breedImageClient;
  }

  /**
   * Retrieves the random image given a slug criteria.
   *
   * @param string $slug
   *   Slug to be used to get the random image.
   *
   * @return array
   *   Array with the response.
   */
  public function getRandomDogImage(string $slug) {
    $this->client->setSlug($slug);
    return $this->client->executeRequest();
  }

}
