/**
 * @file
 * Accessibility behaviors for Accessible Calendar updates.
 */

(function (Drupal, once) {
  Drupal.behaviors.accessibleCalendarA11y = {
    attach(context) {
      once("accessible-calendar-a11y", ".accessible-calendar", context).forEach(
        (calendar) => {
          if (context === document) {
            return;
          }

          const caption = calendar.querySelector(
            ".accessible-calendar-table caption",
          );
          if (!caption) {
            return;
          }

          const pager = calendar.parentElement?.querySelector(
            ".accessible-calendar-pager-nav",
          );
          const message =
            pager?.getAttribute("data-accessible-calendar-current-period") ||
            Drupal.t("Calendar updated. Showing @period.", {
              "@period": caption.textContent.trim(),
            });

          Drupal.announce(message);
          caption.setAttribute("tabindex", "-1");
          caption.focus({ preventScroll: true });
        },
      );
    },
  };
})(Drupal, once);
