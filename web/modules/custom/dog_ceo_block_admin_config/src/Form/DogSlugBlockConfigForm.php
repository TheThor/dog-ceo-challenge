<?php

namespace Drupal\dog_ceo_block_admin_config\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class DogSlugBlockConfigForm extends ConfigFormBase
{
  public function __construct(ConfigFactoryInterface $config_factory)
  {
    parent::__construct($config_factory);
  }

  protected function getEditableConfigNames()
  {
    return ['dog_ceo_block_admin_config.settings'];
  }

  public function getFormId()
  {
    return 'dog_ceo_block_admin_config_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state)
  {
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
    return parent::buildForm($form, $form_state); // TODO: Change the autogenerated stub
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $config = $this->config('dog_ceo_block_admin_config.settings');
    $config
      ->set('slug', $form_state->getValue('slug'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}