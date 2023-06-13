<?php

namespace Drupal\dog_ceo_api_rest\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\dog_ceo_api_rest\Services\Repository\DogBreedImageRepository;

/**
 * Dog breed image service layer.
 */
class DogBreedImageService {

  /**
   * Dog breed repository property.
   *
   * @var \Drupal\dog_ceo_api_rest\Services\Repository\DogBreedImageRepository
   */
  private DogBreedImageRepository $dogBreedImageRepository;

  /**
   * Constructor.
   *
   * @param \Drupal\dog_ceo_api_rest\Services\Repository\DogBreedImageRepository $dogBreedImageRepository
   *   Dog breed repo injection.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   *   Config factory injection.
   */
  public function __construct(DogBreedImageRepository $dogBreedImageRepository, ConfigFactoryInterface $configFactory) {
    $this->dogBreedImageRepository = $dogBreedImageRepository;
    $this->config = $configFactory->get('dog_ceo_block_admin_config.settings');
  }

  /**
   * Returns the random dog image for a given slug.
   *
   * All the logic for the state should be here.
   *
   * @return array
   *   Returns a random image of the day.
   */
  public function getRandomDogOfTheDayImage() {
    $slug = $this->config->get('slug');
    $variables['title'] = '';
    $variables['img-url'] = '';
    $variables['img-alt'] = '';
    if (!empty($slug)) {
      $result = $this->dogBreedImageRepository->getRandomDogImage($slug);
      if (!empty($result) && isset($result[0])) {
        $variables['title'] = $result[0]['title'];
        $variables['img-url'] = $result[0]['img-url'];
        $variables['img-alt'] = $result[0]['img-alt'];
      }
    }

    return $variables;
  }

}
