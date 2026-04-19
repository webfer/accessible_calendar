# Accessible Calendar

🗓️ A Drupal Views-based calendar module that renders entities in accessible month and week calendar displays, with custom pager navigation, day-cell theming, and optional multiday rendering.

---

## 📌 Module Overview

- Name: Accessible Calendar
- Location: `web/modules/contrib/accessible_calendar`
- Status: Stable
- Compatibility: Drupal 10 and Drupal 11
- Dependency: Drupal Views

This module provides custom Views plugins and templates to turn standard View results into calendar-style displays.

It does not create event entities or date data itself. Instead, it works with existing Views results and selected date fields, then renders them as:

- Month calendars
- Week calendars
- Accessible pager navigation
- Themed day cells and result rows
- Optional multiday event rendering through a companion submodule

---

## ✨ Features

- Adds a month calendar Views style plugin.
- Adds a week calendar Views style plugin.
- Adds custom month and week pager plugins for calendar navigation.
- Renders calendar output through dedicated Twig templates for the overall calendar, day cells, and pager.
- Supports AJAX calendar updates and announces period changes for assistive technology users.
- Moves focus to the calendar caption after AJAX pager navigation.
- Outputs hidden day summaries for screen readers in each day cell.
- Adds semantic pager markup, including a navigation landmark and `aria-current` for the current period.
- Lets site builders choose which date field or fields the calendar should use.
- Supports tokenized calendar titles and tokenized row title attributes.
- Supports configurable first day of the week.
- Supports an optional weekly work-week mode that hides weekends in week view.
- Supports optional display of the default Views result rows alongside the calendar.
- Provides a `Jump to` Views filter so users can navigate to a specific point in time through the `calendar_timestamp` query argument.
- Adds cache context handling for `calendar_timestamp` query arguments.
- Includes a default front-end library with calendar CSS and accessibility JavaScript.
- Includes browser-level and kernel-level tests for rendering and accessibility behavior.

Optional companion modules included in this package:

- `Accessible Calendar - Multiday` adds multiday row metadata, classes, JavaScript, and styling for events spanning multiple days.

---

## 🔗 Dependencies

This module depends on the following pieces to work correctly:

- Drupal core Views.
- At least one supported Views date field in the display.
- A Views display configured to use the provided calendar style plugins.

Optional dependencies and extensions:

- `accessible_calendar_multiday` if you need multiday visual grouping and multiday row metadata.

The default front-end library is defined in `accessible_calendar.libraries.yml` and attaches:

- `css/accessible-calendar.css`
- `css/accessible-calendar.default.css`
- `js/accessible-calendar.a11y.js`

---

## 🚀 Installation / Usage

1. Enable `Accessible Calendar`.
2. Create or edit a View that uses fields.
3. Add at least one supported date field to the View.
4. Change the View style to one of the calendar styles provided by this module.
5. Choose the date field in the calendar style settings.
6. Select the matching calendar pager if you want previous and next calendar navigation.

Available Views plugins:

- Style plugin `calendar_month`: Calendar by month
- Style plugin `calendar_week`: Calendar by week
- Pager plugin `accessible_calendar_month`: Accessible Calendar navigation by month
- Pager plugin `accessible_calendar_week`: Accessible Calendar navigation by week
- Filter plugin `accessible_calendar_timestamp`: Jump to

The module is rendered automatically through the Views integration and its Twig templates.

Optional additions:

- Enable `Accessible Calendar - Multiday` if your content spans multiple days and should render as one continuous event sequence across cells.

---

## ⚙️ Configuration Notes

The main configuration lives in the Views style and pager settings.

Available calendar style options include:

- `calendar_fields`: Which date fields are used to place rows in the calendar.
- `calendar_display_rows`: Whether to also show the original Views result rows.
- `calendar_weekday_start`: Which weekday starts the calendar.
- `calendar_sort_order`: Sort order used by the calendar output.
- `calendar_timestamp`: Default visible date or period.
- `calendar_title`: Tokenized calendar caption.
- `calendar_row_title`: Tokenized title attribute for each result row.

Week view adds:

- `calendar_work_week`: Hide weekend days.

Pager configuration includes:

- `label_format`: The date format used for pager labels.
- `use_previous_next`: Whether previous and next links are shown.
- `display_reset`: Whether a reset action is displayed.

Important behavior note:

- This module works best when Views filters limit the amount of data returned.
- The project ADR explains that large recurring or smart date result sets should be constrained at the View level instead of inside the style plugin query logic.

---

## 🧩 Submodules

### Accessible Calendar - Multiday

