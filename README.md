# ReachDigital Magento 2 Admin Links module

This module allows you to send links to admin pages.
To create a link you can click the `Get admin link` button in the toolbar at the top of the page.
This will copy a link to your clipboard which can be used to access the admin page.

To ensure that this remains secure only get requests are supported.
On top of that, it is not possible for an attacker to create a redirect link to any admin page.
The module has to register the link in the database before it can be used.

## Creating a link programmatically

If you want to use this functionality in your own module, you can use the `ReachDigital\AdminLinks\Model\AdminLinkManager` class.
You should call the `getAdminLinkForUrl()` function and provide the url for which you want to create a link.
You do not need to pass the admin endpoint, only the controller action.
For instance: `getAdminLinkForUrl('customer/index/index')` will return a link that will redirect to the customer grid.

## TODO

- When the admin session expires, ensure that the user returns to their previous url after logging back in.
