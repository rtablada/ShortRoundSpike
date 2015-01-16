## ShortRound CMS...ish

This is the playground that I am using to spike out ShortRound CMS.

> Hold on to your potatoes!

ShortRound is in pre-alpha stages!
You have been warned!

---

Now to the fun bits.

ShortRound is going to be a set of tools for building fast content type based CMS systems and Admin Panels with Laravel 5.
At the end of the day, it's all code, everything can be changed, no magic (at least no magic that can't easily be followed).
The system will revolve around a few key pieces:

1. A Blueprint command (pulls in code from ShortRound into any Laravel 5 project)
2. An admin layout system based on [SB-Admin 2](http://ironsummitmedia.github.io/startbootstrap-sb-admin-2/pages/index.html) (This may change later to a different framework)
3. A driver based menu system
4. A Role Management System (this will be eventually abstracted to a package named "Clique")
5. A configuration file based page manager (this could easily be swapped for a DB driven page manager)
6. A Gadget System (more on this in a bit)
7. Flexible Site Settings Management
8. A rich text copy plugin powered by the clean and simple to use [Medium Editor](https://github.com/daviferreira/medium-editor)
9. Content Type Generators
10. GUI Developer Tools

---

### Blueprint Command

The blueprint command for ShortRound will allow you to simply run `composer require rtablada/shortround`, add a set of service providers to your `app.php` config and then run `php artisan shortround:start`.

This will pull in the default ShortRound routes, controllers, models, gateways, configs, and much more!
Hopefully this will have options to pull in components of the system by choice.
If you don't want the Copy content type to ship with the system, you don't need to!

### Admin Layout

ShortRound ships with SB-Admin 2 pulled in with Bower and a start `gulpfile` that uses Laravel Elixir to compile LESS styles, concat JS, files and get everything ready.
The Blueprint Command pulls in a minimal layout as well as the layout needed to make the more fully featured admin pages (with side and top navigation bars).

### Driver Based Menus

One of the important parts of making a user friendly CMS is an easily customizable menu system.
ShortRound ships with a customizable menu system.

One of the issues that my team has run into with other menu systems was the way that they lock you to a menu system.
This often means translating your menu changes from development to staging or production means reseeding the menus table.
To get around this, for a more developer centric flow, ShortRound has a menu driver that loads just from config files: just push your changes and it is up to date EVERYWHERE!

There's also an Eloquent based DB Menu Driver, but at least right now, it is limited to seeded data (although you are free to create your own menu editing system or contribute one to the project).

In the future, I'd like to have a nice drag and drop menu system, and eventually a mix driver that will allow users to position both array and CMS driven menus at the same time.

### Role Management System

ShortRound will have a flexible Role Management System.
By default, as roles are added to the `roles` table, they become available for admins to add privileges in the user manager.

This eventually will be pulled out into a small modular Role Package called Clique that will have a quick trait to drop on your User Eloquent model and then it will provide a nice interface with the following functions:

- `hasRole` - Check if a user is in a single role (ex. is this user an admin?)
- `inRoles` - Like `hasRole`, but check across multiple roles (ex. is the user either an admin or creator?)
- `ensureRole` - Stop worrying about looking up roles and attaching them, no duplicate related results either, just works
- `detachRole` - Want to make sure that one user can never take an admin action again? This is the method for you!

Did I mention that Clique also does some crazy sweet caching too?
So you won't need to make a bunch of DB calls!

### Page System

In most CMSes there's at least a handful of routes without dynamic segments for the front-end of an app.
And, how many times do you really want to write something like this:

```php
// routes.php
Route::get('contact', 'ContactController@show');

// app/http/controllers/ContactController.php

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }
}
```

The Page System is a catch all route (possibly moving to middleware if possible), that does this work for you!
In `config/pages.php` you define the urls that you want to match and the view that you want to use and that's it.
No extra controllers needed!

### Gadget System

With the page system you are probably thinking "that's great but my home page, contact page, etc. need to have dynamic content".
This is where Gadgets come in.
Gadgets allow you to bring in reusable and testable dynamic backed bit of markup into your templates.
When declaring a Gadget you only have to define a public `render` function and the rest is up to you to do whatever you want.

You can see an example of a gadget with the (Menu Gadget)[app/Gadgets/Menu.php], this pulls in the MenuGateway and then injects results and renders a view template.
Or your gadgets can be simpler like the (Site Settings Gadget)[app/Gadgets/SiteSetting.php] which just returns a string instead of rendering another view.

### Site Settings Manager

How many times have you been working on a CMS and the client says "we need a way to edit our":

- Facebook URL
- Intranet Link
- Google Analytics Code
- Contact Form Email Address
- etc.

It's a pain, and far too often, as developers we have to make an awkward database table just to store these types of values.
Then we have to keep going back to this table to add things to it.

ShortRound ships with an quick and easy to use Site Settings content type that automatically adds fields to the admin panel as you add fields to your database (either through the Seed file or directly).

Eventually I'd like to have an intelligent seeder that only adds new fields to the site settings (and even better if it could backwards update the seed file as an option).

To use site settings in your templates you can use the `Setting::get` facade or the blade helper `@setting`

### Copy Content Type

Much like site settings, there's miscellaneous site copy scattered about that needs to be fully editable from the CMS.
You want to give your end user the ability to express themselves, but also know that they have super powers when it comes to breaking the layout.
Then they come back to you:

> I step where you step! I touch nothing!

The copy Content Type that ships with ShortRound allows you to keep all of your copy in one place.
And the Medium Editor gives your end user the ability to make headings, links, quotes, bold, underline, and italics: all from an easy to use page.

Then when it comes time to getting the content into your templates just use `Copy::get` or `@copy` and pass in the slug that you want to look up.

### Content Type Generators

CMSes are all about easy to enter content types.
Clear, structured content types make it easy for anyone to enter new data and help lower the barrier of keeping things up to date.
But I could talk about Content Types for days and this isn't about "Why Content Types".

ShortRound will eventually have an incredibly powerful set of generators that give you great looking code that is ready out of the box, but you can edit having to learn some new sort of paradigm or hunt for tons of files.
The generators can fill out everything you want when creating a new content type

1. Migration
2. Model
3. Gateway (Some may want to call this a Repository)
4. Controller
5. Routes
6. Views
7. Menu Items (add to the seed and config file)
8. Gadget

It's a lot and I want to create an awesome interface around things to make it easy to get just what you want.

### GUI Developer Tools

When working with CMS systems, there are some nice things like being able to drag around menu items.
Or creating new content types from a GUI (dealing with the syntax for adding 9 rows to a generator command can be really awkward [and even more awkward to revert]).

These are the styles of developer tools that I want to make available with ShortRound.
And there's more that I'd like to play with:

1. Migration Status (see all of your migration files and whether they've been run and possibly run them?)
2. Seed Updater - Publish your current data as seed files so you can refresh your system or move staging data to production
3. CSV Exporter - Export your DB tables as CSV files
4. API Builder - Build API Structures with your existing content types

Some of the ideas are more far fetched, but that just is a glimpse of what could be possible.

---

## Share All The Things

ShortRound will be released under the MIT license so you can extend it and use it on your own projects or ones for clients.

But, ShortRound will also be using (or expanding to use) a lot of third-party code to make things awesome:

- [Vaprobash](https://github.com/fideloper/Vaprobash) - Vagrant Provisioning
- [Vaproconf](https://github.com/rtablada/Vaproconf) - Vagrant Configuration
- [Lisitfy](https://github.com/lookitsatravis/listify) - Easy ordering for Eloquent models
- [Stapler](https://github.com/CodeSleeve/stapler) - File Uploads and relations
- [SB Admin 2](https://github.com/IronSummitMedia/startbootstrap-sb-admin-2) - Admin Theme for Bootstrap
- [FooTable](https://github.com/fooplugins/FooTable) - Awesome mobile friendly tables
- [Medium Editor](https://github.com/daviferreira/medium-editor) - Rich Text Editor

And I continue to look at how I can extract reusable code from ShortRound and partners and packages to continue to make the web community awesome!!!

## And Remember

> Hey, Dr. Jones, no time for love. We've got company.
