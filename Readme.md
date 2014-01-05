Image Color Filter for Craft CMS
=================

Simple Image Color filter for Craft CMS.

Grabs the most prominate colors from any image asset using a twig filter on an assets object


Usage
------


```
<div style="background-color: url({{ entry.image[0]|imageColor }})">

	<img src="{{ entry.image[0].url }}"/>
</div>

```
Grabs the second most prominate color (0 index).  Currently saves up to 5 colors per image

```
<div style="background-color: url({{ entry.image[0]|imageColor(1) }})">

	<img src="{{ entry.image[0].url }}"/>
</div>

```



To-do
------

Working on a number of new features

* Settings screen to set number of colors saved
* Assets fieldtype to show dropdown of colors and letting you select which one to use on an image by image basis
* Better error checking and defaults.