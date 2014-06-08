<?php


define("DB_URL", "localhost");
define("DB", "nudb");
define("DB_USERNAME","root");
define("DB_PASS", "sam123");
define("DEBUG", 1);

//errors
define("INVALID_LOGIN",100);
define("LOGIN_SUCCESS", 101);
define("INVALID_USER",103);
define("VALID_USER", 104);
define("NO_TOPICS_FOUND", 105);
define("INVALID_TOPIC", 106);
define("NO_COMMENTS", 107);

//user roles
define("ADMIN",1);
define("EDITOR", 2);
define("REPORTER", 3);
define("READER", 4);

//content types
define("TEXT", 1);
define("IMAGE", 2);

?>
