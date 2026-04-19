<?php

namespace Drupal\accessible_calendar\Plugin\views\style;

/**
 * Defines required methods class for Accessible Calendar style plugin.
 */
interface AccessibleCalendarInterface {

  /**
   * Retrieve the calendar date.
   *
   * @return int
   *   A UNIX timestamp.
   */
  public function getCalendarTimestamp(): int;

  /**
   * Build the list of calendars.
   *
   * @param int $selected_timestamp
   *   The calendar timestamp.
   *
   * @return array
   *   A list of renderable arrays.
   */
  public function buildCalendars(int $selected_timestamp): array;

}
