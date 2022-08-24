<?php

namespace Drupal\ckeditor_mentions_notifications\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Ckeditor Mentions Notifications configuration form
 */
class CkeditorMentionsNotificationsConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {

    return ['ckeditor_mentions_notification.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {

    return 'ckeditor_mentions_notifications_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ckeditor_mentions_notification.settings');
    $form['general']['email_subject'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Email Subject'),
      '#token_types' => ['user'],
      '#description' => $this->t('The email subject.'),
      '#default_value' => $config->get('mentions_notifications_email_subject') ?? '[comment:author] has mentioned you',
      '#required' => TRUE,
    ];
    $form['general']['email_body']= [
      '#type' => 'textarea',
      '#title' => $this->t('Email Body'),
      '#token_types' => ['user'],
      '#description' => $this->t('The email body.'),
      '#default_value' => $config->get('mentions_notifications_email_body') ?? 'You have been mentioned here [comment:url]',
      '#required' => TRUE,
      '#resizeable' => TRUE,
    ];

    // Add the token tree UI.
    $form['general']['token_help'] = [
      '#theme' => 'token_tree_link',
      '#token_types' => ['ckeditor_mentions_notifications'],
      '#global_types' => FALSE,
    ];
    return parent::buildForm($form, $form_state);
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->configFactory()
      ->getEditable('ckeditor_mentions_notification.settings');
    $config->set('mentions_notifications_email_subject', $form_state->getValue('email_subject'));
    $config->set('mentions_notifications_email_body', $form_state->getValue('email_body'));
    $config->save();
    parent::submitForm($form, $form_state);
  }
}
