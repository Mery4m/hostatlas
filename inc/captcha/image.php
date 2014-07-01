<?php

include 'captcha.php';

header("Content-type: image/png");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Fri, 19 Jan 1994 05:00:00 GMT");
header("Pragma: no-cache");

imagepng($captchaImage);