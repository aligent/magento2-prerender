# magento2-prerender
Provides integration between Magento 2 and Prerender service, giving the ability for pages to be automatically recached when required.

## Overview
This module provides new indexers:

- `prerender_product`, which will send URL recache requests for products to Prerender service (in batches of up to 1000) when changes are made to products.
- `prerender_category`, which will send URL recache requests for categories to Prerender service (in batches of up to 1000) when changes are made to categories.
- `prerender_category_product`, which will send URL recache requests for categories to Prerender service (in batches of up to 1000) when changes are made to products.

These will ensure that the cached pages are kept up-to-date at all times.

## Installation
To install via composer, simply run:

```bash
composer require aligent/magento2-prerender
```

Then, ensure the module is installed and the indexers are set to `Schedule`:

```bash
bin/magento module:enable Aligent_Prerender
bin/magento setup:upgrade
bin/magento indexer:set-mode schedule prerender_product prerender_category prerender_category_product
```

## Configuration
The extension can be configured via `Stores -> Configuration -> System -> Prerender Service`
