ZF2 File Upload Examples Module
===============================

A set of form file upload examples in a Zend Framework 2 module.

*NOTE:* Currently only compatible with the [develop ZF2 branch](https://github.com/zendframework/zf2/tree/develop).


Examples
--------

**WORK-IN-PROGRESS: Not all examples are complete**

* Using a single File element.
* Using multiple File elements in a Collection.
* Using a single File element with the HTML5 "multiple" attribute.
* Using file uploads with the Post-Redirect-Get plugin.
* Temporarily save uploaded file(s) until a form is completely valid.
* Using AJAX to upload files and displaying progress with PHP5's [Session Upload Progress](http://www.php.net/manual/en/session.upload-progress.php). **TODO**
* "Real-world" Image Gallery example. **TODO**

See the [Example Controllers](https://github.com/cgmartin/ZF2FileUploadExamples/tree/master/src/ZF2FileUploadExamples/Controller) for more details.


Installation
------------

1. Install the [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication)
2. Clone this project into your `./vendor/` directory and enable `ZF2FileUploadExamples` in your
   `application.config.php` file.
3. Create a `./data/tmpuploads` directory, and make writeable by the webserver.
4. Navigate to `/file-upload-examples` in your browser to see the list of examples.

