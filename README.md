PHP-Simple-Framework
====================

 - Version 0.1
 - Author: Neil McGibbon
 - https://github.com/neilmcgibbon/php-simple-framework


Installation instructions:
--------------------------

i)   Download zip or clone using git.
      - zip:
         1: get file: https://github.com/neilmcgibbon/php-simple-framework/archive/master.zip
         2: unzip contents

      - git:
         1: git clone https://github.com/neilmcgibbon/php-simple-framework
         2: If you aren't planning on further updates, or forking the repo, descend into folder php-simple-framework and remove the .git hidden folder.

ii)  Rename folder php-simple-framework to the name of your webroot (html, root, etc), or copy all the contents of php-simple-framework to your webroot (including the .htaccess file!
iii) Enter your webroot and amend the config.php file as appropriate
iv)  Give the webserver write permissions on the cache directory (ROOT_PATH/cache) : e.g. chmod 0777 cache

And you should be good to go!


Config options:
---------------

ROOT_PATH/config.php can be used to set some global confiuration options for the app:

 - The absolute webroot (eg /var/www/my_web_site/html) if you don't wish to use the server default ($_SERVER['DOCUMENT_ROOT']).
 - If you are using a database, set the PHPSFW_DB_TYPE constant to mongo or mysqli, if you are using either of these
 - If you have set a database type, then set the database connection parameters below
 - If you are developing the site, set PHPSFW_DEBUG_MODE to true, which will give you more helpful error messages.  Setting to false will mean that
   if controllers, methods or views are not found/set, the user will just see the contents of app/view/error/page_not_found.tpl.php


Usage:
------

When the webserver receives a request, the request is routed to app/engine/router.php.  This in turn creates a Router object which assigns a relevant controller (and method if 
relevant).  As an example we will create the controller, methods and view for the following URL (given a domain of example.com):  

  http://example.com/foo/bar-none

Here the controller is foo, the method is bar-none, and the view is also bar-none.  The directory/file locations are:

  /app/controller/foo.class.php
  /app/view/foo/bar-none.tpl.php


The controller should use the following convention and extending the declaration:

  <?php
  
  class Controller_Foo extends PHPSFW_Controller {
    
    // Default method on any controller is the tradition "index" method.
    public function __index() {
      
      $this->view();
    
    }
  }
  
  ?>

In addition, the bar-none method needs to be introduced to the controller.  Controller regular method names can be anything you like, but if they are a method from the URL,
for example "bar-none" in the URL, then they are rewritten in camel case and prepended with a double undescore, as in the __index() function above.  So the bar-none method would look like this:

  <?php

  ...

  public function __barNone() {

   $this->view();
  
  }
  
  ...
  
  ?>

The controller method is where all logic and processing happens, before passing the processed data (if any) to the view.  For example, our bar-none method provides the view with today's date in
the format "Monday, 15th June 2014".  Data is passed to the view in the view_data[] array:

  <?php
  
  ...

  public function __barNone() {

    $date = $this->getFormattedDate();

    $this->view_data['nice_date'] = $date;

    $this->view();

  }

  private function getFormattedDate() {

    return date('l, jS F Y');

  }

  ...

  ?>

The view can then display any data passed to it via a variable called $data.  So the view (app/view/foo/bar-none.tpl.php) may look like this:

  <div>

    Today's date is <span> <?php echo $data['nice_date']; ?> </span>

  </div>







