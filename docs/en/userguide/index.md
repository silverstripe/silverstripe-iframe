---
title: IFrame page
summary: Embed IFrames in your website without adding code
---

# IFrame

## In this section:

* Create and modify an IFrame

## Before we begin
Make sure that your SilverStripe installation has the [IFrame](http://addons.silverstripe.org/add-ons/silverstripe/iframe) module installed.

This module provides a page type that you can use to embed IFrames in your website.

## Creating an IFrame

IFrame pages are created like any other page. When you create a new page, selected the **IFrame Page** from the list of available page types.

There are a few new fields on an IFrame page.

The most important is *Iframe URL*: this is the URL that wish you display inside the IFrame. This can be an absolute
path (ie, http://example.com/) or a relative path (ie, /about-us/). If it is a relative path then it will be assumed to
be from the root of your site (ie, http://mysite.com/about-us/).

*Auto height* will change the height of the IFrame to match the total height of the remote page. This will only work if
the remote page is hosted on the same domain.

If you check *Auto width* the IFrame will take up the entire width of the content area that it is in.

You can manually set the height and width with the *Fixed height* and *Fixed width* fields.

The *Content* field has been broken up into three separate fields: one to display above the IFrame, one to display
beneath the IFrame, and another to display instead of the IFrame if the user has disabled them.

## Known Issues

A common test case is to enter "http://google.com" as the IFrame URL. This won't work! Google's website has the
*X-Frame-Options: SAMEORIGIN* header which means that it can only be displayed in an IFrame with a bit of technical
hackery. If you experience a white box displaying with any other website, check if it has that option set in the
header.