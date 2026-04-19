# Accessible Calendar

Accessible Calendar provides month and week calendar displays for Views results in Drupal, with a strong accessibility focus that improves navigation, announcements, and day context for assistive technology users.

It is a lightweight Views-based solution for presenting existing content in a calendar without introducing a separate event model. The module works with standard Views results and selected date fields, then renders them as accessible calendar displays with custom navigation and theming.

The project includes an optional submodule for improved multiday event rendering.

## Features

- Month and week calendar Views style plugins.
- Custom month and week pager plugins for calendar navigation.
- Accessible pager markup with a navigation landmark and `aria-current` support.
- AJAX update announcements for assistive technology users.
- Focus management after AJAX navigation.
- Hidden day summaries for screen reader users.
- Configurable first day of the week.
- Optional work-week mode in week view.
- Tokenized calendar titles and row title attributes.
- Optional display of the original Views rows alongside the calendar.
- Exposed `Jump to` filter based on the `calendar_timestamp` query argument.
- Optional multiday companion submodule.

## Requirements

- Drupal 10 or Drupal 11.
- Drupal core Views.
- At least one supported date field added to the View display.

## Installation

Install the module with Composer:

```bash
composer require drupal/accessible_calendar
```

Enable the main module:

```bash
drush en accessible_calendar
```

If you need multiday event rendering, enable the optional submodule too:

```bash
drush en accessible_calendar_multiday
```

## Usage

1. Create or edit a View.
2. Add one or more date fields to the View. You can exclude them from display if needed.
3. In Format, choose `Calendar by month` or `Calendar by week`.
4. In the calendar style settings, select the date field or fields to use.
5. Configure the remaining calendar options, such as the first day of the week, title format, or work-week mode.
6. Under Pager, select the matching calendar pager plugin.
7. Enable AJAX on the display if you want in-place calendar navigation.
8. Optionally expose the `Jump to` filter to let users move directly to a specific period.

## Included Views Plugins

Style plugins:

- `calendar_month` - Calendar by month
- `calendar_week` - Calendar by week

Pager plugins:

- `accessible_calendar_month` - Accessible Calendar navigation by month
- `accessible_calendar_week` - Accessible Calendar navigation by week

Filter plugin:

- `accessible_calendar_timestamp` - Jump to

## Accessibility

Accessible Calendar is designed to provide accessible output by default.

- Calendar updates are announced after AJAX navigation.
- Focus moves to the calendar caption after AJAX updates.
- Day cells include hidden summaries to provide day context and result counts.
- The pager identifies the current period with `aria-current`.
- Calendar output uses semantic table markup and dedicated templates.

## Multiday Submodule

The included `Accessible Calendar - Multiday` submodule improves rendering for events that span multiple days.

When enabled, it adds multiday metadata, classes, JavaScript, and CSS to help render continuous event segments across cells.

## Performance Notes

This module works best when Views filters limit the amount of data returned.

For large datasets, and especially for recurring date data, configure Views filters so the display only loads a sensible time window around the current calendar period.

## Similar Projects

- [Calendar View](https://www.drupal.org/project/calendar_view) for a more general lightweight Views calendar.
- [Calendar](https://www.drupal.org/project/calendar) for a deeper calendar integration.
- [FullCalendar View](https://www.drupal.org/project/fullcalendar_view) for a JavaScript-driven calendar display.

## Acknowledgement

Accessible Calendar builds on the lightweight Views-based approach established by Drupal's [Calendar View](https://www.drupal.org/project/calendar_view) project, with an explicit focus on stronger accessibility, including improved pager semantics, announcements, focus handling, and day summaries. Credit goes to the Calendar View maintainers and contributors, especially Matthieu Scarset, for the original groundwork.

## Sponsorship

Development of this module is sponsored by [Tothomweb](https://tothomweb.com/).

## Maintainers

- [WebFer](https://github.com/webfer)
