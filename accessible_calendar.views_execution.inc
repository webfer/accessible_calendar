<?php

/**
 * @file
 * Provides views runtime hooks for accessible_calendar.module.
 */

use Drupal\accessible_calendar\Plugin\views\style\AccessibleCalendarInterface;
use Drupal\views\ViewExecutable;

/**
 * Implements hook_views_pre_view().
 */
function accessible_calendar_views_pre_view(ViewExecutable $view) {
  $display_id = $view->current_display;
  /** @var \Drupal\accessible_calendar\Plugin\views\style\AccessibleCalendarInterface $style */
  $style = $view->displayHandlers->get($display_id)->getPlugin('style');
  if ($style instanceof AccessibleCalendarInterface) {
    $style->makeFilterValuesRelative();
  }
}
