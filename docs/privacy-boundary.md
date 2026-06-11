# Privacy Boundary

This public repository is designed for employer review and portfolio proof only.

## Public

- General checkout UX architecture and compatibility notes.
- Public-safe descriptions of preview-first rollout, data-normalization patterns, validation boundaries, and rollback-aware deployment.
- Sanitized snippets that demonstrate patterns without exposing live checkout behavior.
- Reviewer-friendly discussion of operational risk, safeguards, and compatibility tradeoffs.

## Private

- Production source code.
- Payment/provider details, SMS credentials, customer data, order data, checkout logs, store-specific settings, and private UX tests.
- Internal conversion rules, operational checkout procedures, provider names where they reveal live setup, and production rollout instructions.
- Real phone numbers, user IDs, order IDs, payment gateway IDs, page IDs, coupon data, shipping rules, and customer metadata.
- Internal action names, nonce names, option names, and compatibility meta keys where they would reveal production implementation details.

## Rule

Public samples should explain the engineering approach without exposing live checkout operations, provider configuration, customer data, or production checkout behavior.