- Location: `web/modules/contrib/accessible_calendar/modules/accessible_calendar_multiday`
- Purpose: Improve rendering of events spanning multiple days.

This submodule:

- Attaches an additional multiday library.
- Adds `data-accessible-calendar-instance` and `data-accessible-calendar-instances` attributes.
- Adds `is-multi`, `is-multi--first`, `is-multi--middle`, and `is-multi--last` classes.
- Applies multiday-specific styling and grouped front-end behavior.

Without this submodule, the base calendar still renders rows, but multiday-specific metadata and multiday visual behavior are not added.

## 🏗️ Structure

### Core Module Files

```text
accessible_calendar/
├── ADR.md
├── accessible_calendar.info.yml
├── accessible_calendar.libraries.yml
├── accessible_calendar.module
├── accessible_calendar.services.yml
├── accessible_calendar.theme.inc
├── accessible_calendar.views.inc
├── accessible_calendar.views_execution.inc
├── config/
│   └── schema/
├── css/
├── js/
├── src/
│   └── Plugin/views/
├── templates/
└── tests/
```

### Included Submodules

```text
accessible_calendar/modules/
└── accessible_calendar_multiday/
```

### Main Templates

The module renders through these templates:

- `templates/views-view-calendar.html.twig`
- `templates/views-view--style--calendar.html.twig`
- `templates/accessible-calendar-day.html.twig`
- `templates/accessible-calendar-pager.html.twig`

---

## 🛠️ Working With This Module

When updating or extending the module:

- Keep the Views style plugin IDs and pager plugin IDs distinct.
- Preserve expected calendar markup classes unless you also update the CSS and JS behaviors.
- If you change AJAX pager behavior, verify announcements and focus handling still work.
- If you change day-cell output, verify hidden summaries and pager semantics still remain accessible.
- If you rely on multiday rendering, make sure the multiday submodule is enabled.

---

## ♿ Accessibility Notes

- Calendar updates are announced with `Drupal.announce()` after AJAX pager navigation.
- Focus is moved to the calendar caption after AJAX updates.
- Day cells include hidden date summaries for screen reader users.
- The pager includes a navigation landmark and identifies the current period with `aria-current`.
- Calendar output is based on semantic table markup.
- Multiday grouped behavior includes dedicated row metadata and front-end grouping support when the multiday submodule is enabled.

---

## 🧪 Testing

The module includes automated coverage for rendering and accessibility behavior.

Current test coverage includes:

- Kernel tests for month calendar rendering.
- Kernel tests for multiday row metadata persistence.
- Functional JavaScript tests for pager accessibility, hidden labels, live announcements, and focus behavior.

---

## 🧪 Troubleshooting

- Calendar style is not available: confirm Views is enabled and the module is installed.
- Calendar output is empty: confirm the View has at least one supported date field selected in `calendar_fields`.
- Pager links look wrong or fail: confirm the display is using the matching accessible calendar pager plugin.
- AJAX updates do not announce changes: confirm the default calendar library is attached and JavaScript is loading.
- Multiday events do not render as grouped segments: confirm `Accessible Calendar - Multiday` is enabled.
- Large recurring datasets perform poorly: add stronger Views filters rather than relying on the calendar plugin to reduce data.

---

## ⚠️ Known Constraints

- The module depends on Views fields and selected date fields rather than creating a separate calendar data model.
- Rendering and styling are coupled to the current calendar markup structure.
- Large datasets, especially recurring date data, should be limited through Views filters.
- Multiday behavior is not part of the base module and requires the optional multiday submodule.

---

## 📜 Documentation Notes

- `ADR.md` is an Architectural Decision Record, not a required Drupal.org release file.
- It documents why the module relies on Views filters to constrain result sets.
- The ADR is useful for maintainers, but it is not required for installation or for Drupal.org publication.

---

## Acknowledgement

Accessible Calendar is based on the approach established by the Drupal
[Calendar View](https://www.drupal.org/project/calendar_view) project.

Calendar View demonstrated how a lightweight Views-based calendar can render
existing View results directly from selected date fields, with month and week
displays, calendar navigation, and minimal integration overhead.

This module builds on that foundation with an explicit accessibility focus,
including accessible pager semantics, AJAX announcements, focus management,
screen-reader day summaries, and optional multiday enhancements.

Credit goes to the Calendar View maintainers and contributors, especially
Matthieu Scarset, for the original project and the groundwork it provided.

---

## 📜 License

This module is proprietary software developed for [Tothomweb](https://tothomweb.com/). Reuse or modification requires permission from the maintainers.

---

_Maintained by [Tothomweb](https://tothomweb.com/) Development Team_ - [WebFer](https://www.linkedin.com/in/webfer/)
