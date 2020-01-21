<?php
$config=array(
    'DB_HOST'=>'localhost',
    'DB_USERNAME'=>'root',
    'DB_PASSWORD'=>'',
    'DB_DATABASE'=>'login-test'
);
?>

<html> 

CREATE TABLE `users` ( 
  `id` INT NOT NULL AUTO_INCREMENT ,
  `email` VARCHAR(255) NOT NULL ,
  `passwort` VARCHAR(255) NOT NULL ,
  `vorname` VARCHAR(255) NOT NULL DEFAULT '' ,
  `nachname` VARCHAR(255) NOT NULL DEFAULT '' ,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`), UNIQUE (`email`)
) ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

</html>