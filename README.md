# php-request-emailer

A PHP server to email a copy of all incoming POST requests to a specified email address.

PHP Request Emailer takes a POST request with JSON body and simply sends an email to a specified address with that JSON body prettified.

This can be useful if you want to create a quick form that routes to your email and you don't care about the format or having to read formatted JSON on your email client to get the results of the form.
