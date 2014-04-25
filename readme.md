hypeEmbed
=========

Improved and extended embedding for Elgg 1.8 & 1.9

[Buy me a burger to go with my beer!](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=P7QA9CFMENBKA)

## Features

* Search, upload and embed files on the spot
* Search and embed all other registered object types on the spot
* ECML-ready
* Resolve and embed remote URLs using Iframely


## Notes

* The plugin will work without ECML enabled, but to get the most out of it,
download and enable ECML - https://github.com/Elgg/ecml
* Iframely allows their servers to be used for development and non-profit purposes.
If you are operating a for-profit website, create a self-hosted instance of
Iframely and change the Gateway URL in the plugin settings - http://iframely.com/
* If you do not want to use Iframely, use ```'output:src','embed'``` hook that receives
the URL parameter, and supply back the desired HTML markup obtained from another
oEmbed or similar extraction service
* If you do not have ECML enabled, you can use the URL embeds with JQuery Media Embedding -
http://community.elgg.org/plugins/828195/1.0/jquery-media-embedding-for-18

## Using Elgg Customizable Markup Language (ECML)

### Attributes

By default, the following attributes are allowed for the ECML 'embed' keyword.
You can extend the list of allowed attributes via ```'ecml:attributes:entity', 'embed'``` hook.

* ```guid``` guid of an entity
* ```list_type``` list type, e.g. list or gallery
* ```full_view``` entity listing to show
* ```size``` icon size
* ```context``` a comma separated list of contexts to push into the context stack
				by default, the entity views will be in embed and widgets contexts

Alternative use of the ECML 'embed' keyword allows the standalone ```src``` attribute.
You can extend the list of allowed attributes via ```'ecml:attributes:src', 'embed'``` hook.

Example ECML embed string:

```
[embed guid="555" list_type="gallery" full_view="true" size="large" context="activity,search"]
[embed src="http://youtube.com/893dkeie9"]
```


### Views

You can add custom views to ```embed/ecml/$type/$subtype```.
See ```embed/ecml/object/file``` for an example.


## Developer Notes

* Use ```output/embed``` view to output an embedded URL:

```
echo elgg_view('output/embed', array(
	'value' => 'https://github.com/Elgg/Elgg'
));
```

## Installing with Composer

hypeEmbed can be included in your Elgg project by require from the project's
root composer.json.

Support for composer in Elgg is an experimental feature pioneered by [@Srokap](https://github.com/Srokap/ "Paweł Sroka").

Provisional config to include hypeEmbed into your project:
```json
{
	"minimum-stability": "dev",
	"require": {
		"hypejunction/hypemebed" : "@stable"
	}
}
```

## Screenshots ##

![alt text](https://raw.github.com/hypeJunction/hypeEmbed/master/screenshots/lightbox.png "Lightbox")
![alt text](https://raw.github.com/hypeJunction/hypeEmbed/master/screenshots/ecml.png "ECML")
![alt text](https://raw.github.com/hypeJunction/hypeEmbed/master/screenshots/output.png "Rendered Output")
