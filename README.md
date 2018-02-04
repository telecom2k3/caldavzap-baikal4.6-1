# caldavzap-baikal4.6
This is a fork of Offerel's CalDavZAP plugin for Roundcube.  CalDavZAP is a Javascript CalDAV client.  Offerel's package is a PHP wrapper, of sorts, for CalDavZAP, passing Roundcube user credentials to the Javascript client and rendering CalDavZAP within a Roundcube frame.  This fork is based upon Offerel's Version 1.04 release, with the interface.js fix in Version 1.1.

This fork provides four functions:

(1) Talks to a Baikal MySQL database to transparently add users to the Baikal MySQL database.<br>
(2) Will automatically change Baikal user credentials to match that of the Roundcube user.<br>
(3) Provides support for the CATEGORIES attribute so that CalDavZAP now supports the DTSTART, DTEND, SUMMARY, DESCRIPTION, RRULE, LAST-MODIFIED, CREATED, DUE, RECURRENCE-ID, EXDATE, TRIGGER, ACTION, STATUS, PERCENT-COMPLETE, UID, VERSION, TZOFFSETFROM, TZOFFSETTO, DURATION, CLASS, TRANSP, URL, and CATEGORIES attributes.<br>
(4) Provides for Event Coloring (Red, Green, Blue, Yellow, Orange, Purple) compatible with MS Outlook.

Requirements:

  Baikal CalDAV Server, Version 4.6 with a MySQL database<br>
  Roundcube Webmail package
  PHP > 5.5 (PHP 7.2 tested)


  

  
  
