<?php

require_once "engine.php";

header("Content-Type: application/json");
if ($_SERVER["REQUEST_URI"] == "/api/token") {
    if (isset($_POST["client_id"]) && isset($_POST["client_secret"]) && isset($_POST["grant_type"]) && $_POST["grant_type"] == "authorization_code" && isset($_POST["code"]) && isset($_POST["redirect_uri"])) {
        $service = Database::getLocalInstance()->query("SELECT * FROM service WHERE ID=?;", $_POST["client_id"]);
        if ($service != null && $service["Secret"] == $_POST["client_secret"]) {
            $token = Database::getLocalInstance()->query("SELECT * FROM authorization_code WHERE Code=?;", $_POST["code"]);
            if ($token != null) {
                Database::getLocalInstance()->exec("DELETE FROM authorization_code WHERE Code=?;", $_POST["code"]);
                echo(json_encode(["access_token" => $token["Token"], "token_type" => "Bearer", "expires_in" => 86400, "scope" => "identify"]));
            }
            else
                header("HTTP/1.1 403 Forbidden");
        } else
            header("HTTP/1.1 403 Forbidden");
    } else
        header("HTTP/1.1 400 Bad Request");
} else if ($_SERVER["REQUEST_URI"] == "/api/minecraftprofile") {
    $headers = array_change_key_case(getallheaders());
    if (isset($headers["authorization"]) && str_starts_with($headers["authorization"], "Bearer ")) {
        $token = json_decode(openssl_decrypt(substr($headers["authorization"], 7), "aes-256-cbc", hash("sha256", AES_KEY, true), 0, AES_IV), true);
        $profile = json_decode(HTTP::get("https://api.minecraftservices.com/minecraft/profile", ["Authorization: Bearer " . $token["access_token"]]), true);
        $profile["id"] = substr($profile["id"], 0, 8) . "-" . substr($profile["id"], 0, 4) . "-" . substr($profile["id"], 0, 4) . "-" . substr($profile["id"], 0, 4) . "-" . substr($profile["id"], 0, 12);
        $profile["email"] = $token["email"];
        echo(json_encode($profile));
    } else
        header("HTTP/1.1 401 Unauthorized");
}
