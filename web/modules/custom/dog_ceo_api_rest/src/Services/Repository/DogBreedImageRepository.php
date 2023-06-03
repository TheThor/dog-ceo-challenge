<?php

namespace Drupal\dog_ceo_api_rest\Services\Repository;



use Drupal\dog_ceo_api_rest\Services\DogBreedImageClient;

class DogBreedImageRepository {

  protected DogBreedImageClient $client;

  public function __construct(DogBreedImageClient $breedImageClient) {
    $this->client = $breedImageClient;
  }

  /**
   * Retrieves the random image given a slug criteria.
   *
   * @param $slug
   *
   * @return \Psr\Http\Message\StreamInterface|string
   */
  public function getRandomDogImage($slug) {
    $this->client->setSlug($slug);
    return $this->client->executeRequest();
  }
}
