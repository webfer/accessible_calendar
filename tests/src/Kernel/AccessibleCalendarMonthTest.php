<?php

declare(strict_types=1);

namespace Drupal\Tests\accessible_calendar\Kernel;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Tests\views\Kernel\Plugin\PluginKernelTestBase as ViewsTestBase;
use Drupal\views\Tests\ViewTestData;
use Drupal\views\ViewExecutable;
use Drupal\views\Views;

/**
 * Test Accessible Calendar Month style plugin works correctly.
 *
 * @group accessible_calendar
 */
class AccessibleCalendarMonthTest extends ViewsTestBase {

  /**
   * {@inheritdoc}
   */
  protected $strictConfigSchema = FALSE;

  /**
   * Views used by this test.
   *
   * @var array
   */
  public static $testViews = ['accessible_calendar_by_month_test'];

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'node',
    'user',
    'accessible_calendar',
    'accessible_calendar_test_config',
  ];

  /**
   * {@inheritDoc}
   */
  protected function setUp($import_test_views = TRUE): void {
    parent::setUp(FALSE);

    if ($import_test_views) {
      ViewTestData::createTestViews(static::class, ['accessible_calendar_test_config']);
    }
  }

  /**
   * Tests the Accessible Calendar by month style.
   */
  public function testAccessibleCalendarByMonth(): void {
    $view = Views::getView('accessible_calendar_by_month_test');
    $this->prepareView($view);

    // Render an empty view to quickly check texts in the output.
    $view->executed = TRUE;
    $view->result = [];
    $output = $view->preview();
    $output = \Drupal::service('renderer')->renderRoot($output);

    // Test calendar_timestamp.
    /** @var \Drupal\Core\Datetime\DrupalDateTime $now */
    $now = new DrupalDateTime();
    $style_plugin = $view->style_plugin;
    $this->assertCondition($style_plugin->options['calendar_timestamp'] == 'today', 'Calendar timestamp not set up properly by default.');
    $this->assertOutputContains($output, '<caption>' . $now->format('F Y') . '</caption>', 'Calendar timestamp not rendered properly.');
    $this->assertOutputContains($output, 'data-calendar-view-today', 'Current day not rendered properly.');

    // Test pagination.
    $pager = $view->pager;
    $previous = clone $now;
    $previous->modify('-1 month');
    $next = clone $now;
    $next->modify('+1 month');
    $this->assertCondition($pager->options['use_previous_next'] == 1, 'Month pagination not set up properly by default.');
    $this->assertOutputContains($output, 'aria-label="Previous month, ' . $previous->format('F Y') . '"', 'Link to previous month not correct.');
    $this->assertOutputContains($output, 'aria-label="Next month, ' . $next->format('F Y') . '"', 'Link to last month not correct.');
    $this->assertOutputContains($output, 'aria-label="Calendar navigation"', 'Pager landmark label should be rendered.');
    $this->assertOutputContains($output, 'data-accessible-calendar-current-period="Showing ' . $now->format('F Y') . '"', 'Pager should expose the current period announcement.');
    $this->assertOutputContains($output, 'aria-current="date"', 'Current pager item should expose aria-current.');
    $this->assertOutputContains($output, 'accessible-calendar-day__label visually-hidden', 'Day cells should include hidden date summaries for assistive technologies.');

    // @todo what other tests would be useful?
  }

  /**
   * Prepares a view executable by initializing everything which is needed.
   *
   * @param \Drupal\views\ViewExecutable $view
   *   The executable to prepare.
   *
   * @see \Drupal\Tests\views\Kernel\Plugin\StyleTableUnitTest
   */
  protected function prepareView(ViewExecutable $view): void {
    $view->setDisplay();
    $view->initStyle();
    $view->initHandlers();
    $view->initQuery();
  }

  /**
   * Asserts that a condition is TRUE.
   *
   * @param bool $condition
   *   The condition to evaluate.
   * @param string $message
   *   The failure message.
   */
  protected function assertCondition(bool $condition, string $message): void {
    if (!$condition) {
      throw new \RuntimeException($message);
    }
  }

  /**
   * Asserts that rendered output contains an expected fragment.
   *
   * @param string $output
   *   The rendered output.
   * @param string $expected
   *   The expected fragment.
   * @param string $message
   *   The failure message.
   */
  protected function assertOutputContains(string $output, string $expected, string $message): void {
    if (!str_contains($output, $expected)) {
      throw new \RuntimeException($message);
    }
  }

}
