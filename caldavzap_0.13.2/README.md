What you need to know before you start to configure the client:

 1.) principal URL for your server<br>
 2.) what is the difference between cross-domain and non cross-domain setup<br>
 3.) cross-domain setup problems and how to solve them (if you use cross-domain
setup)<br>
 4.) digest authentication problems and how to solve them (if your server uses d
igest auth)<br>
 5.) problems with SSL /https/ and invalid (or self-signed) certificates<br>
 6.) choose your setup type (3 different setup types are supported)<br>
 7.) HTML5 cache update<br>
 8.) Generic installation instruction<br>
 9.) DAViCal (non cross-domain) installation instructions<br>

1.) Your principal URL

    - What is my principal URL?<br>
      Check you server documentation!<br>
      Example principal URLs (<USERNAME> = your username):<br>
        http://davical.server.com/caldav.php/<USERNAME>/ (DAViCal example)<br>
        http://baikal.server.com/card.php/principals/<USERNAME>/ (Baïkal example)<br>
        http://radicale.server.com:5232/<USERNAME>/ (Radicale example)<br>
        http://osx.server.com:8008/principals/users/<USERNAME>/ (OS X example 1)<br>
        https://osx.server.com:8443/principals/users/<USERNAME>/ (OS X example 2<br>

2.) Cross-domain / non cross-domain setup

    - What is the cross-domain setup?<br>
      If your server origin is not identical with your client installation origin then your setup is cross-domain!<br>
    - What is the origin?<br>
      Origin is an URL without the "full path" part => <protocol>://<domain>:<port><br>
      Example 1:<br>
        URL:    http://davical.server.com/caldav.php/<USERNAME>/<br>
        Origin: http://davical.server.com:80 (default port for http is 80)<br>
      Example 2:<br>
        URL:    https://davical.server.com/caldav.php/<USERNAME>/<br>
        Origin: https://davical.server.com:443 (default port for https is 443)<br>
      Example 3:<br>
        URL:    http://lion.server.com:8008/principals/users/<USERNAME>/<br>
        Origin: http://lion.server.com:8008<br>
    - What is my server origin?<br>
      It is your principal URL origin<br>
    - Complete examples?<br>
      Example 1:<br>
        Principal URL: https://lion.server.com:8443/principals/users/<USERNAME>/ (your server URL)<br>
        Client URL:    https://www.server.com/client/ (your client installation URL)<br>
        =><br>
        Server origin: https://lion.server.com:8443<br>
        Client origin: https://www.server.com:443<br>
        Is this setup cross-domain? YES (server origin != client origin)<br>
      Example 2:<br>
        Principal URL: http://davical.server.com/caldav.php/<USERNAME>/ (your server URL)<br>
        Client URL:    http://davical.server.com/client/ (your client installation URL)<br>
        =><br>
        Server origin: http://davical.server.com:80<br>
        Client origin: http://davical.server.com:80<br>
        Is this setup cross-domain? NO (server origin == client origin)<br>
    NOTE: if cross-domain setup is detected you will see a warning in your browser's console!<br>
    NOTE: cross-domain setup is detected automatically and you don't need to set it manually in config.js!<br>

3.) Cross-domain setup problems and how to solve them (if you use cross-domain setup)

    - Why cross-domain setup is problematic?<br>
      The client is written in JavaScript which has one major security limitation (it is hardcoded into browsers):<br>
        If you want to use cross-domain setup and your server NOT returns proper HTTP CORS headers (see http://www.w3.org/TR/cors/) then JavaScript REFUSES to make requests to your server (more precisely: it performs one OPTIONS request /called preflight request/ to check HTTP headers returned by your server, and if no proper CORS headers are returned, then the real request is NOT performed!).<br>
    - What to do to solve this problem?<br>
      a.) Your server MUST return the following additional HTTP headers:<br>
            Access-Control-Allow-Origin: *<br>
            Access-Control-Allow-Methods: GET, POST, OPTIONS, PROPFIND, PROPPATCH, REPORT, PUT, MOVE, DELETE, LOCK, UNLOCK<br>
            Access-Control-Allow-Headers: User-Agent, Authorization, Content-type, Depth, If-match, If-None-Match, Lock-Token, Timeout, Destination, Overwrite, Prefer, X-client, X-Requested-With<br>
            Access-Control-Expose-Headers: Etag, Preference-Applied<br>
      b.) If Access-Control-Request-Method header is sent by your browser (preflight request defined by CORS) then your server MUST return these headers for OPTIONS request WITHOUT requiring authorization and MUST return 200 (or 2xx) HTTP code (Success).<br>
    - Howto add these headers to my CardDAV/CalDAV server?<br>
      Check your server documentation or contact your server developer and ask for CORS or custom HTTP headers support.<br>
    - Howto add these headers to my server if it has no support for CORS or custom HTTP headers?<br>
      Configure custom headers in your web server /or proxy server/ configuration (if possible) - see misc/config_davical.txt for Apache example.

