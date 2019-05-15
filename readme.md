hypeEmbed
=========
![Elgg 2.3](https://img.shields.io/badge/Elgg-2.3.x-orange.svg?style=flat-square)

## Features

* Replaces core embed UI/UX
* Search, upload and embed files on the spot
* Search and embed all other registered object types on the spot
* Embed URL previews and rich-media players
* [admin] Embed buttons that match the site styles
* [admin] Embed "insecure" HTML embeds (forms, calendars etc)

## Acknowledgements

* Upgrade for Elgg 2.3 has been sponsored by ApostleTree, LLC

![Embed Popup](https://raw.github.com/hypeJunction/hypeEmbed/master/screenshots/embedder.png "Embed Popup")

## Shortcodes

The plugin supports the following shorcodes:

`ebmed` shortcode:

 * `guid` - GUID of an entity to embed

`player` shortcode:

 * `url` - URL of the player

`button` shortcode:

 * `text` - call to action
 * `type` - One of the following types `action`, `submit`, `delete`, `cancel` (these values only affect styling and do not carry any functional value)
 * `url` - URL to link to
 * `target` - Default `self`, `blank` or `lightbox` 

Examples:

```
[embed guid="555"]
[player url="http://youtube.com/893dkeie9"]
[button type="action" text="Read Terms" url="/terms" target="lightbox"]
```

Unlisted shortcode attributes will be parsed and passed to the view after sanitization, so extending plugins can add additional options.

By default, only shortcodes passed to `output/longtext` view will be expanded automatically.
You can manually expand shortcodes using `hypeapps_expand_embed_shortcodes($text)`.

You can strip shortcodes (e.g. when displaying a summary), using `hypeapps_strip_embed_shortcodes($text)`.

### Static assets

If you are using the same images across multiple posts, you may way to use static assets,
as they allow you to take advantage of simplecache, thus offering better performance than
file entities.

Create a folder in your dataroot `/embed/` and place your image files in there, flush the caches,
and you will see your images in the Assets tab of the embed lightbox window.
