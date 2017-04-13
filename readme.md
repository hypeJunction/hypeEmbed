hypeEmbed
=========
![Elgg 2.3](https://img.shields.io/badge/Elgg-2.3.x-orange.svg?style=flat-square)

## Features

* Search, upload and embed files on the spot
* Search and embed all other registered object types on the spot
* Embed URL previews and rich-media players

![Embed Popup](https://raw.github.com/hypeJunction/hypeEmbed/master/screenshots/embed.png "Embed Popup")
![Editor](https://raw.github.com/hypeJunction/hypeEmbed/master/screenshots/editor.png "Editor")
![Player](https://raw.github.com/hypeJunction/hypeEmbed/master/screenshots/player.png "Player")

## Shortcodes

The plugin supports `embed` and `player` shorcodes.

By default, the following attributes are supported in `embed` shortcode:

 * `guid` - GUID of an entity to embed

By default, the following attributes are supported in `player` shortcode:

 * `url` - URL of the player

All other attributes will be parsed and passed to the view after sanitization.

Example shortcodes:

```
[embed guid="555"]
[player url="http://youtube.com/893dkeie9"]
```

By default, only shortcodes passed to `output/longtext` view will be expanded automatically.
You can manually expand shortcodes using `hypeapps_expand_embed_shortcodes($text)`.

You can strip shortcodes (e.g. when displaying a summary), using `hypeapps_strip_embed_shortcodes($text)`.