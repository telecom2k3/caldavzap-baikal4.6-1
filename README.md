# caldavzap-bk4.6
This is a fork of Offerel's CalDavZAP plugin for Roundcube.  CalDavZAP is a Javascript CalDAV client.  Offerel's package is a PHP wrapper, of sorts, for CalDavZAP, passing Roundcube user credentials to the Javascript client and rendering CalDavZAP within a Roundcube frame.

This fork provides three functions: (1) Talks to a Baikal MySQL database to transparently add users, or automatically change user credentials, to/with a Baikal CalDAV server.  (2) Provides support for the CATEGORIES attribute so that CalDavZAP now supports the DTSTART, DTEND, SUMMARY, DESCRIPTION, RRULE, LAST-MODIFIED, CREATED, DUE, RECURRENCE-ID, EXDATE, TRIGGER, ACTION, STATUS, PERCENT-COMPLETE, UID, VERSION, TZOFFSETFROM, TZOFFSETTO, DURATION, CLASS, TRANSP, URL, and CATEGORIES attributes.  (3) Provides for Event Coloring compatible with MS Outlook.

Requirements:

  Baikal CalDAV Server, Version 4.6 with a MySQL database<br>
  Roundcube Webmail package
  

  
  
