# Accessible Calendar Multiday

This submodule adds the multiday-specific markup, classes, and library used to
visually connect one event across several calendar cells.

If this submodule is disabled, Accessible Calendar still renders the event rows,
but it will not add multiday metadata such as `data-accessible-calendar-instance`,
`data-accessible-calendar-instances`, `is-multi`, `is-multi--first`,
`is-multi--middle`, and `is-multi--last`.

Enable this submodule whenever your calendar needs events spanning multiple days
to render as one continuous sequence.
