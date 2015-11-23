<?php
/** Signout and redirect user to homepage
 *
 */	
session_destroy();
@header('Location: '.Routes::$base.'');
