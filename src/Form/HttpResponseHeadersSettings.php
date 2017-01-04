<?php

namespace Drupal\http_response_headers\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure site information settings for this site.
 */
class HttpResponseHeadersSettings extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'http_response_headers_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['http_response_headers.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('http_response_headers.settings');
    $form['http_response_headers']['label'] = [
      '#title' => $this->t('Currently enabled headers:'),
      '#theme' => 'item_list',
      '#items' => unserialize($config->get('allowed_headers')) ?: [],
    ];
    $form['http_response_headers']['allowed_headers'] = [
      '#type' => 'select',
      '#title' => $this->t('Allowed headers'),
      '#default_value' => unserialize($config->get('allowed_headers')) ?: [],
      '#options' => $this->allResponseHeaders(),
      '#multiple' => TRUE,
      '#size' => 10,
      '#description' => $this->t('Allowed headers to set via admin UI on HTTP response headers page.'),
    ];
    $form['http_response_headers']['exclude_pages'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Exclude header rule pages'),
      '#rows' => '5',
      '#default_value' => $config->get('exclude_pages'),
      '#description' => $this->t('Excludes header rule check on this pages.'),
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $config = $this->config('http_response_headers.settings');
    $config->set('allowed_headers', serialize($values['allowed_headers']))
      ->set('exclude_pages', $values['exclude_pages'])
      ->save();
    parent::submitForm($form, $form_state);

  }

  /**
   * Provides response headers.
   *
   * @return array
   *   An array of response headers.
   */
  public function allResponseHeaders() {

    // Standard response headers.
    $headers['Standard response headers'] = [
      'Access-Control-Allow-Origin',
      'Accept-Ranges',
      'Age',
      'Allow',
      'Cache-Control',
      'Connection',
      'Content-Encoding',
      'Content-Language',
      'Content-Length',
      'Content-Location',
      'Content-MD5',
      'Content-Disposition',
      'Content-Range',
      'Content-Type',
      'Date',
      'ETag',
      'Expires',
      'Last-Modified',
      'Link',
      'Location',
      'P3P',
      'Pragma',
      'Proxy-Authenticate',
      'Refresh',
      'Retry-After',
      'Server',
      'Set-Cookie',
      'Status',
      'Strict-Transport-Security',
      'Trailer',
      'Transfer-Encoding',
      'Vary',
      'Via',
      'Warning',
      'WWW-Authenticate',
    ];

    // Non-standard response headers.
    $headers['Common non-standard response headers'] = [
      'X-Frame-Options',
      'X-XSS-Protection',
      'Content-Security-Policy',
      'X-Content-Security-Policy',
      'X-WebKit-CSP',
      'X-Content-Type-Options',
      'X-Powered-By',
      'X-UA-Compatible',
      'X-Permitted-Cross-Domain-Policies',
    ];

    // Map key.
    foreach ($headers as $title => $header_set) {
      $return_list[$title] = array_combine($header_set, $header_set);
    }

    return $return_list;
  }

}
