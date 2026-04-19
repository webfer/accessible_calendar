<?php

namespace Drupal\accessible_calendar\Plugin\views\pager;

use Drupal\Core\Form\FormStateInterface;

/**
 * The plugin to handle full pager.
 *
 * @ingroup views_pager_plugins
 *
 * @ViewsPager(
 *   id = "accessible_calendar_week",
 *   title = @Translation("Accessible Calendar navigation by week"),
 *   short_title = @Translation("Navigation by week"),
 *   help = @Translation("Create a navigation by week for your Accessible Calendar Views."),
 *   display_types = {"calendar"},
 *   theme = "accessible_calendar_pager"
 * )
 */
class AccessibleCalendarWeekPager extends AccessibleCalendarPagerBase {

  /**
   * {@inheritDoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $date_formatter = \Drupal::service('date.formatter');
    $example_timestamp = strtotime('2023-09-04 00:00:00');

    $form['label_format']['#description'] .= '<br>' .
      '- <code>\w\e\e\k W</code>' . ' ' . $this->t('results in @output', [
        '@output' => $date_formatter->format($example_timestamp, 'custom', '\w\e\e\k W'),
      ]);
  }

  /**
   * {@inheritDoc}
   */
  public function getDatetimePrevious(\Datetime $now): \Datetime {
    $date = clone $now;
    $date->modify('first day last week');
    $date->setTime(0, 0, 0);
    return $date;
  }

  /**
   * {@inheritDoc}
   */
  public function getDatetimeNext(\Datetime $now): \Datetime {
    $date = clone $now;
    $date->modify('first day next week');
    $date->setTime(0, 0, 0);
    return $date;
  }

}
