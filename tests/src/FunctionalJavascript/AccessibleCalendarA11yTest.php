<?php

declare(strict_types=1);

namespace Drupal\Tests\accessible_calendar\FunctionalJavascript;

use Drupal\FunctionalJavascriptTests\WebDriverTestBase;

/**
 * Browser-level accessibility tests for Accessible Calendar.
 *
 * @group accessible_calendar
 */
class AccessibleCalendarA11yTest extends WebDriverTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'node',
    'user',
    'views',
    'accessible_calendar',
    'accessible_calendar_test_config',
  ];

  /**
   * Tests calendar pager accessibility on a rendered page.
   */
  public function testCalendarPagerAccessibility(): void {
    $user = $this->drupalCreateUser(['access content']);
    $this->drupalLogin($user);

    $this->drupalGet('accessible-calendar-test/month');

    $page = $this->getSession()->getPage();

    if ($this->getSession()->getStatusCode() !== 200) {
      throw new \RuntimeException('Calendar test page did not load successfully.');
    }

    foreach ([
      'nav.accessible-calendar-pager-nav[aria-label="Calendar navigation"]',
      '.accessible-calendar-pager__current[aria-current="date"]',
      '.accessible-calendar-day__label.visually-hidden',
    ] as $selector) {
      if (!$page->find('css', $selector)) {
        throw new \RuntimeException(sprintf('Expected selector not found: %s', $selector));
      }
    }

    $page->clickLink('Next');

    if (!$page->waitFor(10, function () use ($page) {
      $announce = $page->find('css', '#drupal-live-announce');
      return $announce && str_contains($announce->getText(), 'Showing');
    })) {
      throw new \RuntimeException('Expected calendar live announcement after Ajax pager navigation.');
    }

    if (!$page->waitFor(10, function () {
      return $this->getSession()->evaluateScript(
        'document.activeElement && document.activeElement.tagName === "CAPTION"',
      );
    })) {
      throw new \RuntimeException('Expected focus to move to the calendar caption after Ajax update.');
    }
  }

}