# pretix-wp-plugin
Plugin to integrate a pretix ticketing system into a WordPress page
### This Plugin still in beta, please see open issues for further information!
## What does this plugin do?
This software is a plugin designed for the [WordPress CMS](https://wordpress.org), which displays an [embedded pretix ticket shop](https://docs.pretix.eu/en/latest/user/events/widget.html) inline within an article.
## How to use this plugin
First, download the plugin into your WordPress Plugin Directory:
```bash
cd [your-wordpress-root]
cd wp-content/plugins/
git clone https://github.com/jfwiebe/pretix-wp-plugin.git
```
Second, enable the `Wordpress Pretix Integration` plugin, which can now be found in your WordPress Admin Panel. Now, under "Settings -> Pretix Settings", set up the URLs of your pretix installation:
+ **CSS File Link** is the link to the CSS file, e.g. `https://pretixdemo.com/demo/democon/widget/v1.css`
+ **JS File Link** is the link to the JS file, e.g. `https://pretixdemo.com/widget/v1.en.js`

Short notice: The CSS and JS files are used for all events, so all shops will be displayed with the color that is specified in the event of the css file and all static texts ("Add to Cart") will be in the language specified in the JS file.

Third, insert the ticketshop somewhere on your page by typing `[pretix-widget eventurl="https://pretixdemo.com/demo/democon/"]` into an article. If you want to sell tickets for an event in a event series, you also have to specify the "subevent" tag, so the tag would look like `[pretix-widget eventurl="https://pretixdemo.com/demo/democon/" subevent="5"]`. The plugin will replace the placeholder with the ticketshop.

Of course, you have to adjust the URLs to your installation. The urls can be found in the code snippet that pretix generates on the "Widget" tab in your event's settings.

# Contributing
Feel free to contribute improvements, bug-reports or bugfixes by creating an issue and/or a pull-request. If you have any further questions, please do not hesitate to ask!
# License
This code is licensed under the Apache 2.0 License, please see the LICENSE file for the full license text.
