HTTP Response Headers
=====================
This module provides a way to  set HTTP headers on pages by various visibility
settings. Currently the headers can be set by path, content type and user role.

Installation:
-------------

Install as you would normally install a contributed Drupal module. See:
https://www.drupal.org/docs/8/extending-drupal/installing-contributed-modules
for further information.

Features:
---------

1.  Configure list of allowed headers

2.  Exclude non-functional pages (e.g. Admin pages) globally

3.  Drush extension to cover all functionality

4.  Page level header rule caching

5.  Export/import (using Ctool) header rules from an inc file
    (MODULE.http_response_headers_default_rule.inc) or hook implementation
    (hook_http_response_headers_default_rule())
