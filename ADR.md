# Architectural Decision Record

This file records the main architectural decisions behind the current
`accessible_calendar` module setup.

The module is built as a Views-first calendar renderer for Drupal. It provides
calendar display plugins, pager plugins, templates, accessibility behavior, and
an optional multiday companion submodule.

---

## ADR-001 - Build on top of Drupal Views instead of introducing a custom event model

### Context

The module is meant to display existing Drupal entities in calendar form without
requiring a dedicated event storage model, a custom calendar entity type, or a
separate indexing layer.

Site builders already use Views to:

- select entity types
- choose fields
- add access control
- define filters and sorts
- configure page displays and exposed filters

### Decision

Use Drupal Views as the integration point.

The module provides custom Views plugins instead of a separate calendar data
model:

- style plugin `calendar_month`
- style plugin `calendar_week`
- pager plugin `accessible_calendar_month`
- pager plugin `accessible_calendar_week`
- filter plugin `accessible_calendar_timestamp`

### Consequences

- The calendar can be applied to existing View results instead of requiring a
  parallel content architecture.
- Site builders keep control over fields, filters, permissions, and page
  displays.
- The module depends on correctly configured Views fields, especially date
  fields.
- The module renders calendar output from View results rather than generating a
  separate event dataset.

---

## ADR-002 - Keep accessibility behavior in the base module

### Context

The module aims to provide accessible calendar output by default, not as an
afterthought layered only in themes or custom projects.

Calendar interfaces often fail in areas such as:

- unclear day context for screen reader users
- ambiguous pager navigation
- poor focus handling after AJAX updates
- missing non-visual context in day cells

### Decision

Ship accessibility semantics and behavior as part of the base module.

This includes:

- semantic calendar templates
- accessible pager markup
- hidden day summaries in day cells
- announcement and focus handling in `js/accessible-calendar.a11y.js`
- accessibility-oriented rendering tests

### Consequences

- Accessible output becomes the default module behavior.
- Themes can restyle the calendar without having to reimplement basic
  accessibility semantics.
- Future template and JavaScript changes must preserve these accessibility
  guarantees.

---

## ADR-003 - Keep multiday behavior in an optional companion submodule

### Context

Not every calendar display needs multiday event presentation.

Multiday rendering adds extra concerns:

- row instance metadata
- cross-cell styling
- grouped interaction behavior
- visual continuation logic for first, middle, and last segments

Those behaviors increase complexity compared to the base calendar rendering.

### Decision

Keep multiday behavior in the optional `accessible_calendar_multiday`
submodule.

The base module renders calendar rows normally. The multiday submodule extends
that behavior by adding:

- `data-accessible-calendar-instance`
- `data-accessible-calendar-instances`
- `is-multi`
- `is-multi--first`
- `is-multi--middle`
- `is-multi--last`
- dedicated multiday CSS and JavaScript

### Consequences

- The base module stays smaller and easier to reason about.
- Sites that need multiday rendering can enable it explicitly.
- Sites that do not need multiday rendering avoid the additional front-end and
  preprocess complexity.
- Multiday visual behavior is not available unless the submodule is enabled.

---

## ADR-004 - Use Views filters to limit the set of results

### Context

Accessible calendar queries can easily grow too large, especially when the date
field comes from recurring data such as smart date patterns. In those cases,
there may be very large numbers of entities and repeating instances to render.

We considered pushing more result-limiting logic into the style plugin query
layer. In practice this becomes fragile because Views date fields can come from
different tables and field structures, often with different suffixes such as
`_value` and `end_value`.

### Decision

Do not rely on the style plugin to solve large dataset management.

Instead, expect site builders to constrain the dataset through Views filters,
sorts, and date conditions.

### Consequences

- The module stays more predictable across different field storage setups.
- Query logic inside the calendar style plugin remains simpler.
- Site builders must configure sensible past and future limits in their Views.
- Large recurring datasets should be treated as a View design concern, not as a
  hidden module optimization.

### Resources

- [Recurring events guidance on Drupal.org](https://www.drupal.org/docs/contributed-modules/accessible_calendar/recurring-events-in-accessible-calendar#s-important-consider-limiting-the-view-results)

---

## ADR-005 - Treat package documentation separately from runtime requirements

### Context

The module package contains maintainer-facing documentation such as this ADR,
while runtime behavior is defined by the Drupal module files, templates, Views
plugins, and optional submodules.

### Decision

Keep `ADR.md` as maintainer documentation only.

It documents why the module is shaped the way it is, but it is not part of the
runtime contract and is not required for Drupal.org publication.

### Consequences

- The file helps maintainers understand architectural intent.
- The module can function normally without this file.
- Release readiness should focus first on module code, configuration, update
  paths, and public-facing README documentation.
