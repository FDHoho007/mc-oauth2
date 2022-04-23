<?php

require_once "config.php";
require_once "HTTP.php";
require_once "Database.php";

Database::getLocalInstance()->exec("CREATE TABLE IF NOT EXISTS service (ID VARCHAR(36) PRIMARY KEY NOT NULL, Owner VARCHAR(36) NOT NULL, DisplayName TEXT NOT NULL, Secret TEXT NOT NULL);");
Database::getLocalInstance()->exec("CREATE TABLE IF NOT EXISTS redirect_uri (Service VARCHAR(36) NOT NULL, FOREIGN KEY (Service) REFERENCES service (ID) ON UPDATE CASCADE ON DELETE CASCADE, RedirectURI VARCHAR(255) NOT NULL, PRIMARY KEY (Service, RedirectURI));");
Database::getLocalInstance()->exec("CREATE TABLE IF NOT EXISTS authorization_code (Code VARCHAR(64) NOT NULL PRIMARY KEY, Service VARCHAR(36) NOT NULL, FOREIGN KEY (Service) REFERENCES service (ID) ON UPDATE CASCADE ON DELETE CASCADE, Token TEXT NOT NULL, ValidUntil BIGINT NOT NULL);");

Database::getLocalInstance()->exec("DELETE FROM authorization_code WHERE ValidUntil < ?;", time());
