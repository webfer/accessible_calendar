<?php

namespace Drupal\accessible_calendar\Plugin\views\pager;

use Drupal\Core\Form\FormStateInterface;

/**
 * The plugin to handle full pager.
 *
 * @ingroup views_pager_plugins
 *
 * @ViewsPager(
 *   id = "accessible_calendar_month",
 *   title = @Translation("Accessible Calendar navigation by month"),
 *   short_title = @Translation("Navigation by month"),
 *   help = @Translation("Create a navigation by month for your Accessible Calendar Views."),
 *   display_types = {"calendar"},
 *   theme = "accessible_calendar_pager"
 * )
 */
class AccessibleCalendarMonthPager extends AccessibleCalendarPagerBase {

  /**
   * {@inheritDoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);

    $date_formatter = \Drupal::service('date.formatter');
    $example_timestamp = strtotime('2023-01-01 00:00:00');

    $form['label_format']['#description'] .= '<br>' .
      '- <code>M</code>' . ' ' . $this->t('results in @output', [
        '@output' => $date_formatter->format($example_timestamp, 'custom', 'M'),
      ]);
  }

}
