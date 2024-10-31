=== Plugin Name ===
Contributors: DylanReeve
Donate link: http://dylanreeve.com/
Tags: events
Requires at least: 2.9
Tested up to: 2.9.2
Stable tag: trunk

A simple events calendar widget which creates an event listing based on posts with a specific custom field.

== Description ==

Displays a calendar-style list of links to posts based on an "event-date" custom-field. This allows for an events
calendar populated from within standard posts.

== Installation ==

1. Upload `post-events` folder to the `/wp-content/plugins/` directory
1. Activate Post Events through the 'Plugins' menu in WordPress
1. Add the Post Events widget to a sidebar.

To include a post in the Post Events widget simply add a custom field called "event-date" with the date of the event
listed in ISO format (YYYY-MM-DD eg. 2010-05-29).

The widget can be configured with a title, maximum number of events to list and date format (based on PHP's date() format strings)

== Frequently Asked Questions ==

= How do I create events? =

Add a post with detail of the event, ensuring that you add a custom field called "event-date" with the date of the event in YYYY-MM-DD format.

== Changelog ==

= 1.0 =
* First release

= 1.1 = 
* Fixed deployment structure problem.

