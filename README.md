# caldavzap-baikal4.6
This is a fork of Offerel's CalDavZAP plugin for Roundcube.  CalDavZAP is a Javascript CalDAV client.  Offerel's package is a PHP wrapper, of sorts, for CalDavZAP, passing Roundcube user credentials to the Javascript client and rendering CalDavZAP within a Roundcube frame.  This fork is based upon Offerel's Version 1.04 release, with the "interface.js" fix from Version 1.1.

This fork provides four functions:

(1) Talks to a Baikal MySQL database to transparently <b>add</b> users to the Baikal MySQL database.  This plugin will automaticaly create both a <b>"default" calendar</b> and a <b>"default" contacts</b> database for the Roundcube user.<br>
(2) Will <b>automatically set</b> Baikal user credentials to match that of the Roundcube user.<br>
(3) Provides support for the <b>CATEGORIES</b> attribute so that CalDavZAP now supports the DTSTART, DTEND, SUMMARY, DESCRIPTION, RRULE, LAST-MODIFIED, CREATED, DUE, RECURRENCE-ID, EXDATE, TRIGGER, ACTION, STATUS, PERCENT-COMPLETE, UID, VERSION, TZOFFSETFROM, TZOFFSETTO, DURATION, CLASS, TRANSP, URL, and CATEGORIES attributes.<br>
(4) Provides for <b>Event Coloring</b> (Red, Green, Blue, Yellow, Orange, Purple) compatible with MS Outlook.  The Selection Box optons in the CATEGORIES field was dervied from the Thunderbird, Rainlendar, and Outlook clients.

Requirements:

  Baikal CalDAV Server, Version 4.6 with a MySQL database<br>
  Roundcube Webmail package<br>
  PHP > 5.5 (PHP 7.2 tested)
  
Installation:

(1) Extract the contents of this archive into a plugin folder named "caldavzap".<br>
(2) Modify the "config.inc.php" file in the top-level "caldavzap" folder appropriately.<br>
(3) Modify the "config.js" file in the "caldavzap_0.13.2" folder appropriately.<br>
(4) Implement the Baikal database modifications per the instructions in "/plugins/caldavzap/caldavzap_0.13.2/misc/readme_baikal_sabredav.txt".


Operation:

When a user clicks on Contacts or Calendar, the plugin will automatically create all the necessary user and database entries in the Baikal server.  If a Roundcube user's password changes, the plugin will automatically update the user entry in the Baikal server.

Testing:

(1) The CalDavZAP Calendar functions can be tested independently of Roundcube.  Simply point your browser to: "/plugins/caldavzap/caldavzap_0.13.2/index.php".<br>
(2) Caldavzap is an HTML5 Javascript client.  After making any changes, make sure you:<br>
    - Run the "cache_update.sh" script in the "/plugins/caldavzap/caldavzap_0.13.2/" folder<br>
    - Clear your browser cache<br>
    - Close and restart the browser<br>
(3) Use Google Chrome's Developer Tools to identify problems with webserver content headers.



  

  
  
