<?php

declare(strict_types=1);

namespace Drupal\Tests\accessible_calendar\Kernel;

use Drupal\Core\Template\Attribute;
use Drupal\KernelTests\KernelTestBase;

/**
 * Tests multiday preprocess output.
 *
 * @group accessible_calendar
 */
class AccessibleCalendarMultidayTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'accessible_calendar',
    'accessible_calendar_multiday',
  ];

  /**
   * Tests that multiday metadata is persisted back to template variables.
   */
  public function testMultidayRowAttributesArePersisted(): void {
    $variables = [
      'rows' => [
        [
          '#values' => [
            'instance' => 0,
            'instances' => 3,
          ],
          'attributes' => new Attribute(['class' => ['accessible-calendar-day__row']]),
        ],
      ],
    ];

    accessible_calendar_multiday_preprocess_accessible_calendar_day($variables);

    $attribute_markup = (string) $variables['rows'][0]['attributes'];

    foreach ([
      'data-accessible-calendar-instance="0"',
      'data-accessible-calendar-instances="3"',
      'is-multi',
      'is-multi--first',
      'accessible-calendar-day__row',
    ] as $expected_fragment) {
      if (!str_contains($attribute_markup, $expected_fragment)) {
        throw new \RuntimeException(sprintf('Expected multiday attribute fragment not found: %s', $expected_fragment));
      }
    }
  }

}