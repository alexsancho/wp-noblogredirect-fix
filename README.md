# WP Plugin:WP NOBLOGREDIRECT fix

## Installation
Preferred installation way is with composer:
```
$ composer require alexsancho/wp-noblogredirect-fix
```

## About
A little explanation for those who have no idea what NOBLOGREDIRECT is.

The define(‘NOBLOGREDIRECT’, ‘%siteurl%’); inside of the wp-config.php makes it so that when someone enters a subdomain that does not exist on your site to redirect to whatever url you wish it to.   You can use this to have it either go to a specific FAQ page or directly back to the main root installation, anywhere you want to direct it.  the %siteurl% can be replaced for example `define('NOBLOGREDIRECT', 'http://frumph.net/FAQ/site-create');`

When someone in their browser tries to go to (for example) http://badsubdomain.frumph.net/ a subomain which doesn’t exist, it will go to what is defined in NOBLOGREDIRECT.

Without using NOBLOGREDIRECT the (for example) http://badsubdomain.frumph.net/ – which is a subdomain that doesn’t exist would direct to the signup page asking which reports whether or not the user can create the bad subdomain in question.   This is fine, there’s nothing wrong with it redirecting to the signup page if someone put in a bad url.   However, those of us who think it’s rather tasteful to have the user just redirect to the home page don’t like that, so we want to use the NOBLOGREDIRECT to direct things to the front page; have the user look at the site first.

Now where’s the behavior problem?  It’s when using NOBLOGREDIRECT and on your normal use of the mainsite.   The bad behavior is when someone goes to a page on the normal site that doesn’t exist.  For example http://frumph.net/idontexist/  ;  Instead of redirecting to the sites 404 page (the page not found template) it will redirect you to what is specified in NOBLOGREDIRECT.  Wait.. what?  Why does it do that?    The behavior of redirecting 404 pages is an old function used in WPMU that should not exist anymore however is left in when WPMU was merged with WordPress itself.

What can be done to fix the behavior so that it goes back to dishing out 404 pages?   Well that’s easy, you just disable the function from being called that would redirect those 404′s.

In your /wp-content/mu-plugins/ folder, (if you don’t have one and are using multisite, you can create it manually)  you add a custom.php file to it and add a line to disable the action.

For example, create a file named custom.php  toss it into the /wp-content/mu-plugins/

    custom.php
    1	<?php
    2	remove_action( 'template_redirect', 'maybe_redirect_404' );
    3	?>

The function that is causing the bad behavior of not directing 404 pages properly is maybe_redirect_404() and it’s being called as an add_action, so in order for us to not have the function run we remove the add_action with remove_action.

Having the custom.php file (a file we created just now) placed in the mu-plugins folder means that its automatically activated and running at all times.

Now those 404 pages are redirecting to the 404 page not found template for your theme and bad subdomains entered will go to whereever you specified in the NOBLOGREDIRECT.

- Phil

NOTE: NOBLOGREDIRECT in its original intent is useful to pointing to some ‘other’ location when a signup page is required instead of sending to a 404 page, however the naming convention for the define is misleading which then leads to end-user misunderstanding of its function; although I still have no idea why anyone would *want* the signup page to show up on a 404 but obviously the multisite guys do because they still argue it’s validity.

Source: http://frumph.net/2010/06/05/wordpress-3-0-multisite-subdomain-installation-noblogredirect-behavior-fix/
