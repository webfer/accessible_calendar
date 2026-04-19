<?php

namespace Drupal\accessible_calendar\Plugin\views\filter;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Plugin\views\filter\Date;

/**
 * Accessible Calendar filter to "Jump to" a given date and/or time.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("accessible_calendar_timestamp")
 */
class AccessibleCalendarTimestamp extends Date {

  /**
   * {@inheritDoc}
   */
  public function validateExposed(&$form, FormStateInterface $form_state) {
    // Check input is an acceptable date format.
    $identifier = $this->options['expose']['identifier'];
    $value = &$form_state->getValue($identifier);
    if (empty($value)) {
      return;
    }
    elseif (!\Drupal::service('accessible_calendar.timestamp')->ensureTimestampValue($value)) {
      $form_state->setError($form[$identifier], $this->t('Invalid date format.'));
      return;
    }

    // Marks as required to check date format as per core.
    $value = ['value' => $value];
    $this->options['expose']['required'] = TRUE;
    parent::validateExposed($form, $form_state);
  }

  /**
   * No query for us. We just want the query arg to be populated.
   */
  public function query() {
    return;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(), ['url.query_args:calendar_timestamp']);
  }

}
