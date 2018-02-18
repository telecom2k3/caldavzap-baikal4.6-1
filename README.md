# rc-caldavzap-colors v1.1
This is a fork of Offerel's CalDavZAP plugin for Roundcube.  CalDavZAP is a Javascript CalDAV client.  Offerel's package is a PHP wrapper, of sorts, for CalDavZAP, passing Roundcube user credentials to the Javascript client and rendering CalDavZAP within a Roundcube frame.  This fork is based upon Offerel's Version 1.1.3 release.

This fork provides three functions:

(1) Provides support for the <b>CATEGORIES</b> attribute so that CalDavZAP now supports the DTSTART, DTEND, SUMMARY, DESCRIPTION, RRULE, LAST-MODIFIED, CREATED, DUE, RECURRENCE-ID, EXDATE, TRIGGER, ACTION, STATUS, PERCENT-COMPLETE, UID, VERSION, TZOFFSETFROM, TZOFFSETTO, DURATION, CLASS, TRANSP, URL, and CATEGORIES attributes.<br>
(2) Provides for <b>Event Coloring</b> (Red, Green, Blue, Yellow, Orange, Purple) compatible with MS Outlook.  The Selection Box options in the CATEGORIES field was dervied from the Thunderbird, Rainlendar, and Outlook clients.<br>
(3) Optionally, this plugin will talk to a Baikal MySQL database to transparently <b>add</b> users to the Baikal MySQL database.  This plugin will automaticaly create both a <b>"default" calendar</b> and a <b>"default" contacts</b> database for the Roundcube user.  This plugin <b>automatically sets</b> the Baikal user credentials to match that of the Roundcube user.  Users can <b>change their password</b> with the Roundcube "Password" plugin without any problems.<br>

Requirements:

  Baikal CalDAV Server, Version 4.6 with a MySQL database (option)<br>
  Roundcube Webmail package<br>
  PHP > 5.5 (PHP versions 5.6 and 7.2 tested)

Installation:

(1) Extract the contents of this archive into a plugin folder named "caldavzap".<br>
(2) Copy the "config.inc.php.dist" in the top-level "caldavzap" folder to "config.inc.php" and modify appropriately.<br>
(3) Modify the "config.js" file in the "caldavzap_0.13.2" folder appropriately.<br>
(4) Implement the Baikal database modifications per the instructions in "/plugins/caldavzap/caldavzap_0.13.2/misc/readme_baikal_sabredav.txt".

Operation:

When a user clicks on Contacts or Calendar, the plugin will automatically create all the necessary user and database entries in the Baikal server.  If a Roundcube user's password changes, the plugin will automatically update the user entry in the Baikal server.

Testing:

(1) The CalDavZAP Calendar functions can be tested independently of Roundcube.  Modify the file "/plugins/caldavzap/caldavzap_0.13.2/config.js" to add your CalDAV server URL and then point your browser to: "/plugins/caldavzap/caldavzap_0.13.2/index.php".<br>
(2) Caldavzap is an HTML5 Javascript client.  After making any changes, make sure you:<pre>
    - Run the "cache_update.sh" script in the "/plugins/caldavzap/caldavzap_0.13.2/" folder
    - Clear your browser cache
    - Close and restart the browser</pre>
(3) Use Google Chrome's Developer Tools to identify any problems with webserver content headers.

Support:

Support for this plugin is limited to compatibility with Roundcube only.  There are a lot of different CalDAV servers out there, all with different operating capabilities and configurations.  If you use Nextcloud, Owncloud, Purecloud, or WhatEver cloud, etc. please contact them for assistance.

