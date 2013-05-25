

BonePup-Boilerplate
=======

Bonepup is a front end for wordpress blogs, based on backbone. With Bonepup, you can deliver your blog or CMS in single page web app style site incorporating an existing wordpress instance.

BonePup-Boilerplate wraps this in a Backbone Marrionette boilerplate code, as an serves it up as a wordpress theme, ready for insertion in a blog. It is intend for wordpress developers just coming to backbone and for use in legacy blogs that need to maintain an existing URL frameworks, such as in to preserve incoming links, etc.

Currently, bonepup supports the retrieval of wordpress posts, pages and custom post types. **Search is not yet implemented.** 

Installation
============

This repo is set up for installation as a 'theme' in an existing wordpress instantiation. All the original wordpress php pages are still present: replace these with your own and any older links elsewhere on the web will still be served without redirection. You may also want to utilize some of the standard wordpress css selectors in your backbone app, so that both sets of pages are set up apropriately.

Setup
-----

**The json parser plugin**
* install the attached json plugin (wordpress admin console/settings/plugins/install plugin from zip/upload)
* activate the plugin, (from wp-admin/plugins.php) if necessary

**The theme**
* place the bonepup directory in your wp-content/themes/ directory
* select the 'bonepup' theme (from wp-admin/themes.php). 

**Setting up the front page**

Bonepup doesn't replace the wordpress's php pages, so URL redirection remains complete - instead, it uses a template display. So, you'll need to create a page to serve as the front page using the bonepup template.
* Create a new page, specifying 'BonePup Front Page' as your page template and set the front page of your wordpress site to point to it.

And a simple demo theme should pop up.

Implementation
--------------

1. Place the BonePup module within your App's name space.

* Do a global search and replace for App.BonePup and replace with [your app's name].BonePup

2. Make a post request.

* A request for post items looks like this:

{'type':'pages'		// valid types are 'pages' and 'posts'
,'number':'10' 		// optional. default is 'all'
,'custom_fields':	// optional. "Put,your,comma-delimited,custom fields,here"

Bonepup initially takes an array of requests, along with an optional URL parameter.

    {url : "put your wordpress blogs URL here"
    ,requests:
    [	'type':'pages'
    	,'number':
    	,'custom_fields':"Put,your,comma-delimited,custom fields,here"
    	]
    }
			
On completion of all the initial requests, BonePup triggers a marrionette callback named Data.Ready. Hook things like the site render and reveal into this, and nothing will appear until it's ready:

    Data.Ready.on(function(){

	// do stuff with the data here
	
    };

Posts are accessible at [YOUR APP]Data.Posts

Pages
-----

The collection Data.Pages is a hierarchical collection of models, with children pages accessible as an array in the parent's 'children' attribute. 

The collection Data.PageIndex is a flat stack of all the pages. It is a convenience method reference to the PageIndex function that each page Model contains. 

Sort the pages by their custom_fields to filter them into different collections, for managing different groups of pages.

    //create product collection, menu collection
    Menu = new Data.PageCollection(Data.Pages.where({description:'menu'}));
    Products = new Data.PageCollection(Data.Pages.where({description: 'gallery'}));

