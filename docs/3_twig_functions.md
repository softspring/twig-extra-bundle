# Twig functions

## active_for_routes_extension

This extension provides a function that returns an active class for matching routes.

This is useful to create menus, options or tabs with active marks.

This function is enabled by default.

**Disable feature**

```yaml
{# config/packages/sfs_twig_extra.yaml #}
sfs_twig_extra:
    active_for_routes_extension: false        
```

**Usage**

```twig
<a href="{{ url('admin_products_list') }}" class="{{ active_for_routes('admin_products_') }}">Products</a> {# this link will have an "active" class when the current route matches with "admin_products_" #}        
<a href="{{ url('admin_products_list') }}" class="{{ active_for_routes('admin_products_', checkSomeVariable == true) }}">Products</a> {# also you can add an extra boolean expression #}        
<a href="{{ url('admin_products_list') }}" class="{{ active_for_routes('admin_products_', null, 'my-active-class') }}">Products</a> {# or change the "active" class with your "my-active-class" #}        
```

## routing_extension

This extension provides a route_defined function.

This is useful for bundles with enabling features.

This function is enabled by default.

**Disable feature**

```yaml
{# config/packages/sfs_twig_extra.yaml #}
sfs_twig_extra:
    routing_extension: false        
```

**Usage**

```twig
{# a bundle twig template #}
{% if route_defined('sfs_user_register') %}
    <a href="{{ url('sfs_user_register') }}" class="btn btn-secondary btn-block">Sign up</a>
{% endif %}
```