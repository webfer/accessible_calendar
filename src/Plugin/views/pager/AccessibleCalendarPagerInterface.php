<?php

namespace Drupal\accessible_calendar\Plugin\views\pager;

/**
 * Defines required methods class for Accessible Calendar pager plugin.
 */
interface AccessibleCalendarPagerInterface {

  /**
   * Retrieve the calendar date from the Accessible Calendar style plugin.
   *
   * @return int
   *   The timestamp (default: now).
   */
  public function getCalendarTimestamp(): int;

}
