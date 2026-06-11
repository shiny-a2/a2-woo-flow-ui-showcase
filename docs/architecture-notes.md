# Architecture Notes

This document explains the private Woo Flow UI plugin at a reviewer-friendly level without exposing production source code, customer data, payment/provider configuration, SMS credentials, checkout logs, store-specific UX tests, or operational rollout procedures.

## Operating Model

The plugin treats checkout changes as high-risk production changes. Instead of replacing live cart and checkout pages immediately, it creates preview pages that can be tested with real WooCommerce behavior while keeping the active purchase path unchanged until manual QA approves rollout.

## Workflow

1. An authorized operator installs the plugin in a WooCommerce environment.
2. Preview pages are created for cart, checkout, mobile verification, and thank-you flows.
3. Shortcodes render the preview UI without changing the production checkout pages.
4. Frontend scripts normalize localized digits, update city lists, and coordinate AJAX actions.
5. Cart/coupon/location interactions run through nonce-protected AJAX endpoints.
6. Checkout validation runs through WooCommerce hooks and adds user-facing notices when required fields fail.
7. Mobile verification can gate checkout until a verified phone state exists.
8. Order and user metadata are written in compatibility shapes expected by legacy operational tools.
9. WP-CLI reports expose readiness, dependency, and rollback information before production page replacement.
10. Production replacement remains blocked until explicit CLI execution and manual QA approval.

## Frontend Notes

- The UI is right-to-left and tuned for Persian checkout expectations.
- Persian and Arabic numerals are normalized before sending values to PHP.
- Province and city selections are handled as dependent fields.
- Coupon and cart updates avoid full checkout reloads where possible.
- Mobile sticky action bars help on narrow viewports.
- Dynamic checkout preview pages send no-cache headers to prevent stale cart state.

## Backend Notes

- Admin settings are stored through a WooCommerce-permission-gated settings screen.
- Validation covers mobile number shape, postcode shape, optional national/economic ID behavior, Jalali birthdate shape, and required terms acceptance.
- AJAX endpoints verify nonces and return structured JSON responses.
- Mobile verification uses transient-backed state with resend/attempt controls.
- Order and user compatibility metadata is persisted during checkout creation.
- WP-CLI commands support doctor reports, preview-page creation, dry-run installation, production installation, and rollback.

## Rollout Safety

- Preview pages are created separately from production WooCommerce pages.
- Production install commands support dry-run output before changes are made.
- Existing production page content is backed up before replacement.
- Rollback commands can restore previous page content.
- Provider-specific setup and live checkout settings remain private.

## Privacy Notes

This showcase intentionally avoids real phone numbers, customer records, order IDs, gateway settings, SMS provider credentials, production page IDs, live checkout copy, A/B test data, and operational logs. Phase 3 samples are simplified review snippets only.
