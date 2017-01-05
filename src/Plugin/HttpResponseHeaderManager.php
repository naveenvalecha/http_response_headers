
<?php

namespace Drupal\http_response_headers\Plugin;

use Drupal\Component\Plugin\FallbackPluginManagerInterface;
use Drupal\Core\Plugin\CategorizingPluginManagerTrait;
use Drupal\Core\Plugin\Context\ContextAwarePluginManagerTrait;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the HttpResponseHeader plugin manager.
 */
/**
 * Manages discovery and instantiation of HttpResponseHeader plugins.
 *
 * @todo Add documentation to this class.
 *
 * @see \Drupal\http_response_headers\Plugin\HttpResponseHeaderInterface
 */
class HttpResponseHeaderManager extends DefaultPluginManager implements HttpResponseHeaderInterface, FallbackPluginManagerInterface {

  use CategorizingPluginManagerTrait {
    getSortedDefinitions as traitGetSortedDefinitions;
    getGroupedDefinitions as traitGetGroupedDefinitions;
  }
  use ContextAwarePluginManagerTrait;

  /**
   * Constructor for HttpResponseHeaderManager objects.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/HttpResponseHeader', $namespaces, $module_handler, 'Drupal\http_response_headers\Plugin\HttpResponseHeaderInterface', 'Drupal\http_response_headers\Annotation\HttpResponseHeader');

    $this->alterInfo('http_response_header_info');
    $this->setCacheBackend($cache_backend, 'http_response_header');
  }

  /**
   * {@inheritdoc}
   */
  public function processDefinition(&$definition, $plugin_id) {
    parent::processDefinition($definition, $plugin_id);
    $this->processDefinitionCategory($definition);
  }

  /**
   * {@inheritdoc}
   */
  public function getSortedDefinitions(array $definitions = NULL) {
    // Sort the plugins first by category, then by label.
    $definitions = $this->traitGetSortedDefinitions($definitions, 'admin_label');
    // Do not display the 'broken' plugin in the UI.
    unset($definitions['broken']);
    return $definitions;
  }

  /**
   * {@inheritdoc}
   */
  public function getGroupedDefinitions(array $definitions = NULL) {
    $definitions = $this->traitGetGroupedDefinitions($definitions, 'admin_label');
    // Do not display the 'broken' plugin in the UI.
    unset($definitions[$this->t('Block')]['broken']);
    return $definitions;
  }

s  /**
   * {@inheritdoc}
   */
  public function getFallbackPluginId($plugin_id, array $configuration = array()) {
    return 'broken';
  }

}
