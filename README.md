## CKEditor Mentions Notifications
CONTENTS OF THIS FILE
---------------------

* Introduction
* Requirements
* Installation
* Configuration
* Support requests
* History and Maintainers

INTRODUCTION
------------

The CKEditor Mentions Notifications module allows users receive email notifications once their names have been
mentioned in a CKEditor. Users are also able to turn on and off these notifications from their profile page.
Furthermore, site administrators can configure the custom email messages with tokens that mentioned users will receive.

* For a full description of the module, visit the project page:
  https://www.drupal.org/project/ckeditor_mentions_notifications

* To submit bug reports and feature suggestions, or track changes:
  https://www.drupal.org/project/issues/ckeditor_mentions_notifications

REQUIREMENTS
------------

* Drupal 9.4.x and above
* PHP8
* [CKEditor Mentions module](https://www.drupal.org/project/ckeditor_mentions)

INSTALLATION
------------

* Install as you would normally install a contributed Drupal module. Visit
  https://www.drupal.org/docs/8/extending-drupal-8/installing-drupal-8-modules
  for further information.
* Ensure that the CKEditor Mentions module is configured [Configure here](https://www.drupal.org/project/ckeditor_mentions) for the CKEditor of your choice

CONFIGURATION
-------------

Configuration of Flag module involves creating one or more flags.

1. Go to Admin > Structure > Flags, and click "Add flag".

2. Select the target entity type, and click "Continue".

3. Enter the flag link text, link type, and any other options.

4. Click "Save Flag".

5. Under Admin > People, configure the permissions for each Flag.

Once you are finished creating flags, you may choose to use Views to leverage
your new flags.

SUPPORT REQUESTS
----------------

Before posting a support request, check Recent log entries at
admin/reports/dblog

Once you have done this, you can post a support request at module issue queue:
https://www.drupal.org/project/issues/flag

When posting a support request, please inform what does the status report say
at admin/reports/dblog and if you were able to see any errors in
Recent log entries.

MAINTAINERS
-----------------------

Current Maintainers:
* Michael Mwebaze (mwebaze) - https://www.drupal.org/u/mwebaze

