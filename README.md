# A2 Woo Flow UI Showcase

Public-safe showcase for a private Persian WooCommerce cart, checkout, mobile verification, and thank-you UI compatibility layer.

This repository is documentation and sanitized portfolio proof only. It is not a source mirror. Production source, checkout configuration, customer data, payment/provider details, SMS credentials, store-specific UX rules, and operational checkout logs stay private.

## Review Summary

- **Problem:** WooCommerce checkout flows can become fragile when localized forms, OTP/mobile verification, province/city data, coupons, payment gateways, and legacy customer metadata all interact in one purchase path.
- **Solution:** a preview-first UI compatibility layer that adds modern cart/checkout pages, mobile verification gates, validation helpers, admin settings, and rollback-aware deployment commands without replacing production pages by default.
- **Engineering focus:** checkout safety, Persian UX, digit normalization, AJAX cart interactions, mobile verification state, meta compatibility, no-cache handling, and controlled rollout.
- **Public scope:** architecture, rollout strategy, privacy boundary, and future sanitized snippets.

## Business Context

Checkout is a high-risk area: small UI, validation, or provider changes can break orders. The private plugin was built to improve purchase flow UX while keeping production risk low.

The implementation is designed around a staged rollout:

1. Create preview pages for cart, checkout, mobile verification, and thank-you views.
2. Keep the original WooCommerce pages untouched until manual QA approves replacement.
3. Use shortcodes to render isolated preview experiences.
4. Normalize Persian/Arabic digits before validation or AJAX operations.
5. Gate checkout behind verified mobile state when configured.
6. Persist compatibility metadata expected by existing invoice, customer, and operational workflows.
7. Provide WP-CLI doctor/report commands so rollout readiness is reviewable before production activation.

## What This Demonstrates

- Checkout/cart UX engineering for Persian WooCommerce stores.
- Preview-first rollout thinking for sensitive purchase flows.
- Mobile verification flow design without exposing provider details.
- Digit normalization, location data handoff, and validation boundaries.
- AJAX cart/coupon interactions with nonce-based request checks.
- Compatibility mapping for legacy order/user metadata.
- No-cache handling for dynamic checkout preview pages.
- Admin settings and WP-CLI commands for controlled deployment and rollback.
- Public-safe documentation of conversion-flow improvements without exposing production internals.

## Architecture Overview

The private implementation is organized as a WordPress/WooCommerce plugin with frontend shortcodes, AJAX endpoints, admin settings, and WP-CLI rollout commands:

- **Shortcode layer:** renders preview-first cart, checkout, mobile verification, and thank-you pages.
- **Validation layer:** normalizes digits, validates mobile/postcode/national-ID style fields, and checks required terms.
- **Mobile gate:** tracks verified phone state and can lock checkout until verification is complete.
- **Frontend layer:** updates cart quantities, coupons, city lists, birthdate inputs, and mobile verification status.
- **AJAX layer:** handles cart, coupon, location, checkout refresh, send-code, and verify-code actions with nonce checks.
- **Compatibility layer:** stores order/user metadata in multiple keys where legacy plugins or back-office workflows expect them.
- **Admin layer:** exposes operational settings behind WooCommerce permissions.
- **CLI layer:** provides dry-run reports, preview-page creation, production install, and rollback commands.
- **Cache safety:** disables page caching on dynamic preview views to avoid stale checkout state.

See `docs/architecture-notes.md` for the detailed reviewer walkthrough.

## Key Engineering Decisions

- **Preview first:** production cart/checkout pages are not replaced by default.
- **Rollout via CLI:** high-risk page replacement is controlled, dry-runnable, and rollback-aware.
- **Localized validation:** Persian/Arabic digits are normalized before mobile, postcode, and form validation.
- **Checkout lock is configurable:** mobile verification can be enforced without hardcoding provider behavior.
- **Compatibility over purity:** metadata is written in expected legacy shapes so existing operations keep working.
- **No public provider leakage:** SMS/payment provider details, production copy, and checkout settings are intentionally omitted.

## Tech Stack

- WordPress plugin architecture
- WooCommerce checkout/cart UI
- PHP 7.4+
- CSS/JavaScript frontend layer
- AJAX interactions
- WP-CLI operational commands
- Persian UX and compatibility patterns

## Privacy Boundary

Public files describe the architecture and engineering approach only. Production source, payment/provider configuration, SMS credentials, customer/order data, checkout logs, store-specific settings, UX test data, and private rollout procedures remain private.

Read the full boundary in `docs/privacy-boundary.md`.

## Reviewer Path

- Start with this README for the business case and implementation shape.
- Read `docs/architecture-notes.md` for workflow and module responsibilities.
- Read `docs/privacy-boundary.md` for what is intentionally excluded.
- Check `docs/update-notes.md` for public-facing change history.
- Review `samples/README.md` for the Phase 3 sanitized sample plan.

## Repository Structure

- `docs/architecture-notes.md` — architecture, workflow, and engineering decisions.
- `docs/privacy-boundary.md` — what is public versus private.
- `docs/update-notes.md` — public update log.
- `samples/README.md` — sanitized sample-code overview.
- `samples/php/` — short public-safe PHP snippets for checkout validation and mobile verification state.
- `samples/js/` — short public-safe JavaScript snippets for localized checkout UI behavior.

## Phase Status

- **Phase 1:** showcase skeleton, privacy boundary, and reviewer path.
- **Phase 2:** employer-friendly business context, architecture notes, and risk boundaries.
- **Phase 3:** sanitized snippets for digit normalization, checkout field policy, and mobile verification state.

## Links

- Portfolio: <https://amiraliyaghouti.com>
- GitHub profile: <https://github.com/shiny-a2>
- Private source: `shiny-a2/a2-woo-flow-ui` (not public)
