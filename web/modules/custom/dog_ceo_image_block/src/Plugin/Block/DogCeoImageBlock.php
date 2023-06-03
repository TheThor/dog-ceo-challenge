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
   * @var DogBreedImageService
   */
  private DogBreedImageService $dogBreedImageService;

  /**
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\dog_ceo_api_rest\Services\DogBreedImageService $dogBreedImageService
   */
  public function __construct(array $configuration,
      $plugin_id,
      $plugin_definition,
      DogBreedImageService $dogBreedImageService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->dogBreedImageService = $dogBreedImageService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('dog_ceo_image.service')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheMaxAge(): int {
    return 1;
  }



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
