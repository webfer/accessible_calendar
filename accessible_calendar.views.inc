<?php

/**
 * @file
 * Provide views data for accessible_calendar.module.
 */

use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Implements hook_views_data().
 */
function accessible_calendar_views_data() {
  $data['views']['accessible_calendar_timestamp'] = [
    'title' => t('Jump to'),
    'group' => t('Accessible Calendar'),
    'help' => t('Allow users to jump to any specific point in time using %dateformats.', [
      '%dateformats' => Link::fromTextAndUrl(
        t('date formats'),
        Url::fromUri('https://www.php.net/manual/en/datetime.formats.php', ['attributes' => ['target' => '_blank']])
      )->toString(),
    ]),
    'filter' => [
      'id' => 'accessible_calendar_timestamp',
      'allow empty' => TRUE,
    ],
  ];

  return $data;
}