4.) Digest authentication problems and how to solve them (if your server uses digest auth)

    - Why digest authentication is problematic?<br>
      Lot of browsers have wrong or buggy digest auth support (especially if used from JavaScript).<br>
    - What to do to solve this problem?<br>
      a.) Disable the digest authentication and enable the basic authentication in your server config (NOTE: ALWAYS use SSL /https/ for basic authentication!)<br>
      b.) Alternatively (if it is not possible to switch to basic auth) you can try to enable the globalUseJqueryAuth option in config.js (NOTE: there is no guarantee that it will work in your browser)<br>
      NOTE: if you want to use the auth module /see 6.) c.) below/ you MUST use basic auth (there is no digest auth support in this module)!

5.) problems with SSL /https/ and invalid (or self-signed) certificates

    - Why the client cannot connect to server with invalid/self-signed certificates?<br>
      If a user opens a web page and the browser detects invalid/self-signed certificate it warns user about this problem, and usually shows an option to accept the server certificate (or add a security exception) manually. If the request is sent by JavaScript there is NO such option to show user the security warning, and also it is NOT possible to add security exception directly by JavaScript!<br>
    - What to do to solve this problem?<br>
      a.) use valid server certificate from commercial CA or<br>
      b.) if your server certificate is not self-signed and is issued by your own CA, add your CA certificate into "Trusted Root Certificates" in your browser/system or<br>
      c.) open the principal URL directly by browser, accept the invalid certificate (or add a security exception) manually

6.) Client setup types

    - What types of setup are supported by the client?<br>
      a.) Static setup with predefined principal URL, username and password stored in config.js. For this setup use globalAccountSettings (instead of globalNetworkCheckSettings or globalNetworkAccountSettings) and set the href option to your full principal URL in config.js.<br>
          - advantages: fast login process = no username/password is required (no login screen)<br>
          - disadvantages: username/password is visible in your config.js (recommended ONLY for intranet or home setup)<br>
      b.) Standard setup shows login screen and requires valid username and password from the user. For this setup use globalNetworkCheckSettings (instead of globalAccountSettings or globalNetworkAccountSettings) and set the href option to your principal URL WITHOUT the username part (username is appended to the href value from the login screen) in config.js.<br>
          - advantages: username/password is required from the user (no visible username/password in config.js)<br>
          - disadvantages: if a user enters wrong username/password then browser will show authentication popup window (it is NOT possible to disable it in JavaScript; see the next option)<br>
      c.) Special setup sends username/password to the PHP auth module (auth directory) which validates your username/password against your server and if the authentication is successful then sends back a configuration XML (requires additional configuration; the resulting XML is handled IDENTICALLY as the globalAccountSettings /a.)/ configuration option). For this setup use globalNetworkAccountSettings (instead of globalAccountSettings or globalNetworkCheckSettings) and set the href value to your auth directory URL (use the default if the auth directory is stored in the client installation subdirectory). Use this setup AFTER you have working b.) and want to solve the authentication popup problem.<br>
          - advantages: no authentication popup if you enter wrong username/password, dynamic XML configuration generator (you can generate different configurations for your users /by modifying the module configuration or the PHP code itself/)<br>
          - disadvantages: requires PHP >= 5.3 and additional configuration, only basic authentication is supported<br>
          Auth module configuration:<br>
              - update your auth/config.inc:<br>
                  set the $config['auth_method'] to 'generic' (this is the default)<br>
                  set the $config['accounts'] - usually you need to change only the "http://www.server.com:80" part of the
                    href value but you can also change the syncinterval and timeout values<br>
                  set the $config['auth_send_authenticate_header'] to true<br>
              - update your auth/plugins/generic_conf.inc:<br>
                  set the $pluginconfig['base_url'] to your server origin<br>
                  set the $pluginconfig['request'] to the server path (e.g. for DAViCal: '/caldav.php')<br>
              - visit the auth directory manually by your browser and enter your username and password - you will get
                  a configuration XML for your installation (if not, check your previous settings again!)<br>
                  NOTE: the returned XML content is processed identically as the globalAccountSettings /a.)/ configuration option
              - update your auth/config.inc:<br>
                  set the $config['auth_send_authenticate_header'] back to false

7.) HTML5 cache update

    You MUST execute the cache_update.sh script every time you update your configuration or any other file (otherwise your browser will use the previous version of files stored in HTML5 cache); alternatively you can update the cache.manifest manually - edit the second line beginning with "#V 20" to anything else (this file simple needs "some" change)

8.) Generic installation instructions

        a.) read 1-7 above :-)<br>
        b.) copy the source code into your web server directory (if you use Apache it is strongly recommended to enable the following modules: mod_expires, mod_mime and mod_deflate ... see .htaccess for more details)<br>
        c.) set your CardDAV/CalDAV server related configuration in config.js (see 6.))<br>
        d.) set other configuration options in config.js (see comments in config.js)<br>
        e.) update your HTML5 cache (see 7.))<br>
        f.) open the installation directory in your browser<br>
        g.) login and use the client :-)

9.) DAViCal (non cross-domain) installation instructions

        a.) copy the source code into your DAViCal "htdocs" directory (or copy it into other directory and use web server alias in your DAViCal virtual server configuration, e.g.: "Alias /client/ /usr/share/client/")<br>
        b.) open the installation directory in your browser<br>
        c.) login and use the client :-) ... note: if you changed something in config.js (not required) see 7.)<br>


If something not works check the console log in your browser!
