ZF2 File Upload Examples Module
===============================

A set of form file upload examples to test the new features in the upcoming ZF 2.1 release.

**NOTE:** These examples are only compatible with Zend Framework version **2.1** (or greater).

You can find a good primer on file uploading in the
[documentation](http://framework.zend.com/manual/2.1/en/modules/zend.form.file-upload.html).


List of Examples
----------------

* Using a single File element.
* Using multiple File elements in a Collection.
* Using a single File element with the HTML5 "multiple" attribute.
* Temporarily save uploaded file(s) until a form is completely valid.
* Using file uploads with the Post-Redirect-Get plugin.
* Using AJAX to upload files and displaying progress with [Session Upload Progress](http://www.php.net/manual/en/session.upload-progress.php) (Requires PHP 5.4).
* Complex example using [Session Upload Progress](http://www.php.net/manual/en/session.upload-progress.php) with a partially valid form (Requires PHP 5.4).

See the [Example Controllers](https://github.com/cgmartin/ZF2FileUploadExamples/tree/master/src/ZF2FileUploadExamples/Controller) for more details.

If there is a use-case for file uploading that you'd like to see and isn't currently included here,
please create a GitHub issue.


Installation
------------

1. Install the [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication).
2. Clone this project into your `./vendor/` directory (or use composer, see below).
3. Enable `ZF2FileUploadExamples` in your `application.config.php` file.
4. Create a `./data/tmpuploads` directory, and make writeable by the webserver.
5. Download the [jQuery Form plugin](https://github.com/malsup/form) into
   `./public/js/jquery.form.js` (for the Upload Progress example).
6. Navigate to `/file-upload-examples` in your browser to see the list of examples.

You may also need to change/verify these `php.ini` settings:
```ini
file_uploads = On
post_max_size = 50M
upload_max_filesize = 50M
session.upload_progress.enabled = On
session.upload_progress.freq =  "1%"
session.upload_progress.min_freq = "1"
; Also make certain 'upload_tmp_dir' is writeable
```

###Composer###

```json
{
    "require": {
        "cgm/zf2-file-upload-examples": ">=1.0.0"
    }
}
```

