=== Jusibe SMS Notifications for WooCommerce ===
Contributors: tubiz
Donate link: https://bosun.me/donate
Tags: woocommerce, jusibe, sms, sms notifications, tubiz plugins, tubiz, nigeria, order notifications
Requires at least: 4.7
Tested up to: 5.5
Stable tag: 1.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Jusibe SMS Notifications for WooCommerce allow you to Send SMS order notifications to store admins and customers from your WooCommerce store.



== Description ==

> To use this plugin you need to open an account on <strong>[Jusibe](https://jusibe.com)</strong> and have SMS credits in your account.

This is a Woocommerce Order SMS notifications plugin for Jusibe.

Jusibe is a service that provides you with a REST API to send SMS from your websites and applications.

To signup for Jusibe visit our website by clicking [here](https://jusibe.com)

SMS messages can be sent to the following Nigerian mobile networks

* __glo__
* __mtn__
* __airtel__
* __9mobile__

= Note =

SMS messages can only be sent to Nigerian mobile numbers (glo, mtn, airtel & 9mobile)

= Plugin Features =

*   __Send SMS order notifications__ to store admin when an order is made
* 	__Send SMS order notifications__ to customers once their order status changes
* 	__Send SMS__ to the customer from the order details page


= Suggestions / Feature Request =

If you have suggestions or a new feature request, feel free to get in touch with us via the contact form on our website [here](https://jusibe.com/support/)

You can also follow us on Twitter! **[@jusibe](http://twitter.com/jusibe)**


= Contribute =
To contribute to this plugin feel free to fork it on GitHub [WooCommerce - Jusibe SMS Notifications](https://github.com/tubiz/jusibe-wc-sms-notifications)


== Installation ==

= Automatic Installation =
* 	Login to your WordPress Admin area
* 	Go to "Plugins > Add New" from the left hand menu
* 	In the search box type "WooCommerce - Jusibe SMS Notifications"
*	From the search result you will see "WooCommerce - Jusibe SMS Notifications" click on "Install Now" to install the plugin
*	A popup window will ask you to confirm your wish to install the Plugin.
* 	Click "Proceed" to continue the installation.
* 	If successful, click "Activate Plugin" to activate it, or "Return to Plugin Installer" for further actions.
* 	Open the settings page for WooCommerce and click the "Jusibe SMS," tab.
* 	Configure your "WooCommerce - Jusibe SMS Notifications" settings. See below for details.

= Manual Installation =
1. 	Download the plugin zip file
2. 	Login to your WordPress Admin. Click on "Plugins > Add New" from the left hand menu.
3.  Click on the "Upload" option, then click "Choose File" to select the zip file from your computer. Once selected, press "OK" and press the "Install Now" button.
4.  Activate the plugin.
5. 	Open the settings page for WooCommerce and click the "Jusibe SMS," tab.
6.	Configure your "WooCommerce - Jusibe SMS Notifications" settings. See below for details.



= Setup and configuration =
To configure the plugin, go to __WooCommerce > Settings__ from the left hand menu, then click "Jusibe SMS" from the top tab to configure Jusibe SMS settings





__*Jusibe.com API Credentials*__

* __Public Key__ - enter your Public Key here, you will get this from the settings page in your Jusibe account
* __Access Token__ - enter your Access Token here, you will get this from the settings page in your Jusibe account
* __Sender ID__ - enter the Sender ID that will be used for each sent SMS. Maximum of eleven (11) characters. Mobile numbers not allowed.

__*Admin SMS Notifications*__

* __Enable Admin New Order SMS Notifcations__  - check the box to enable sending of SMS to the store admin when an order is placed.
* __Admin Mobile Number__  - enter the mobile number of the store admin where new order SMS will be sent to, in the format 080XXXXXXXX. Seperate multiple numbers by commas
* __Admin SMS Message__  - enter the message that will be sent to the store admin when an order is placed.

__*Customer SMS Notifications*__

* __Send SMS Notifications for these order statuses:__  - select the order statuses changes that will send a SMS notification to a customer.

__*Customise SMS Messages*__

* __Default Customer SMS Message__  - This is the default SMS message that is sent when an order status changes.
* __Pending SMS Message__  - enter a custom SMS message to be sent when an order status is changed to pending or leave blank to use the default message.
* __On-Hold SMS Message__  - enter a custom SMS message to be sent when an order status is changed to on-hold or leave blank to use the default message.
* __Processing SMS Message__  -enter a custom SMS message to be sent when an order status is changed to processing or leave blank to use the default message.
* __Completed SMS Message__  - enter a custom SMS message to be sent when an order status is changed to completed or leave blank to use the default message.
* __Cancelled SMS Message__  - enter a custom SMS message to be sent when an order status is changed to cancelled or leave blank to use the default message.
* __Refunded SMS Message__  - enter a custom SMS message to be sent when an order status is changed to refunded or leave blank to use the default message.
* __Failed SMS Message__  - enter a custom SMS message to be sent when an order status is changed to failed or leave blank to use the default message.


__*Send Test SMS*__

This allow you to send a Test SMS.

* __Mobile Number__  - enter the mobile number you are test SMS will be sent to
* __Message__  - enter the test message to be sent.

* Click on __Save Changes__ for the changes you made to be effected.



== Frequently Asked Questions ==

= What Do I Need To Use The Plugin =

1.	You need to have Woocommerce plugin installed and activated on your WordPress site
2.	You need to open an account on [Jusibe](https://jusibe.com)
3.	You need to have SMS credits in your [Jusibe](https://jusibe.com) account




== Changelog ==

= 1.3.1 - November 19, 2019 =
*	New: Add new replace variables: products, products with quantity, order notes and payment method

= 1.3.0 - November 19, 2019 =
*   New: Add new replace variables: products, products with quantity and payment method
*   Update: WC 3.8 compatibility.

= 1.2.0 - September 6, 2019 =
*	New: Add new replace variable phone number and shop url
*   Update: WC 3.7 compatibility.


= 1.1.0 - May 13, 2018 =
*	Fix: Deprecated WooCommerce 2.X functions

= 1.0.0 - April 11, 2016 =
*   First release





== Upgrade Notice ==

= 1.3.1 =
*	New: Add new replace variables: products, products with quantity, order notes and payment method


== Screenshots ==

1. WooCommerce - Jusibe SMS Notifications settings page

2. Send SMS metabox on the WooCommerce Order page