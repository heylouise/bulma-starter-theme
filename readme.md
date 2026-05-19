# Bulma Starter Theme

A reusable WordPress starter theme built on [Bulma 1.x](https://bulma.io/), designed for small business and solopreneur sites. Configure the look in one CSS file, toggle features in one PHP file, activate the theme — done.

## What it is

A classic PHP WordPress theme (not a block/FSE theme) for developers who like the old-school workflow but want a modern, lightweight CSS framework underneath. Edit `theme-variables.css` for colours and fonts, `theme-setup.php` for per-project toggles, and you're set.

## Features

- **Bulma 1.x** via native CSS custom properties — no Sass, no build step.
- **Gutenberg-friendly** — core blocks only, styled to match Bulma via `.content` and a small overrides file.
- **Optional ACF flexible content page builder** — rows with column layouts, shaded backgrounds, and bordered options.
- **Dark mode** automatically via `prefers-color-scheme` (no toggle, no cookie).
- **Blank/squeeze page template** for landing pages with no header or footer.
- **Elegant blog archive grid** (2, 3, or 4 columns — configurable).
- **Yoast SEO** ready (title tags, breadcrumbs, semantic markup).
- **Plays nicely with** [Lightweight Accordion](https://wordpress.org/plugins/lightweight-accordion/), [TablePress](https://wordpress.org/plugins/tablepress/), and [Ninja Forms](https://wordpress.org/plugins/ninja-forms/).
- **Optional WooCommerce pack** loaded only when needed.
- **One-file config** in `theme-setup.php` — footer column count, archive grid columns, page templates enabled, posts per page, feature flags.

## Requirements

- WordPress 6.0+
- PHP 8.0+
- [ACF Pro](https://www.advancedcustomfields.com/pro/) (only if using the ACF flexible content builder)
- [Yoast SEO](https://wordpress.org/plugins/wordpress-seo/) (recommended for breadcrumbs and meta)

## Installation

1. Clone or download this repo into your `wp-content/themes/` directory:
   ```bash
   cd wp-content/themes
   git clone https://github.com/heylouise/bulma-starter-theme.git
   ```
2. Download [Bulma 1.x](https://bulma.io/) and place `bulma.min.css` in `assets/css/`.
3. Activate the theme in **Appearance → Themes**.
4. Configure for your project (see below).

## Configuration

### 1. Edit `theme-variables.css`

Open the file at the theme root and update:
- Fonts (`--font-heading`, `--font-body`)
- Brand colours (`--brand-primary`, `--brand-secondary`, `--brand-accent`)
- Neutral colours including the "shaded" background used by ACF rows
- Dark mode palette inside the `@media (prefers-color-scheme: dark)` block

### 2. Edit `theme-setup.php`

Open the file at the theme root and adjust the array:

```php
return [
    'footer_columns'          => 3,
    'page_templates'          => [ 'default' => true, 'blank' => true, 'acf-builder' => true ],
    'blog_archive_columns'    => 3,
    'posts_per_page'          => 9,
    'show_breadcrumbs'        => true,
    'show_search_in_header'   => false,
    'enable_acf_options_page' => true,
    'enable_woocommerce_pack' => false,
];
```

### 3. Set up menus and widgets

- **Appearance → Menus**: assign menus to "Primary Navigation" and "Footer Navigation".
- **Appearance → Widgets**: populate the footer columns.

### 4. (Optional) Import the ACF field group

If using the page builder template, import the ACF field group from `acf-json/` (auto-syncs if you turn on Local JSON in ACF settings) or build it manually following the spec in `STARTER-THEME-SPEC.md`.

## File structure

See `STARTER-THEME-SPEC.md` for the full architecture and build notes. The short version:

```
bulma-starter-theme/
├── theme-variables.css     ← Edit per project (colours, fonts)
├── theme-setup.php         ← Edit per project (feature toggles)
├── functions.php
├── style.css
├── theme.json
├── header.php / footer.php / index.php / single.php / page.php / archive.php
├── template-blank.php
├── template-acf-builder.php
├── assets/css/             ← Bulma, blocks, plugin overrides
├── inc/                    ← ACF layouts, enqueue, template tags
└── template-parts/         ← Reusable content partials
```

## Known limitations

- **Not a block theme.** This is a classic PHP theme. Full Site Editing, template parts in the Site Editor, and global styles in the editor will not work. Posts and pages still use Gutenberg as normal.
- **No custom Gutenberg blocks.** By design — core blocks only, styled to match Bulma. If you need custom blocks, add them per-project or use a plugin like ACF Blocks.
- **Bulma navbar requires a navwalker.** WordPress's default `wp_nav_menu()` output doesn't produce Bulma's navbar classes. Either grab a maintained Bulma navwalker from GitHub or style the default menu output yourself.
- **Ninja Forms keeps its own styles.** The theme applies a thin override layer for typography and colour. Trying to fully replace NF's CSS leads to pain — don't do it.
- **WooCommerce pack is not included.** Build it separately and drop the `/woocommerce/` folder into the theme when needed. See `STARTER-THEME-SPEC.md` section 7 for the approach.
- **No build step means no Sass.** All customisation is via CSS custom properties. If you need Sass features (mixins, math, etc.), this theme is not for you.
- **Dark mode is OS-driven only.** No manual toggle. By design — if your client wants a toggle, this is not the theme for them.
- **Bulma navwalkers in the wild vary in quality.** Test thoroughly before relying on any third-party walker, especially for Bulma 1.x compatibility (most are still written for 0.9.x).
- **Images are slightly dimmed in dark mode** via `opacity: 0.92` on `img:not(.no-dim)`. Add the `no-dim` class to logos or images that shouldn't dim.

## Changelog

### [1.0.0] – Unreleased
- Initial release.
- Bulma 1.x integration via CSS custom properties.
- `theme-variables.css` and `theme-setup.php` config files.
- Page templates: default, blank, ACF builder.
- Blog archive grid with configurable column count.
- Dark mode via `prefers-color-scheme`.
- ACF flexible content renderer for row/column page building.
- Plugin overrides for Lightweight Accordion, TablePress, Ninja Forms.
- Yoast SEO support including breadcrumbs.

## Licence

[MIT](LICENSE) — free to use for any purpose, including commercial work. Credit appreciated but not required.

If you do use it on a client site or a project you're proud of, a link back is welcome but not expected.

## Credit

Built by Louise (Lou) Kozlevcar @heylouise. Inspired by years of building WordPress sites the old-fashioned way and wanting a clean, modern starting point.
