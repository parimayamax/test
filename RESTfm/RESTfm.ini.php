<?php

/**
 * @file
 * RESTfm configuration file.
 */

$config = array();

$config['settings'] = array (
    // If we are located in a subdirectory off the web root, set this.
    // Must also be configured in .htaccess if using Apache web server.
    // No trailing slash!
    'baseURI' => '/blog/RESTfm',

    // List of formats we will converse in.
    // Comment out unneeded formats.
    'formats' => array (
        //'example',  // Commented out format example.
        'fmpxml',   // FileMaker FMPXMLRESULT Grammar compliant.
        'html',     // Handy for testing, not so useful in production.
        'json',     // JavaScript Object Notation.
        'simple',   // A simple to parse format, spec. in simple_export.xslt
        'txt',      // Handy for testing, not so useful in production.
        'xml',      // Extensible Markup Language.
    ),

    // Render formats nicely.
    // Improves readability of the native json and xml formats at the expense
    // of increased data size. Increased processing overhead for json with
    // PHP < 5.4.0. Not recommended in production.
    'formatNicely'  => FALSE,

    // Enforce SSL access.
    // Should also be configured in .htaccess if using Apache web server.
    // Should also be configured in web.config if using IIS web server.
    'SSLOnly' => FALSE,

    // Respond 403 Forbidden on 401 Unauthorized.
    // Makes browser side applications run nicer when HTTP basic authentication
    // fails. Stops the browser popping up a Username/Password dialogue,
    // allowing the developer to handle usernames and passwords in JavaScript.
    // Note: Setting is ignored for html and txt formats.
    'forbiddenOnUnauthorized' => TRUE,

    // Diagnostic reporting.
    // This is enabled by default to assist in initial configuration.
    // Should be disabled once deployed to improve performance, and prevent
    // leakage of privileged information.
    'diagnostics' => TRUE,
);

$config['database'] = array (
    // FileMaker Server HTTP URL.
    // If server is localhost, hostspec should be http://127.0.0.1
    // not http://localhost for speed reasons according to
    // FileMaker/conf/filemaker-api.php
    //'hostspec' => 'http://example.com',
    //'hostspec' => 'https://example.com',
    //'hostspec' => 'http://example.com:8081',
   'hostspec' => 'http://FM40.Triple8.net',
   //'hostspec' => 'http://127.0.0.1',
  	  //'hostspec' => 'FM21.triple8.net',
   

    // Default username and password if none supplied in query or no API key
    // supplied. May be empty string for "guest" access.
    // Only applies if useDefaultAuthentication is TRUE.
    'useDefaultAuthentication' => TRUE,
    'defaultUsername' => 'adminP',
    'defaultPassword' => 'ctiuser',
);

/*
 * List of API keys associated with a username and password.
 */
$config['keys'] = array (
    //'EXAMPLEKEY' => array ('exampleuser', 'examplepass'),
);

/*
 * List of allowed origins for cross-site HTTP requests.
 * https://developer.mozilla.org/en-US/docs/HTTP_access_control
 *
 * It is not necessary to set these for most installations. Only web
 * applications being served from a different domain to RESTfm will need
 * this.
 */
$config['allowed_origins'] = array (
    // 'http://example.com',    // Example origin domain.
    // '*',                     // An origin of '*' (wildcard) will match
                                // all domains. WARNING: This is probably not
                                // what you want.
);
