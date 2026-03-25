# Twig Extra Bundle Features

Functional definition for `softspring/twig-extra-bundle`.

This file defines the expected behavior and functional scope of the bundle.

## Purpose

- Add practical Twig helpers that are commonly needed in Symfony applications.
- Extend the global Twig `app` variable so applications and other bundles can expose additional context safely.
- Keep these template helpers reusable and configurable instead of reimplementing them in each project.

## Main Features

- Replace the default Twig `app` variable class with an extensible implementation.
- Allow application code and other bundles to expose extra values such as `app.account`.
- Provide an `active_for_routes` Twig function for navigation state.
- Provide a `route_defined` Twig function to check whether a route exists.
- Provide a `date_span` Twig filter for displaying a date using the visitor timezone while keeping UTC information available.
- Provide an `instanceof` Twig test.
- Optionally provide `encore_entry_css_source` and `encore_entry_js_source` Twig functions.

## Configuration Expectations

- Each extension should be configurable through `sfs_twig_extra`.
- Each extension should be individually enabled or disabled.
- `encore_entry_sources_extension` should be disabled by default.
- `encore_entry_sources_extension` should accept a configurable `public_path`.

## App Variable Expectations

- The bundle should replace `twig.app_variable` with `Softspring\TwigExtraBundle\Twig\ExtensibleAppVariable`.
- The extended app variable should keep the default Symfony `app` behavior.
- Extra values should be accessible with dynamic getters and property access.
- Other bundles and applications should be able to set values such as `app.account`, `app.store`, or similar.

## Twig Helper Expectations

- `active_for_routes` should return an active CSS class when the current route matches the configured prefix.
- `route_defined` should return `true` when a route exists, even if URL generation needs parameters.
- `date_span` should use the `utz` cookie when it is available and valid.
- `date_span` should degrade safely when no request or no timezone cookie is available.
- `instanceof` should allow simple class checks directly in Twig templates.
- `encore_entry_css_source` and `encore_entry_js_source` should return the built asset source for a given Encore entry.

## Extension Expectations

- Applications should be able to use the extended `app` variable from request listeners and other runtime services.
- Applications should be able to disable helpers they do not want to expose in templates.
- Applications should be able to adjust the Encore public path when assets are not served from the default Symfony public directory.

## Current Limits

- This bundle is focused on small template helpers, not on a large Twig utility framework.
- `date_span` depends on the `utz` cookie convention for user timezone support.
- `encore_entry_*_source` requires `symfony/webpack-encore-bundle` and local access to the built asset files.
