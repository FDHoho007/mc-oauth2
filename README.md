# Minecraft OAuth2
This is a small php project to provide a standardized OAuth2 gateway for authenticating with a minecraft (microsoft) account.

Authorization Endpoint: `/`

Token Endpoint: `/api/token`

Minecraft Profile Endpoint: `/api/minecraftprofile`

## Using mc-oauth2.myfdwev.de
In order to authorize users over the public MC OAuth2 Instance(`mc-oauth2.myfdwev.de`) you need to have your app registered as a service on `https://mc-oauth2.myfdwev.de/admin.php` (Requires MyFDWeb IDM account).
Everything else is just standard OAuth2 procedure.

## Self Hosting
For self hosting you need an Azure Active Directory Application. Put the credentials into `config.php` (see `config.sample.php`).

Also you might need the classes `HTTP` and `Database`. These are part of the myfdweb default library and are therefore not included in this project. Feel free to contact me if you dont feel like implementing those yourself.
