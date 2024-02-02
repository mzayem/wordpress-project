=== Portfolio for Elementor, Image Gallery & Post Grid  | PowerFolio ===
Contributors: wppug, rexdot, freemius
Donate link: 
Tags: portfolio, filterable portfolio, portfolio gallery, responsive portfolio, image gallery, gallery, elementor
Requires at least: 4.0
Tested up to: 6.2
Requires PHP: 5.3
Stable tag: 2.3.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin extend Elementor by adding the Post Grid, Portfolio & Filterable Image Gallery widgets for free!

== Plugin Demo ==
[Click here to see the portfolio demo](https://powerfoliowp.com/)

== Overview ==

This plugin extend Elementor by adding the Post Grid, Portfolio & Filterable Image Gallery addons/widgets for free! 

It allows you to create a creative portfolio to show your projects using the Drag&Drop interface of Elementor. 

It also adds a filterable image gallery with several options to customize.

It's very useful to create a portfolio of websites or web development projects and it is specially made for creative professionals such as designers, web developers and photographers. 

You can also enable the filterable portfolio and gallery option, separating your projects into categories that can be filtered.

It's also useful to create amazing image galleries on your website.

Besides, it now also has Post Grid and Product Grid widgets for Elementor, with several options on Elementor screen to customize each part of the posts grid or Woocommerce product grids.


== Demo Videos ==
Getting started with your first portfolio #1
[youtube https://www.youtube.com/watch?v=6wrMp5li8ns&t]

Getting started with your first portfolio #2
[youtube https://www.youtube.com/watch?v=eikLVsTO0yw]

This is a detailed tutorial on how to build a nice portfolio with the plugin
[youtube https://www.youtube.com/watch?v=sJFL3iG1Xjk]

== Features ==
* Filterable Portfolio Addon/Widget for Elementor
* Filterable Image Gallery Addon/Widget for Elementor
* Posts Grid Addon/Widget for Elementor
* Woocommerce Products Grid Addon/Widget for Elementor
* You can display only a Custom Portfolio Category if you want
* You can show the projects on a modal or on a single page
* Compatible with Elementor (Portfolio Widget)
* Compatible with any page builder (if you use the shortcode)
* Compatible with Gutenberg (if you use the shortcode)
* Masonry,Boxed and Packery Grid layouts (and also a grid builder in PRO version!)
* 2,3,4,5 or 6 collumns
* 4 Post/Product Grid Styles - Classic, Masonry and 2 creative styles

== Elementor Portfolio Widget/Addon ==
With this Elementor portfolio widget, you can display the posts of the portfolio post type in a filterable gallery. You have options to customize everything, from the layout/grid to the hover effects. 

== Filterable Image Gallery for Elementor Widget/Addon ==
You can use the Elementor gallery widget to display a filterable image gallery in your page. You will have the same customization options as the portfolio for elementor widget.

== Image Gallery GRID Builder (PRO Version) ==
With the grid builder, you wil be able to customize the width and height of each item in your gallery. In combination with the packery layout and the filter, it allows you to create unique and magic grids.

== Posts Grid for Elementor Widget ==
With this Elementor widget, you can display the content of the "post" post type in a customizable post grid, with several style options. 

== Products Grid for Elementor Widget ==
You can use this Elementor widget to display the products of your Woocommerce store.


== PRO version Features ==
* 14 hover effects
* 10 grid styles, including our exclusive Special Grids
* Grid Builder
* Portfolio Carousel Widget
* Extra CSS effects and animations
* Option to display a specific portfolio category
* Option to display content from any post type to the grid
* Extra customization options

== Installation Instructions / How to use ==
1. Upload `elementor-portfolio` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Click on the "Portfolio" link from the main menu
4. Click on "Add New Item", create your first portfolio content and publish. Create as many posts you want.
5. Create a new page using Elementor, or edit a existing open
6. Drag and drop the portfolio widget to your page.
7. Customize it using the widget options and publish the page.
8. Done! Your new portfolio is ready!

= How to display the filterable portfolio grid using a shortcode =

The widget will be available in Elementor items. Just drag it to your website and select the customization options :)

You can also use dthe shortcode to display the portfolio grid on a page/post, or using Gutenberg and other page builders:

[powerfolio]

You can customize it using these options:

* **postsperpage:** Set a number of posts to show (eg: postsperpage="12").
* **showfilter**: Show the category filter on the top of the grid. Options: yes/no. (eg: showfilter="yes").
* **style**: Set the grid style of the portfolio. Options: masonry/box. (eg: style="box").
* **linkto**: Set the link type of the portfolio item. If is set to image, it will open the Featured Image on a lightbox. Options: image/project. (eg: linkto="image").
* **columns**: Set the columns per row of the portfolio grid. Options: 2/3/4. (eg: columns="4").
* **margin**: Choose if you want a margin between the items or no. Options: yes/no. (eg: margin="no").

**Example of a complete shortcode:**

[powerfolio postsperpage="12" type="no" showfilter="yes" style="masonry" linkto="image" columns="4" margin="no"]

**Example of a complete shortcode without the set properties:**
[powerfolio postsperpage="" showfilter="" style="" linkto="" columns="" margin=""]

== Screenshots ==

1. **Portfolio Elementor Widget.** Showcase your work to your audience with a premium portfolio grid.


== Changelog ==
1.0.1 - Initial Release
1.1 - Added Gutenberg Editor to the Portfolio post type / Changed the post type label to "Portfolio" / Added "Freemius" / Fixed 404 errors on portfolio after activation
1.2 - Updated the admin page /  Fixed some issues / PRO version release
1.2.5 - Added video tutorial / Fixed issue with taxonomies and gutenberg / updated freemius SDK 
1.2.6 - Small Fixes / Added a new "Height" control for the boxed grid / Enabled Elementor editor by default for Portfolio Post Type
1.2.7 - Added height control for boxed layout / Added hover effects for the free version / Added 5 and 6 columns option / Small Fixes
1.2.8 - Added margin size control / Added hover effects for the free version / Added white background for transparent PNG's
1.2.9 - Added "All categories" text button / Added "Black and White" hover effect for PRO Version / Fixed Small Issues
2.0 - Added Elementor Image Gallery widget /  Added WordPress filters to the gallery filter / Added Grid Builder (PRO version only) / Added ImageLoaded to javascript / Added packery layout
2.1 - Added Product Grid and Post Grid Widgets
2.1.4 - Added item description for gallery widget
2.1.5 - Added .POT file
2.1.6 - Added option to hide the "All" button (free version) / Added "mobile columns" customization option for PRO version
2.1.7 - Updated Freemius SDK / Fixed error with $portfoliocolumns_mobile/ fixed error in powerfolio_shortcodes.php file
2.1.8 - Fixed issue with jQuery / Added option to use the Elementor native lightbox / Added next/prev buttons on Powerfolio lightbox
2.1.9 - Added border and border-color customization option for items. 
2.2 - Fixed conflicts between simple lightbox and elementor lightbox / Added filter option to completely disable simple lightbox / fixed small css glitches 
2.2.1 - Enabled more than 1 category on "display specific categories" mode
2.3 - Added filters on Portfolio CPT register class / Added option to hide item title and item description / Small UX improvements on the widget edit  / Updated Freemius SDK
2.3.1 - Added validation for shortcode attributes (security fix) / Updated Freemius SDK / Added the "Title Displayed 1" mode for the portfolio grid 
2.3.2 - Added sanitization to attributes and shortcodes (security fix)
2.3.3 - Updated JS libraries (Isotope/OwlCarousel)
2.3.4 - Updated Freemius SDK / Added 2 new hover options / Added PT-BR and Spanish translations