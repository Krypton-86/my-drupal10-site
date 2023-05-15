<?php

namespace Drupal\movie_directory\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class MovieAPI extends FormBase {

  const MOVIE_API_CONFIG_PAGE = 'movie_api_config_page:values';

  public function getFormId() {
    return 'movie_api_config_page';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $values = \Drupal::state()->get(self::MOVIE_API_CONFIG_PAGE);

    $form = [];

    $form['api_base_url'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API Base URL'),
      '#description' => $this->t('This is the Base URL'),
      '#required' => TRUE,
      '#default_value' => $values['api_base_url'],
    ];

    $form['api_key'] = [
      '#type' => 'textfield',
      '#title' => $this->t('API KEY'),
      '#description' => $this->t('This is the API KEY'),
      '#required' => TRUE,
      '#default_value' => $values['api_key'],
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $submitted_values = $form_state->cleanValues()->getValues();
    \Drupal::state()->set(self::MOVIE_API_CONFIG_PAGE, $submitted_values);

    $messenger = \Drupal::messenger();
    $messenger->addMessage($this->t('Your config has been saved'));
  }

}
