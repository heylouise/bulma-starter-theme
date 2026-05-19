# Bulma Starter Theme — Build Spec

A reusable WordPress starter theme built on Bulma 1.x, designed for small business and solopreneur sites. Edit two files (`theme-variables.css` and `theme-setup.php`), activate, done.

---

## Table of contents

1. [Architecture overview](#1-architecture-overview)
2. [File and folder structure](#2-file-and-folder-structure)
3. [Finicky files written in full](#3-finicky-files-written-in-full)
   - 3.1 `style.css` (theme header)
   - 3.2 `theme-variables.css`
   - 3.3 `theme-setup.php`
   - 3.4 `functions.php`
   - 3.5 `theme.json`
4. [Template files — build instructions](#4-template-files--build-instructions)
   - 4.1 `header.php`
   - 4.2 `footer.php`
   - 4.3 `index.php`
   - 4.4 `single.php`
   - 4.5 `page.php`
   - 4.6 `archive.php` (blog grid)
   - 4.7 `template-blank.php` (squeeze pages)
   - 4.8 `template-acf-builder.php`
   - 4.9 `searchform.php`, `404.php`, `comments.php`
5. [ACF flexible content setup](#5-acf-flexible-content-setup)
6. [Plugin integration notes](#6-plugin-integration-notes)
7. [WooCommerce pack (separate add-on)](#7-woocommerce-pack-separate-add-on)
8. [Per-project setup checklist](#8-per-project-setup-checklist)

---

## 1. Architecture overview

**Stack:**
- WordPress (classic PHP theme — no FSE / block themes)
- Bulma 1.x (via local CSS file, native CSS custom properties)
- Gutenberg for posts/pages (core blocks only, styled to match Bulma)
- ACF Pro for the optional flexible-content page builder
- Yoast SEO for SEO/meta/schema

**Editable per project:**
- `theme-variables.css` — fonts, colours, dark-mode palette, shaded bg
- `theme-setup.php` — feature toggles for this client

**Dark mode:** `@media (prefers-color-scheme: dark)` only. No toggle, no cookie.

**No build step.** You edit `.css` and `.php` directly. Bulma is included as a static CSS file.

---

## 2. File and folder structure

```
bulma-starter/
├── style.css                       # Theme header + base styles
├── theme-variables.css             # ← EDIT PER PROJECT (colours, fonts)
├── theme-setup.php                 # ← EDIT PER PROJECT (toggles)
├── theme.json                      # Editor colour/font tokens for Gutenberg
├── functions.php                   # Reads theme-setup.php and wires it up
├── header.php
├── footer.php
├── index.php
├── single.php
├── page.php
├── archive.php
├── search.php
├── searchform.php
├── 404.php
├── comments.php
├── template-blank.php              # No header/footer — squeeze pages
├── template-acf-builder.php        # ACF flexible content renderer
│
├── assets/
│   ├── css/
│   │   ├── bulma.min.css           # Bulma 1.x — download from bulma.io
│   │   ├── blocks.css              # Gutenberg core blocks styled to match Bulma
│   │   ├── plugins.css             # NF, TablePress, Lightweight Accordion overrides
│   │   └── editor.css              # Backend editor styles (loaded in admin)
│   ├── js/
│   │   └── navbar.js               # Mobile menu toggle (Bulma navbar burger)
│   └── images/
│       └── (logo, favicons, etc.)
│
├── inc/
│   ├── acf-layouts.php             # Renders ACF flexible content rows/columns
│   ├── template-tags.php           # Custom template helper functions
│   └── enqueue.php                 # Stylesheet/script enqueuing logic
│
├── template-parts/
│   ├── content.php                 # Default post loop item
│   ├── content-card.php            # Archive grid card
│   ├── content-page.php            # Page content wrapper
│   └── content-none.php            # "Nothing found" fallback
│
└── woocommerce/                    # ← Optional, deleted if not needed
    └── (Woo template overrides — see section 7)
```

---

## 3. Finicky files written in full

### 3.1 `style.css` (theme header)

WordPress requires this file at the theme root with a header comment. It can be near-empty — all real styles live in `theme-variables.css` and Bulma.

```css
/*
Theme Name: Bulma Starter
Theme URI: https://github.com/heylouise/bulma-starter-theme
Author: Louise Kozlevcar
Author URI: https://loukoz.com 
Description: Reusable Bulma 1.x starter theme for small business sites. Configure via theme-variables.css and theme-setup.php.
Version: 1.0.0
Requires PHP: 8.0
License: MIT
License URI: https://mit-license.org/ 
Text Domain: bulma-starter
*/

/* All real styles live in theme-variables.css and assets/css/. */
/* This file exists for the WP theme header only. */
```

---

### 3.2 `theme-variables.css`

This is the **one file you edit for visual changes per project**. Everything else inherits from here. Bulma 1.x exposes its tokens as CSS custom properties on `:root`, so we override them here.

```css
/* ==========================================================================
   THEME VARIABLES — edit these per project
   ========================================================================== */

:root {
  /* ----- FONTS ----- */
  --font-heading: 'Inter', system-ui, sans-serif;
  --font-body:    'Inter', system-ui, sans-serif;
  --font-mono:    ui-monospace, 'SF Mono', Menlo, monospace;

  /* ----- BRAND COLOURS (light mode) ----- */
  --brand-primary:   #2a5d8f;
  --brand-secondary: #e67e22;
  --brand-accent:    #16a085;

  /* ----- NEUTRAL COLOURS (light mode) ----- */
  --color-bg:        #ffffff;
  --color-bg-shaded: #f5f7fa;   /* Used by ACF "shaded background" option */
  --color-text:      #1a1a1a;
  --color-text-soft: #4a4a4a;
  --color-border:    #e0e0e0;
  --color-link:      var(--brand-primary);
  --color-link-hover: var(--brand-secondary);

  /* ----- BULMA OVERRIDES (light mode) ----- */
  /* Bulma 1.x reads these — see https://bulma.io/documentation/features/css-variables/ */
  --bulma-primary-h: 210;
  --bulma-primary-s: 55%;
  --bulma-primary-l: 36%;
  --bulma-family-primary: var(--font-body);
  --bulma-family-secondary: var(--font-heading);
  --bulma-body-background-color: var(--color-bg);
  --bulma-body-color: var(--color-text);
  --bulma-link: var(--color-link);
  --bulma-link-hover: var(--color-link-hover);
  --bulma-border: var(--color-border);

  /* ----- LAYOUT ----- */
  --container-max: 1200px;
  --section-padding-y: 4rem;
  --row-padding-y: 3rem;
}

/* ==========================================================================
   DARK MODE — triggered by user device preference
   ========================================================================== */

@media (prefers-color-scheme: dark) {
  :root {
    --color-bg:        #14181f;
    --color-bg-shaded: #1e242d;
    --color-text:      #e8eaed;
    --color-text-soft: #b0b6be;
    --color-border:    #2a313a;
    --color-link:      #6aa8df;
    --color-link-hover: #f0a560;

    /* Brand colours often need lifting in dark mode for contrast */
    --brand-primary:   #6aa8df;
    --brand-secondary: #f0a560;
    --brand-accent:    #4fc1a6;

    --bulma-primary-l: 65%;
    --bulma-body-background-color: var(--color-bg);
    --bulma-body-color: var(--color-text);
  }

  /* Tone down images slightly in dark mode (optional, often nice) */
  img:not(.no-dim) {
    opacity: 0.92;
  }
}

/* ==========================================================================
   GLOBAL BASE STYLES
   ========================================================================== */

body {
  font-family: var(--font-body);
  background: var(--color-bg);
  color: var(--color-text);
}

h1, h2, h3, h4, h5, h6 {
  font-family: var(--font-heading);
  color: var(--color-text);
}

a {
  color: var(--color-link);
  transition: color 0.15s ease;
}
a:hover { color: var(--color-link-hover); }

/* ACF "shaded" row background */
.row--shaded {
  background: var(--color-bg-shaded);
}

/* ACF "bordered" row option */
.row--bordered {
  border-top: 1px solid var(--color-border);
  border-bottom: 1px solid var(--color-border);
}

/* Standard row spacing */
.acf-row {
  padding: var(--row-padding-y) 0;
}
```

**To change a project's look:** open this file, edit values, save. Done.

---

### 3.3 `theme-setup.php`

```php
<?php
/**
 * THEME SETUP — edit per project
 *
 * Toggle features and set per-project values here. functions.php reads this
 * array and wires everything up. Only put things here that genuinely vary
 * between projects — always-on features (e.g. primary nav) stay hardcoded.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

return [

    // -----------------------------------------------------------------------
    // FOOTER
    // -----------------------------------------------------------------------
    'footer_columns' => 3,                  // 1–4 widget areas in footer

    // -----------------------------------------------------------------------
    // PAGE TEMPLATES — which appear in the WP page template dropdown
    // -----------------------------------------------------------------------
    'page_templates' => [
        'default'     => true,
        'blank'       => true,               // Squeeze / landing pages
        'acf-builder' => true,               // ACF flexible content builder
    ],

    // -----------------------------------------------------------------------
    // BLOG ARCHIVE
    // -----------------------------------------------------------------------
    'blog_archive_columns' => 3,             // 2, 3, or 4 columns in grid
    'posts_per_page'       => 9,             // Posts per archive page

    // -----------------------------------------------------------------------
    // SITE-WIDE TOGGLES
    // -----------------------------------------------------------------------
    'show_breadcrumbs'       => true,        // Yoast breadcrumbs on inner pages
    'show_search_in_header'  => false,       // Search icon in main nav

    // -----------------------------------------------------------------------
    // FEATURE FLAGS
    // -----------------------------------------------------------------------
    'enable_acf_options_page' => true,       // "Theme Options" page in WP admin
    'enable_woocommerce_pack' => false,      // Load /woocommerce/ template overrides

];
```

---

### 3.4 `functions.php`

This file reads `theme-setup.php` and wires everything up.

```php
<?php
/**
 * Bulma Starter — functions.php
 *
 * Reads theme-setup.php and registers theme features accordingly.
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// ---------------------------------------------------------------------------
// Load per-project config
// ---------------------------------------------------------------------------
$bulma_starter_config = require get_template_directory() . '/theme-setup.php';

// Make config globally accessible via a helper
function bulma_starter_config( $key = null, $default = null ) {
    global $bulma_starter_config;
    if ( $key === null ) return $bulma_starter_config;
    return $bulma_starter_config[ $key ] ?? $default;
}

// ---------------------------------------------------------------------------
// Theme support
// ---------------------------------------------------------------------------
add_action( 'after_setup_theme', function() {
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' ] );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor.css' );

    // Menus — these are always-on, so hardcoded (not in theme-setup.php)
    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'bulma-starter' ),
        'footer'  => __( 'Footer Navigation', 'bulma-starter' ),
    ] );
} );

// ---------------------------------------------------------------------------
// Enqueue styles and scripts
// ---------------------------------------------------------------------------
require get_template_directory() . '/inc/enqueue.php';

// ---------------------------------------------------------------------------
// Footer widget areas (count from theme-setup.php)
// ---------------------------------------------------------------------------
add_action( 'widgets_init', function() {
    $columns = (int) bulma_starter_config( 'footer_columns', 3 );
    $columns = max( 1, min( 4, $columns ) ); // clamp 1–4

    for ( $i = 1; $i <= $columns; $i++ ) {
        register_sidebar( [
            'name'          => sprintf( __( 'Footer Column %d', 'bulma-starter' ), $i ),
            'id'            => 'footer-' . $i,
            'before_widget' => '<div class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-widget-title">',
            'after_title'   => '</h4>',
        ] );
    }
} );

// ---------------------------------------------------------------------------
// Filter page templates — hide ones disabled in theme-setup.php
// ---------------------------------------------------------------------------
add_filter( 'theme_page_templates', function( $templates ) {
    $enabled = bulma_starter_config( 'page_templates', [] );

    if ( empty( $enabled['blank'] ) )       unset( $templates['template-blank.php'] );
    if ( empty( $enabled['acf-builder'] ) ) unset( $templates['template-acf-builder.php'] );

    return $templates;
} );

// ---------------------------------------------------------------------------
// Posts per page on blog archive
// ---------------------------------------------------------------------------
add_action( 'pre_get_posts', function( $query ) {
    if ( is_admin() || ! $query->is_main_query() ) return;
    if ( $query->is_home() || $query->is_archive() ) {
        $query->set( 'posts_per_page', (int) bulma_starter_config( 'posts_per_page', 9 ) );
    }
} );

// ---------------------------------------------------------------------------
// ACF Options page
// ---------------------------------------------------------------------------
if ( bulma_starter_config( 'enable_acf_options_page' ) && function_exists( 'acf_add_options_page' ) ) {
    add_action( 'acf/init', function() {
        acf_add_options_page( [
            'page_title' => 'Theme Options',
            'menu_title' => 'Theme Options',
            'menu_slug'  => 'theme-options',
            'capability' => 'edit_posts',
        ] );
    } );
}

// ---------------------------------------------------------------------------
// ACF flexible content layout renderer
// ---------------------------------------------------------------------------
require get_template_directory() . '/inc/acf-layouts.php';

// ---------------------------------------------------------------------------
// Template tag helpers
// ---------------------------------------------------------------------------
require get_template_directory() . '/inc/template-tags.php';

// ---------------------------------------------------------------------------
// WooCommerce pack (conditional)
// ---------------------------------------------------------------------------
if ( bulma_starter_config( 'enable_woocommerce_pack' ) && class_exists( 'WooCommerce' ) ) {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}
```

**`inc/enqueue.php`:**

```php
<?php
if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', function() {
    $theme_dir = get_template_directory_uri();
    $version   = wp_get_theme()->get( 'Version' );

    // Bulma framework
    wp_enqueue_style( 'bulma', $theme_dir . '/assets/css/bulma.min.css', [], '1.0.2' );

    // Theme variables (loaded AFTER Bulma so it can override)
    wp_enqueue_style( 'theme-variables', $theme_dir . '/theme-variables.css', [ 'bulma' ], $version );

    // Block / plugin overrides
    wp_enqueue_style( 'theme-blocks',  $theme_dir . '/assets/css/blocks.css',  [ 'theme-variables' ], $version );
    wp_enqueue_style( 'theme-plugins', $theme_dir . '/assets/css/plugins.css', [ 'theme-variables' ], $version );

    // Main stylesheet (for WP compatibility — even if mostly empty)
    wp_enqueue_style( 'theme-style', get_stylesheet_uri(), [ 'theme-variables' ], $version );

    // Navbar burger toggle
    wp_enqueue_script( 'theme-navbar', $theme_dir . '/assets/js/navbar.js', [], $version, true );

    // Comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
} );

// Also load theme-variables.css in the block editor so dark mode + colours preview correctly
add_action( 'enqueue_block_editor_assets', function() {
    wp_enqueue_style(
        'theme-variables-editor',
        get_template_directory_uri() . '/theme-variables.css',
        [],
        wp_get_theme()->get( 'Version' )
    );
} );
```

---

### 3.5 `theme.json`

Tells Gutenberg about your colour/font tokens so the block editor's colour pickers and typography options match the theme. Keep this minimal — Gutenberg core blocks only.

```json
{
  "$schema": "https://schemas.wp.org/trunk/theme.json",
  "version": 2,
  "settings": {
    "color": {
      "palette": [
        { "slug": "primary",    "color": "var(--brand-primary)",   "name": "Primary" },
        { "slug": "secondary",  "color": "var(--brand-secondary)", "name": "Secondary" },
        { "slug": "accent",     "color": "var(--brand-accent)",    "name": "Accent" },
        { "slug": "text",       "color": "var(--color-text)",      "name": "Text" },
        { "slug": "text-soft",  "color": "var(--color-text-soft)", "name": "Soft text" },
        { "slug": "bg",         "color": "var(--color-bg)",        "name": "Background" },
        { "slug": "bg-shaded",  "color": "var(--color-bg-shaded)", "name": "Shaded background" }
      ],
      "custom": false,
      "customGradient": false
    },
    "typography": {
      "fontFamilies": [
        { "slug": "body",    "fontFamily": "var(--font-body)",    "name": "Body" },
        { "slug": "heading", "fontFamily": "var(--font-heading)", "name": "Heading" },
        { "slug": "mono",    "fontFamily": "var(--font-mono)",    "name": "Mono" }
      ],
      "customFontSize": true
    },
    "layout": {
      "contentSize": "768px",
      "wideSize": "1200px"
    },
    "spacing": {
      "padding": true,
      "margin": true,
      "units": [ "px", "rem", "em", "%" ]
    }
  }
}
```

---

## 4. Template files — build instructions

These are the files you write yourself. For each one I'll describe what it does, the key bits, and any gotchas.

### 4.1 `header.php`

Standard WP header. Renders the Bulma navbar (logo on left, menu on right).

**Structure:**
1. `<!DOCTYPE html>`, `<html>` with `language_attributes()`, `<head>` with `wp_head()`.
2. `<body>` with `body_class()` and `wp_body_open()`.
3. `<header class="site-header">` containing a Bulma `<nav class="navbar">`:
   - `.navbar-brand` on the left: logo (use `the_custom_logo()` or fall back to site name)
   - `.navbar-burger` for mobile (target `#mainMenu`)
   - `.navbar-menu` with `id="mainMenu"`, containing `.navbar-end` with `wp_nav_menu()` output

**Walker for menu:** WP's default menu output doesn't produce Bulma classes. Two options:
- **Easy:** Use `wp_nav_menu()` with `'items_wrap' => '...'` and a custom `'walker' => new Bulma_Navwalker()`. Plenty of Bulma navwalker classes exist on GitHub — search "WordPress Bulma navwalker" and grab one (look for one updated recently and Bulma 1.x compatible).
- **Easier still:** Use `wp_nav_menu()` defaults, then style the resulting `<ul><li>` with CSS to look like a Bulma navbar. For most small business sites this is fine.

**Search:** If `bulma_starter_config('show_search_in_header')` is true, add `get_search_form()` inside `.navbar-end`.

**Gotcha:** Don't forget the `.navbar-burger` JS to toggle `is-active` on the burger and the target menu. That lives in `assets/js/navbar.js` (Bulma docs has the 8-line vanilla JS snippet — use it as-is).

---

### 4.2 `footer.php`

Renders footer widget columns based on `bulma_starter_config('footer_columns')`, then closes `</body></html>`.

**Structure:**
1. `<footer class="site-footer section">`
2. Inside `.container`: a Bulma `.columns` row.
3. Loop from 1 to `footer_columns`, output a `.column` with `dynamic_sidebar( 'footer-' . $i )`.
4. Below that, a small bottom strip with copyright + footer menu (`wp_nav_menu(['theme_location' => 'footer'])`).
5. `wp_footer()`, `</body>`, `</html>`.

**Gotcha:** The footer columns should stack on mobile — Bulma's `.columns` does this by default, so nothing special needed.

---

### 4.3 `index.php`

Fallback template. WP requires it but for most sites it'll never be hit because we have more specific templates. Make it identical to `archive.php` so it works as a safety net.

---

### 4.4 `single.php`

Single blog post layout.

**Structure:**
1. `get_header()`.
2. Optional breadcrumb: if `bulma_starter_config('show_breadcrumbs')` and `function_exists('yoast_breadcrumb')`, output `yoast_breadcrumb('<nav class="breadcrumb"><ul>', '</ul></nav>')`. Style it via CSS to match Bulma's breadcrumb component.
3. `<section class="section">` → `<div class="container">` → `<article>`:
   - Featured image (`the_post_thumbnail('large')`) if set
   - `<h1 class="title">` with `the_title()`
   - Post meta: date + author (use Bulma `.tags` or small text)
   - `<div class="content">` wrapping `the_content()` — Bulma's `.content` class auto-styles paragraphs, lists, headings, blockquotes
4. Comments via `comments_template()` if open.
5. `get_footer()`.

**Gotcha:** Bulma's `.content` class is the magic that makes Gutenberg core blocks (paragraph, list, heading, quote, etc.) look styled without per-block CSS. Always wrap `the_content()` in `<div class="content">`.

---

### 4.5 `page.php`

Like `single.php` but for pages.

**Structure:**
1. `get_header()`.
2. Breadcrumb (same conditional as above, but only show if not the front page).
3. Featured image (optional — many pages won't have one).
4. `<section class="section">` → `<div class="container">` → `<h1>` + `<div class="content">the_content()</div>`.
5. `get_footer()`.

---

### 4.6 `archive.php` (blog grid)

The elegant grid layout, carried over from the Editorial Theme brief.

**Structure:**
1. `get_header()`.
2. Page header section: archive title (`the_archive_title()` or "Blog") + optional description.
3. `<section class="section">` → `<div class="container">`:
   - A Bulma `.columns.is-multiline` wrapper.
   - Loop: for each post, output a `.column` whose width comes from `bulma_starter_config('blog_archive_columns')`:
     - 2 columns → `.is-half`
     - 3 columns → `.is-one-third`
     - 4 columns → `.is-one-quarter`
   - Inside each `.column`, include `template-parts/content-card.php`.
4. Pagination via `the_posts_pagination()` styled to match Bulma's pagination.
5. `get_footer()`.

**`template-parts/content-card.php`:** A Bulma `.card` with:
- `.card-image` → featured thumbnail (use `medium_large` size)
- `.card-content` → title (linked), date, excerpt, "Read more" link
- Hover: subtle lift via CSS transform

**Gotcha:** Set a consistent aspect ratio on the card image (`aspect-ratio: 16 / 10` in CSS) so the grid stays tidy regardless of source image dimensions.

---

### 4.7 `template-blank.php` (squeeze pages)

```php
<?php
/**
 * Template Name: Blank (no header/footer)
 *
 * For squeeze pages, landing pages, thank-you pages.
 * Loads minimal HTML wrapper — no site header, no site footer, no nav.
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class( 'is-blank-template' ); ?>>
<?php wp_body_open(); ?>

<main class="blank-main">
    <?php while ( have_posts() ) : the_post(); ?>
        <?php the_content(); ?>
    <?php endwhile; ?>
</main>

<?php wp_footer(); ?>
</body>
</html>
```

That's the whole file. Yoast still works (it injects via `wp_head()`), Gutenberg still works, but there's zero site chrome.

---

### 4.8 `template-acf-builder.php`

The page template that renders the ACF flexible content rows.

**Structure:**
1. `get_header()`.
2. While loop. Inside:
   - `<?php if ( have_rows( 'page_sections' ) ) : ?>`
   - `<?php while ( have_rows( 'page_sections' ) ) : the_row(); ?>`
   - Call a helper based on `get_row_layout()` — delegate to `inc/acf-layouts.php`.
3. `get_footer()`.

**`inc/acf-layouts.php`** does the heavy lifting. Pseudocode:

```php
function bulma_starter_render_row() {
    $shaded   = get_sub_field( 'shaded_background' );
    $bordered = get_sub_field( 'bordered' );
    $col_layout = get_sub_field( 'column_layout' ); // '1', '2', '3', '4', '2-1', '1-2', etc.

    $classes = [ 'acf-row' ];
    if ( $shaded )   $classes[] = 'row--shaded';
    if ( $bordered ) $classes[] = 'row--bordered';

    echo '<section class="' . esc_attr( implode( ' ', $classes ) ) . '">';
    echo '<div class="container"><div class="columns">';

    // Map column_layout to Bulma column classes
    $widths = bulma_starter_column_widths( $col_layout );

    if ( have_rows( 'columns' ) ) {
        $i = 0;
        while ( have_rows( 'columns' ) ) {
            the_row();
            $width_class = $widths[ $i ] ?? '';
            echo '<div class="column ' . esc_attr( $width_class ) . '">';
            // WYSIWYG field, or sub-flexible content for cards/images/etc.
            echo apply_filters( 'the_content', get_sub_field( 'content' ) );
            echo '</div>';
            $i++;
        }
    }

    echo '</div></div></section>';
}

function bulma_starter_column_widths( $layout ) {
    $map = [
        '1'    => [ 'is-full' ],
        '2'    => [ 'is-half', 'is-half' ],
        '3'    => [ 'is-one-third', 'is-one-third', 'is-one-third' ],
        '4'    => [ 'is-one-quarter', 'is-one-quarter', 'is-one-quarter', 'is-one-quarter' ],
        '2-1'  => [ 'is-two-thirds', 'is-one-third' ],
        '1-2'  => [ 'is-one-third', 'is-two-thirds' ],
        '1-3'  => [ 'is-one-quarter', 'is-three-quarters' ],
        '3-1'  => [ 'is-three-quarters', 'is-one-quarter' ],
    ];
    return $map[ $layout ] ?? [ 'is-full' ];
}
```

Then in `template-acf-builder.php`:

```php
if ( get_row_layout() === 'row' ) {
    bulma_starter_render_row();
}
```

---

### 4.9 `searchform.php`, `404.php`, `comments.php`

**`searchform.php`:** A Bulma `.field.has-addons` with an input and submit button. Standard WP form action.

**`404.php`:** A centred section with "Page not found", a search form, and a "back to home" link.

**`comments.php`:** Standard WP comments template. Bulma's `.content` class will style the comment list reasonably out of the box. Use `comment_form()` for the form.

If you want to skip comments entirely (most business sites do), add `'comments' => false` to your CPT registration or just don't include `comments_template()` calls in `single.php`. Simpler still: in `theme-setup.php` you could add an `enable_comments` flag later.

---

## 5. ACF flexible content setup

Set up in WP admin UI under **Custom Fields → Field Groups**. Name it "Page Builder".

**Location rule:** Page template is equal to "ACF Builder" (this hides the field group on regular pages, keeping the Gutenberg editor clean there).

**Fields:**

1. **Page Sections** (Flexible Content, name: `page_sections`)
   - Add layout **Row** (name: `row`):
     - **Column layout** (Select, name: `column_layout`)
       - Choices: `1 : One column`, `2 : Two equal columns`, `3 : Three equal columns`, `4 : Four equal columns`, `2-1 : Two-thirds + one-third`, `1-2 : One-third + two-thirds`, `1-3 : One-quarter + three-quarters`, `3-1 : Three-quarters + one-quarter`
       - Default: `1`
     - **Shaded background** (True/False, name: `shaded_background`, default: off)
     - **Bordered** (True/False, name: `bordered`, default: off)
     - **Columns** (Repeater, name: `columns`)
       - Sub-field: **Content** (WYSIWYG, name: `content`)

**Export to JSON:** Once you've built the field group, use ACF's **Tools → Export Field Groups → Generate PHP** (or JSON) and save the result to `inc/acf-fields.php` (or `acf-json/` folder if you want ACF to auto-sync). This way you don't have to rebuild the field group manually on every new project — the theme can register it programmatically.

**Tip:** Turn on ACF's **Local JSON** by creating an empty `acf-json/` folder in the theme. ACF will auto-save field groups there and auto-sync on new sites.

---

## 6. Plugin integration notes

### Lightweight Accordion
Outputs `<details><summary>...</summary>...</details>`. In `assets/css/plugins.css`:

```css
.wp-block-cm-lightweight-accordion details {
  border: 1px solid var(--color-border);
  border-radius: 4px;
  margin-bottom: 0.75rem;
  background: var(--color-bg);
}
.wp-block-cm-lightweight-accordion summary {
  padding: 1rem 1.25rem;
  font-family: var(--font-heading);
  font-weight: 600;
  cursor: pointer;
  list-style: none;
}
.wp-block-cm-lightweight-accordion summary::-webkit-details-marker { display: none; }
.wp-block-cm-lightweight-accordion details[open] summary {
  border-bottom: 1px solid var(--color-border);
}
.wp-block-cm-lightweight-accordion .accordion-content {
  padding: 1rem 1.25rem;
}
```

### TablePress
Add to `plugins.css`:

```css
.tablepress {
  font-family: var(--font-body);
  border-collapse: collapse;
  width: 100%;
}
.tablepress th {
  background: var(--color-bg-shaded);
  color: var(--color-text);
  font-family: var(--font-heading);
  text-align: left;
  padding: 0.75rem 1rem;
  border-bottom: 2px solid var(--color-border);
}
.tablepress td {
  padding: 0.75rem 1rem;
  border-bottom: 1px solid var(--color-border);
}
.tablepress .row-hover tr:hover td {
  background: var(--color-bg-shaded);
}
```

Don't touch TablePress's own option to enable striping/sorting — just style the resulting markup.

### Ninja Forms (Option A — load NF styles + thin overrides)
NF will load its own stylesheet. We add overrides for typography and colour only, leaving structural CSS alone.

```css
.nf-form-content {
  font-family: var(--font-body);
  max-width: 100%;
}
.nf-form-content input[type="text"],
.nf-form-content input[type="email"],
.nf-form-content input[type="tel"],
.nf-form-content textarea,
.nf-form-content select {
  border: 1px solid var(--color-border);
  border-radius: 4px;
  padding: 0.5rem 0.75rem;
  background: var(--color-bg);
  color: var(--color-text);
}
.nf-form-content input[type="text"]:focus,
.nf-form-content input[type="email"]:focus,
.nf-form-content textarea:focus {
  border-color: var(--brand-primary);
  outline: none;
  box-shadow: 0 0 0 3px color-mix(in srgb, var(--brand-primary) 25%, transparent);
}
.nf-form-content .nf-field-label label {
  font-family: var(--font-heading);
  color: var(--color-text);
}
.nf-form-content input[type="button"],
.nf-form-content .ninja-forms-field[type="button"] {
  background: var(--brand-primary);
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 0.6rem 1.25rem;
  font-family: var(--font-heading);
  font-weight: 600;
  cursor: pointer;
}
.nf-form-content input[type="button"]:hover {
  background: var(--brand-secondary);
}
```

That's it — resist the urge to fight NF's structural CSS.

### Yoast SEO
No CSS work needed. Theme support:
- `add_theme_support('title-tag')` is already in `functions.php` — Yoast needs this.
- Yoast breadcrumbs are already conditionally output in `single.php`/`page.php`.
- For schema, Yoast handles it automatically as long as you use proper semantic HTML (`<article>`, `<h1>`, post meta in standard WP fashion).

---

## 7. WooCommerce pack (separate add-on)

When you need Woo on a project:

1. Set `'enable_woocommerce_pack' => true` in `theme-setup.php`.
2. Make sure the `/woocommerce/` folder exists in the theme with the template overrides you want to customise (start by copying from `wp-content/plugins/woocommerce/templates/` and modifying).

**Minimum override files to include in the pack:**
- `woocommerce.php` — wrapper template (loads `get_header()`, content, `get_footer()`)
- `archive-product.php` — product grid (use Bulma columns same as blog archive)
- `single-product.php` — product detail page
- `content-product.php` — individual product card in the grid
- `cart/cart.php` — cart page styled with Bulma table classes
- `checkout/form-checkout.php` — checkout layout

**Approach:** keep these minimal. Wrap Woo's default `do_action()` hooks in Bulma containers/columns and let Woo's own templates render inside. Don't rewrite Woo from scratch — just provide layout shells.

Build this pack once, save it somewhere outside the starter theme, drop it into projects as needed.

---

## 8. Per-project setup checklist

When spinning up a new site:

1. **Copy** the `bulma-starter` folder, rename it to the project (e.g. `acme-2026`).
2. **Update** `style.css` theme header (Theme Name, Author URI for the client).
3. **Edit** `theme-variables.css`:
   - Fonts (load via Google Fonts in `header.php` or `functions.php` if not system fonts)
   - Brand colours (light mode)
   - Brand colours (dark mode) — lift saturation/lightness as needed
4. **Edit** `theme-setup.php`:
   - `footer_columns`
   - `blog_archive_columns`
   - `posts_per_page`
   - Page templates enabled
   - `enable_woocommerce_pack` if needed
5. **Install plugins**: ACF Pro, Yoast, Lightweight Accordion, TablePress, Ninja Forms, (Woo if relevant).
6. **Import** ACF field group from `acf-json/` (auto-syncs) or via Tools → Import.
7. **Set up menus**: Primary and Footer in **Appearance → Menus**.
8. **Set up footer widgets** in **Appearance → Widgets**.
9. **Configure Yoast** site-wide settings.
10. **Activate** theme. Test light + dark mode by toggling OS preference.

---

## Appendix: things deliberately left out

- **A build step.** No npm, no Gulp, no Sass. Everything is editable in a code editor.
- **Custom Gutenberg blocks.** Core blocks only, styled via `assets/css/blocks.css`.
- **A dark-mode toggle.** OS preference only, as agreed.
- **JS frameworks.** Vanilla JS, minimal — only the navbar burger toggle.
- **Image optimisation logic.** Use a plugin (e.g. Imagify, ShortPixel) per project rather than baking it in.
- **Caching.** Per-project hosting concern, not a theme concern.

---

## When you get stuck

The bits most likely to trip you up:

1. **Bulma 1.x variable names** — the documentation at [bulma.io/documentation/features/css-variables/](https://bulma.io/documentation/features/css-variables/) is the source of truth. The names changed from 0.9.x.
2. **The Bulma navwalker** — if you can't find a maintained one, just do without it. WP's default menu output works, you just style the resulting `<ul><li>` to look like a navbar.
3. **ACF flexible content rendering** — the `have_rows()` / `the_row()` / `get_sub_field()` pattern is fiddly. Reference: [advancedcustomfields.com/resources/flexible-content/](https://www.advancedcustomfields.com/resources/flexible-content/).
4. **Dark mode for images** — some logos look terrible inverted. Add a `.no-dim` class to those images to opt them out (already handled in `theme-variables.css`).


