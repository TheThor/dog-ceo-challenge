<?php

namespace Drupal\dog_ceo_block_admin_config\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * DogSlugBlockConfigForm for the block that displays an image.
 */
class DogSlugBlockConfigForm extends ConfigFormBase {

  /**
   * Override for constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   Config factory injection.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    parent::__construct($config_factory);
  }

  /**
   * Override for parent.
   *
   * @return string[]
   *   Returns editable config settings for this.
   */
  protected function getEditableConfigNames() {
    return ['dog_ceo_block_admin_config.settings'];
  }

  /**
   * Gets form id.
   *
   * @return string
   *   Returns the string of the form id.
   */
  public function getFormId() {
    return 'dog_ceo_block_admin_config_form';
  }

  /**
   * Build the form.
   *
   * @param array $form
   *   Form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   *
   * @return array
   *   Returns the built form array.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('dog_ceo_block_admin_config.settings');

    $form['dog_ceo_block_admin_config'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Slug Configuration'),
    ];
    $form['dog_ceo_block_admin_config']['slug'] = [
      '#type' => 'textfield',
      '#maxlength' => 40,
      '#required' => TRUE,
      '#description' => $this->t(
        'Please enter a Slug for the block that will display a breed image from the <a href=":url">dog breed list</a>.',
        [':url' => 'https://dog-ceo.lndo.site/breed']
      ),
      '#title' => $this->t("Dog Breed Slug"),
      '#default_value' => $config->get('slug'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * Submit the config form.
   *
   * @param array $form
   *   Form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('dog_ceo_block_admin_config.settings');
    $config
      ->set('slug', $form_state->getValue('slug'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
