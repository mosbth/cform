CForm a PHP class for creating, rendering and validating HTML forms.
==================================

[![Latest Stable Version](https://poser.pugx.org/leaphly/cart-bundle/version.png)](https://packagist.org/packages/mos/cform)
[![Build Status](https://travis-ci.org/mosbth/cform.png?branch=v2)](https://travis-ci.org/mosbth/cform)
[![Build Status](https://scrutinizer-ci.com/g/mosbth/cform/badges/build.png?b=v2)](https://scrutinizer-ci.com/g/mosbth/cform/build-status/v2)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/mosbth/cform/badges/quality-score.png?b=v2)](https://scrutinizer-ci.com/g/mosbth/cform/?branch=v2)
[![Code Coverage](https://scrutinizer-ci.com/g/mosbth/cform/badges/coverage.png?b=v2)](https://scrutinizer-ci.com/g/mosbth/cform/?branch=v2)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/f49294b6-7887-4424-afbd-404b6c0e6243/mini.png)](https://insight.sensiolabs.com/projects/f49294b6-7887-4424-afbd-404b6c0e6243)

Read about `CForm` here:
* http://dbwebb.se/opensource/cform 

There is an article written on CForm, in swedish. 
* http://dbwebb.se/kunskap/cform-en-php-klass-for-att-skapa-presentera-och-validera-html-formular


By Mikael Roos (me@mikaelroos.se)



License
----------------------------------

This software is free software and carries a MIT license.



Todo
----------------------------------

* Layout form elements in grid.
* Style form using LESS and CSS.
* Support all form elements.
* Make page displaying how all form elements look like in different styles.
* Support more validation rules.
* Make example on how you use the validation rules.
* Integrate/support with client side validation through js/ajax.
* Support saving partial data of form through js/ajax.
* Check that the form is valid by storing key in session and hidden field and match those.
* Unittest
* Several forms on the same page.
* Integrate with Travis & Scrutinizr.


History
----------------------------------

v1.9.8 (2016-10-18)

* Fix. Remove debug code in `CForm::value()`.


v1.9.7 (2016-10-14)

* Add testcase to validation rule `custom_test` as `webroot/test/validate-custom.php`.


v1.9.5 (2016-01-15)

* Testfile displaying how HTML5 form elements are supported, #1.
* Do not remember password in session, #17.
* Rewrote exampleprograms to use new CFormModel as baseclass.
* Introduced CFormModel as baseclass for writing forms in classes.
* Add badge for SensioLabs.
* Support several instances of cform on the same page, #23.


v1.9.4 (2015-11-18)

* Made $form->value("items") work for CFormElementCheckboxMultiple.
* Added new example for `webroot/test/multiple-checkbox.php`.
* Added example for file upload `webroot/test/test-file-upload.php`.


v1.9.3 (2015-11-06)

* Added support for enctype="multipart/form-data".
* Added formnovalidate to submit and buttons.


v1.9.2 (2015-10-27)

* Adding whitelist to phpunit code coverage to support phpunit 5.0.
* Add githook for pre commit of phpunit and phpcs. 
* Adding phpcs as test to pass build on Travis.
* Format code to pass phpcs, fix 9.
* Scrutinizer takes care of code coverage itself, not depending on Travis.
* Now passing Travis.
* Added testcases for `CHTMLElement`.
* extending check()-method with callable arguments


v1.9.1 (2014-05-05)

* Corrected #11 wrong namespace of Exception when validation rule does not exists.
* Added testcase for #11 and introduced unittesting.


v1.9.0 (2014-04-17)

* Branched to v2 to develop version 2 of CForm.
* Using namespace `Mos\HTMLForm`.
* Published as package on Packagist.
* Introduced composer.json.
* Codestandard according to PSR-1 & PSR-2.
* Adding testprogram for HTML5 form elements
* Adding a complete set of HTML5 forms.


v0.9.0 (2013-04-22)

* First tag as baseline when moving CForm from Lydia to own repository.


2012-11-26:

* Added validation rule for email address `email_address`. Rewrote `CFormElement::Validate()` to accept anonomous function as validation rule.


2012-11-14:

* Added `CFormElementCheckboxMultiple`.
* Added code example for checkbox-multiple:  
    http://dbwebb.se/kod-exempel/cform/test_checkbox_multiple.php
    http://dbwebb.se/kod-exempel/cform/test_checkbox1.php (same example but not true multiple choice)


2012-11-13:

* Added `CFormElementCheckbox` and validation rule `must_accept`.
* Added code example for checkboxes:  
    http://dbwebb.se/kod-exempel/cform/test_checkbox.php


2012-10-05: 

* Updated this readme-file and reworked the tutorial at  
  http://dbwebb.se/kunskap/anvand-lydias-formularklass-cform-for-formularhantering
* Updated the code-example at:  
  http://dbwebb.se/kod-exempel/cform/


```
 .   
..:  Copyright 2012-2014 by Mikael Roos (me@mikaelroos.se)
```
