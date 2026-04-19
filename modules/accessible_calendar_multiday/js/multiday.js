/**
 * @file
 * Calendar multiple day events behaviors.
 */

(function (Drupal, once) {
  const hashAttribute = "data-accessible-calendar-hash";

  /**
   * Toggle the shared hover state for all instances of one multiday event.
   *
   * @param {NodeListOf<Element>} rowInstances
   *   Matching instances for one event.
   * @param {boolean} isActive
   *   Whether the group should appear active.
   */
  function setGroupActive(rowInstances, isActive) {
    rowInstances.forEach(function (other) {
      other.classList.toggle("hover", isActive);
    });
  }

  /**
   * Check whether focus remains inside the same multiday event group.
   *
   * @param {NodeListOf<Element>} rowInstances
   *   Matching instances for one event.
   * @param {EventTarget|null} nextTarget
   *   The element receiving focus or pointer context next.
   *
   * @return {boolean}
   *   True when the next target belongs to the same group.
   */
  function isWithinGroup(rowInstances, nextTarget) {
    if (!(nextTarget instanceof Element)) {
      return false;
    }

    return Array.from(rowInstances).some(function (instance) {
      return instance === nextTarget || instance.contains(nextTarget);
    });
  }

  /**
   * Alter multiday events theming.
   *
   * This behavior is dependent on preprocess hook.
   *
   * @type {Drupal~behavior}
   *
   * @prop {Drupal~behaviorAttach} attach
   *   Attaches the behavior.
   *
   * @see template_preprocess_accessible_calendar_day()
   */
  Drupal.behaviors.accessibleCalendarMultiday = {
    attach(context, settings) {
      // Find first instance multiday event from the past.
      let firstInstances = {};
      context
        .querySelectorAll("[" + hashAttribute + "]")
        .forEach(function (el) {
          if (el.hasAttribute(hashAttribute)) {
            let hash = el.getAttribute(hashAttribute);
            if (!firstInstances[hash]) {
              firstInstances[hash] = el;
            }
          }
        });

      if (Object.keys(firstInstances).length < 1) {
        return;
      }

      // Alter all other instances of a multiday event.
      once(
        "accessible-calendar-multiday",
        Object.values(firstInstances),
        context,
      ).forEach(function (el) {
        if (!el.hasAttribute(hashAttribute)) {
          return;
        }

        let rowHash = el.getAttribute(hashAttribute);
        let rowInstances = context.querySelectorAll(
          "[" + hashAttribute + '="' + rowHash + '"]',
        );
        if (!rowInstances || rowInstances.length < 1) {
          return;
        }

        // Simulate first instance for multiday spanning in the past.
        if (el.classList.contains("is-multi--middle")) {
          el.classList.add("is-multi--first");
        }

        // Get reference "sizes".
        let elBound = el.getBoundingClientRect();

        // Loop on cloned events.
        rowInstances.forEach(function (instance) {
          // Keep all instances visually grouped for mouse and keyboard users.
          instance.addEventListener("mouseover", function () {
            setGroupActive(rowInstances, true);
          });
          instance.addEventListener("mouseleave", function (event) {
            if (!isWithinGroup(rowInstances, event.relatedTarget)) {
              setGroupActive(rowInstances, false);
            }
          });
          instance.addEventListener("focusin", function () {
            setGroupActive(rowInstances, true);
          });
          instance.addEventListener("focusout", function (event) {
            if (!isWithinGroup(rowInstances, event.relatedTarget)) {
              setGroupActive(rowInstances, false);
            }
          });

          // Simulate same size and position in cell.
          if (instance != el) {
            instance.style.height = elBound.height + "px";

            if (instance.offsetTop < el.offsetTop) {
              instance.style.marginTop =
                el.offsetTop - instance.offsetTop + "px";
            }
          }
        });
      });
    },
  };
})(Drupal, once);
