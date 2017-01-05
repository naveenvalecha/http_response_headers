<?php

namespace Drupal\http_response_headers\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a HttpResponseHeader item annotation object.
 *
 * @see \Drupal\http_response_headers\Plugin\HttpResponseHeaderManager
 * @see plugin_api
 *
 * @Annotation
 */
class HttpResponseHeader extends Plugin {

  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

  /**
   * The group id of the plugin.
   *
   * @var string
   */
  public $group_id;

  /**
   * The group label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $group_label;

  /**
   * Full class name of the configuration form of your purger, with leading
   * backslash. Class must extend \Drupal\http_response_headers\Form\HttpResponseHeaderConfigFormBase.
   *
   * @var string
   */
  public $configform = '';

}
