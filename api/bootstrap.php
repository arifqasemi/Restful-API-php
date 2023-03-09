<?php

require dirname(__DIR__) . "/vendor/autoload.php";
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");
header("Content-type: application/json; charset=UTF-8");
