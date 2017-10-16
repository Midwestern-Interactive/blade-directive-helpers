# Blade Helpers
*A collection of Blade Directive to speed up tasks that are common in Blade templates*

## Installation
1) Move the two included `php` files in to `/app/Providers/`.
2) In `/config/app.php` add
```php
        /**
         * Custom Service Providers
         */
        App\Providers\BladeDirectiveProvider::class,
        App\Providers\BladeIfDirectiveProvider::class,
```
3) The above will enable the directives in your Blade templates.

**Since Blade tags get compiled into normal PHP inside your template you are REQUIRED to clear your compiled views via a `php artisan view:clear` call!**

## Usage
### Blade Helper Directives
*A Blade directive is just a shorter syntax to generate markup.
#### `asset`
*The `@asset` directive provides chache busting functionality by appending the Unix timestamp value of the files modified timestamp
```php
<link href="@asset('/css/app.css')" rel="stylesheet">
```
The above markup produces...
```html
<link href="/css/app.css?v=1506526109" rel="stylesheet">
```
This effectively eliminates unwanted caching since any time `app.css` is deployed the files modified timestamp will get updated and consequently change the `v=` value in the url for the css file.

**A CSS example is shown above, but this can be used for ANY local file you wish to have cache busting enabled on**
#### `icon`
*The `@icon` directive allows you to generate the full syntax for a simple icon (more complex icons i.e. layered, rotating, etc will still need to be written out). Font-awesome is the assumed font library.*

In its simplest form you just pass the name of the icon.
```php
<a href="#/">@icon('envelope')Messages</a>
<!-- Produces -->
<!-- <a href="#"><i class="fa fa-envelope"></i></a> -->
```
You can also pass two additinal parameters. The second parameter is the `$provider` so an example would be *glyphicon*. This should be the class that gets added to the element. The third parameter you can use the the tag type (`i`, `span`, etc). **If you need access to the third tag you are required to pass the second!**

A full example of this would be...
```html
<a href="#">@icon('envelope', 'glyphicon', 'span') Messages</a>
<!-- Produces -->
<!-- <a href="#"><span class="glyphicon glyphicon-envelope"></span></a> -->
```

### Blade If Directives
*Blade "If" directives allow you to shorthand an `if` statment that you'd normally have to write out. These inherently have an `else` block available*

#### `hasPermission`
*The has permission directive allows you to wrap markup that you only want displayed if a user has a given permission. Can be used in place of the `@can` directive.*
```php
@hasPermission('manage-users')
    <li><a href="...">Manage Users</a></li>
@else
    <!-- Alternate link if they can't manage users -->
@endhasPermission
...
```

#### `isInRole`
*Checks that the user is in a given Role*

```php
...
@isInRole('admin')
    <li><a href="...">Manage Users</a></li>
@else
    <!-- Alternate link if they can't manage users -->
@endisInRole
...
```

#### `isActive`
*This is used to see if a link is currently the active link*

```php
<a href="#" @isActive('/')class="active"@endisActive>Home</a>
```

This directive calls the `Request::is(...)` function internally so you can pass any string to check that would work there. i.e. `@isActive('users*)` would match `/users` as wells `/users/manage/1`

As with all if directives there is an `else` block available. i.e. `<a href="/users" class="@isActive('users')active @else muted@endisActive>Users</a>`