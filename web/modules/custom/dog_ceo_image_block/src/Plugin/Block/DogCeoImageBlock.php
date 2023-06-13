<?php

namespace Drupal\dog_ceo_image_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\dog_ceo_api_rest\Services\DogBreedImageService;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Dog Breed Image Block to place on a page.
 *
 * @Block(
 *   id = "dog_ceo_image_block",
 *   admin_label = @Translation("Dog Breed Image Block"),
 * )
 */
class DogCeoImageBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Dog breed service property.
   *
   * @var \Drupal\dog_ceo_api_rest\Services\DogBreedImageService
   */
  private DogBreedImageService $dogBreedImageService;

  /**
   * Constructor for the block.
   *
   * @param array $configuration
   *   Configuration injection.
   * @param string $plugin_id
   *   Plugin_id injection.
   * @param array $plugin_definition
   *   Plugin Definition.
   * @param \Drupal\dog_ceo_api_rest\Services\DogBreedImageService $dogBreedImageService
   *   DogBreedImageService injection.
   */
  public function __construct(array $configuration,
      $plugin_id,
      $plugin_definition,
      DogBreedImageService $dogBreedImageService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dogBreedImageService = $dogBreedImageService;
  }

  /**
   * Create for dependency injection.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   ContainerInterface injector.
   * @param array $configuration
   *   Configuration array init.
   * @param string $plugin_id
   *   Plugin id init.
   * @param array $plugin_definition
   *   Plugin definition init.
   *
   * @return \Drupal\dog_ceo_image_block\Plugin\Block\DogCeoImageBlock|static
   *   Returns the block.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('dog_ceo_image.service'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge(): int {
    return 1;
  }

  /**
   * Build for the block.
   *
   * @return array
   *   Returns build array.
   */
  public function build(): array {
    $variables = $this->dogBreedImageService->getRandomDogOfTheDayImage();
    return [
      '#theme' => 'dog_ceo_image_block',
      '#title' => 'Random Dog Breed of the day',
      '#dog_breed_name'  => $variables['title'],
      '#dog_breed_image' => $variables['img-url'],
      '#dog_breed_alt'   => $variables['img-alt'],
    ];
  }

}
