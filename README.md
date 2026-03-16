# Elementor Responsive Tables

A custom Elementor widget by 23Web to easily create, format, and style responsive tables on your WordPress site.

## Features

- **Visual Data Entry**: Quickly add table rows and columns using a robust Elementor repeater combined with pipe (`|`) delimiters. The WYSIWYG editor ensures cells support bolding, italics, links, and text alignments natively!
- **Header Rows**: Mark any row as a header row to automatically generate semantic `<thead>` components.
- **Responsive Layouts**: Designed to look great on all devices.
  - **Scrollable (Horizontal)**: Creates a horizontal scroll container when tables exceed mobile width.
  - **Stacked (Vertical)**: Reflows your table rows into intuitive vertical cards on mobile screens, automatically pulling from your table headers to act as inline data labels!
- **Complete Native Styling**: Customize table wrappers natively. Add shadows, rounded corners, header/body specific typography, background colors, text colors, paddings, and striped rows directly through Elementor's familiar interface.

## Setup & Usage

1. Pack the `elementor-responsive-tables` directory into a `.zip` file if deploying remotely, or copy it directly into `wp-content/plugins/` on your server.
2. In your WordPress Admin Dashboard, go to **Plugins**, and make sure it is activated.
3. Open any page using the Elementor site builder.
4. Search for the **Responsive Table** widget and drag it onto your page.
5. Use the Content tab's Row Repeater to create your rows. **Use the `|` character to separate columns on each row**.
6. Switch to the Style tab to experiment with different design settings and your preferred mobile behavior.

## Compatibility

Requires **Elementor v3.0.0+** and **PHP v7.0+**.

## Support

Developed by [23Web](https://www.23web.dev).
