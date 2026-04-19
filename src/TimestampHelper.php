<?php

namespace Drupal\accessible_calendar;

/**
 * Shared timestamp parsing and validation helpers.
 */
class TimestampHelper {

  /**
   * Validates whether a value can be converted to a timestamp.
   *
   * @param mixed $value
   *   A timestamp-like value.
   *
   * @return bool
   *   TRUE when the value can be converted to a timestamp.
   */
  public function ensureTimestampValue($value): bool {
    return $this->parseTimestampValue($value) !== NULL;
  }

  /**
   * Converts a supported value to a timestamp.
   *
   * @param mixed $value
   *   A timestamp-like value.
   *
   * @return int
   *   The normalized timestamp, or 0 when invalid.
   */
  public function normalizeTimestampValue($value): int {
    return $this->parseTimestampValue($value) ?? 0;
  }

  /**
   * Parses a supported value into a timestamp.
   *
   * @param mixed $value
   *   A timestamp-like value.
   *
   * @return int|null
   *   The parsed timestamp, or NULL when invalid.
   */
  protected function parseTimestampValue($value): ?int {
    if (is_int($value)) {
      return $value;
    }

    if (is_float($value)) {
      return (int) $value;
    }

    if (is_string($value)) {
      $value = trim($value);
      if ($value === '') {
        return NULL;
      }
    }

    if (is_numeric($value)) {
      return (int) $value;
    }

    if (!is_string($value)) {
      return NULL;
    }

    $timestamp = strtotime($value);
    return $timestamp !== FALSE ? $timestamp : NULL;
  }

}