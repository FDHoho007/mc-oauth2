<?php

require_once "engine.php";

if (isset($_GET["client_id"]) && isset($_GET["response_type"]) && isset($_GET["redirect_uri"]) && isset($_GET["scope"]) && isset($_GET["state"])) {
    if ($_GET["response_type"] == "code") {
        if ($_GET["scope"] == "identify") {
            if (Database::getLocalInstance()->query("SELECT * FROM redirect_uri WHERE Service=? AND RedirectURI=?;", $_GET["client_id"], $_GET["redirect_uri"]) != null) {
                header("Location: https://login.live.com/oauth20_authorize.srf?client_id=" . MS_CLIENT_ID . "&response_type=code&redirect_uri=" . urlencode(MS_REDIRECT_URI) . "&scope=XboxLive.signin%20user.read%20openid%20profile%20email&state=" . urlencode(base64_encode(json_encode(["client_id" => $_GET["client_id"], "redirect_uri" => $_GET["redirect_uri"], "state" => $_GET["state"]]))));
                exit;
            } else
                echo("Invalid service or redirect uri.");
        } else
            echo("Invalid scope.");
    } else
        echo("Invalid response type.");
} else {
    if (isset($_GET["code"]) && isset($_GET["state"])) {
        ?>

        <!doctype html>
        <html lang="de">

        <head>

            <meta charset="utf-8">
            <title>Minecraft OAuth2</title>
            <meta name="author" content="Fabian Dietrich">

            <style>

                @font-face {
                    font-family: Whitney;
                    font-style: normal;
                    font-weight: 300;
                    src: url(/assets/aa547e7d321c25791de2252ee2294220.woff2) format("woff2")
                }

                @font-face {
                    font-family: Whitney;
                    font-style: italic;
                    font-weight: 300;
                    src: url(/assets/6dab543d77316e020f4a6a951e69e4c3.woff2) format("woff2")
                }

                @font-face {
                    font-family: Whitney;
                    font-style: normal;
                    font-weight: 400;
                    src: url(/assets/b22a047b24393561750b742d8d88a48a.woff2) format("woff2")
                }

                @font-face {
                    font-family: Whitney;
                    font-style: italic;
                    font-weight: 400;
                    src: url(/assets/f343c550053248d50107a379a1f67ff7.woff2) format("woff2")
                }

                @font-face {
                    font-family: Whitney;
                    font-style: normal;
                    font-weight: 500;
                    src: url(/assets/b63701648c7e5a9d6ad67a0866cf9ecd.woff2) format("woff2")
                }

                @font-face {
                    font-family: Whitney;
                    font-style: italic;
                    font-weight: 500;
                    src: url(/assets/161543c19f87e7bc8126044be2b5f50f.woff2) format("woff2")
                }

                @font-face {
                    font-family: Whitney;
                    font-style: normal;
                    font-weight: 600;
                    src: url(/assets/10bf925aa3b5eea72cffce5ab37d6c49.woff2) format("woff2")
                }

                @font-face {
                    font-family: Whitney;
                    font-style: italic;
                    font-weight: 600;
                    src: url(/assets/6a4f76f9849935bd57822e9428481f1c.woff2) format("woff2")
                }

                @font-face {
                    font-family: Whitney;
                    font-style: normal;
                    font-weight: 700;
                    src: url(/assets/3d0099ecfaf7718dad3fb6cb3c0ee650.woff2) format("woff2")
                }

                @font-face {
                    font-family: Whitney;
                    font-style: italic;
                    font-weight: 700;
                    src: url(/assets/4904116ba8b56f50018a30c364d52b87.woff2) format("woff2")
                }

                * {
                    box-sizing: border-box;
                }

                body {
                    font-family: Whitney, "Helvetica Neue", Helvetica, Arial, sans-serif;
                    background: #202225;
                    color: #898d92;
                }

                #box {
                    min-width: 280px;
                    max-width: 400px;
                    min-height: 355px;
                    margin: 200px auto auto;
                    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.24);
                    background: #18191c;
                }

                #box .content {
                    padding: 0 16px;
                    font-size: 16px;
                    line-height: 20px;
                    font-weight: 500;
                    color: #b9bbbe;
                }

                #box .content .block {
                    padding: 24px 0;
                }

                #box .content .block.border-bottom {
                    border-bottom: 1px solid rgba(79, 84, 92, 0.48);
                }

                #app-display-name {
                    font-size: 20px;
                    line-height: 24px;
                    font-weight: 700;
                    color: #fff;
                }

                #current-user {
                    color: #fff;
                }

                #box .line {
                    margin: 8px 0;
                }

                #box .content img {
                    display: block;
                    width: 80px;
                    height: 80px;
                    margin: auto;
                }

                #box h3 {
                    margin: 0 0 16px;
                    padding: 0;
                    font-weight: 700;
                    text-transform: uppercase;
                    color: #b9bbbe;
                    font-size: 12px;
                    line-height: 16px;
                }

                #box .scope {
                    display: flex;
                }

                #box .scope-icon {
                    color: #fff;
                    margin-right: 12px;
                    width: 24px;
                    height: 24px;
                    padding: 2px;
                    border-radius: 50%;
                    background: hsl(214, 9.9%, 50.4%);;
                }

                #box .scope-icon.green {
                    background: hsl(139, 47.3%, 43.9%);
                }

                #box .scope-icon svg {
                    width: 20px;
                    height: 20px;
                }

                #box .small-line {
                    display: flex;
                    font-weight: 500;
                    font-size: 12px;
                    line-height: 16px;
                }

                #box .small-line svg {
                    margin-right: 8px;
                    width: 16px;
                    height: 16px;
                }

                #box .footer {
                    background: #2f3136;
                    padding: 16px;
                    border-radius: 0 0 5px 5px;
                }

                #box button {
                    color: #fff;
                    background: transparent;
                    border: none;
                    outline: none;
                    border-radius: 3px;
                    font-size: 14px;
                    font-weight: 500;
                    line-height: 16px;
                    padding: 2px 16px;
                    cursor: pointer;
                    width: auto;
                    height: 38px;
                    min-width: 96px;
                    min-height: 38px;
                }

                #box button:hover {
                    text-decoration: underline;
                }

                #box button.blue {
                    background: hsl(235, 85.6%, 64.7%);
                    float: right;
                }

                #box button.blue:hover {
                    background: hsl(235, 51.4%, 52.4%);;
                    text-decoration: none;
                }

                #box a {
                    display: block;
                    color: white;
                    text-align: center;
                }

            </style>

        </head>

        <body>

        <?php
        $state = json_decode(base64_decode($_GET["state"]), true);
        $service = Database::getLocalInstance()->query("SELECT * FROM service WHERE ID=?;", $state["client_id"]);
        $token = json_decode(HTTP::post("https://login.live.com/oauth20_token.srf", "client_id=" . MS_CLIENT_ID . "&client_secret=" . MS_CLIENT_SECRET . "&code=" . $_GET["code"] . "&grant_type=authorization_code&redirect_uri=" . urlencode(MS_REDIRECT_URI), ["Content-Type: application/x-www-form-urlencoded"]), true);
        if (isset($token["access_token"])) {
            $xbl = json_decode(HTTP::post("https://user.auth.xboxlive.com/user/authenticate", json_encode(["Properties" => ["AuthMethod" => "RPS", "SiteName" => "user.auth.xboxlive.com", "RpsTicket" => "d=" . $token["access_token"]], "RelyingParty" => "http://auth.xboxlive.com", "TokenType" => "JWT"]), ["Content-Type: application/json", "Accept: application/json"]), true);
            $xsts = json_decode(HTTP::post("https://xsts.auth.xboxlive.com/xsts/authorize", json_encode(["Properties" => ["SandboxId" => "RETAIL", "UserTokens" => [$xbl["Token"]]], "RelyingParty" => "rp://api.minecraftservices.com/", "TokenType" => "JWT"]), ["Content-Type: application/json", "Accept: application/json"]), true);
            $mc_token = json_decode(HTTP::post("https://api.minecraftservices.com/authentication/login_with_xbox", json_encode(["identityToken" => "XBL3.0 x=" . $xsts["DisplayClaims"]["xui"][0]["uhs"] . ";" . $xsts["Token"]]), ["Content-Type: application/json", "Accept: application/json"]), true);
            $mc_token["email"] = json_decode(base64_decode(explode(".", $token["id_token"])[1]), true)["email"];
            $mc_token = openssl_encrypt(json_encode($mc_token), "aes-256-cbc", hash("sha256", AES_KEY, true), 0, AES_IV);
            $code = bin2hex(openssl_random_pseudo_bytes(32));
            Database::getLocalInstance()->exec("INSERT INTO authorization_code VALUES (?, ?, ?, ?);", $code, $state["client_id"], $mc_token, time() + 60 * 10);
            ?>

            <div id="box">
                <div class="content">
                    <div class="block border-bottom" style="text-align: center;">
                        <img src="/assets/minecraft.png" alt="Minecraft">
                        <div class="line">Eine externe Anwendung</div>
                        <div id="app-display-name"><?php echo($service["DisplayName"]); ?></div>
                        <div class="line">möchte auf deinen Minecraft Account zugreifen</div>
                        <div class="current-user-line">Angemeldet als <span id="current-user">FDHoho007</span></div>
                    </div>
                    <div class="block border-bottom">
                        <h3>Dies wird dem Entwickler von <?php echo($service["DisplayName"]); ?> folgendes
                            erlauben:</h3>
                        <div class="scope">
                            <div class="scope-icon green">
                                <svg class="icon-hDztL8" aria-hidden="false" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                                          d="M8.99991 16.17L4.82991 12L3.40991 13.41L8.99991 19L20.9999 7.00003L19.5899 5.59003L8.99991 16.17Z"></path>
                                </svg>
                            </div>
                            <div class="scope-text">Zugriff auf deinen Spielernamen, eindeutige ID und Skin</div>
                        </div>
                    </div>
                    <div class="block">
                        <div class="small-line">
                            <svg class="entryIcon-2bcrKV" aria-hidden="false" width="24" height="24"
                                 viewBox="0 0 24 24">
                                <g fill="none" fill-rule="evenodd">
                                    <path fill="currentColor"
                                          d="M10.59 13.41c.41.39.41 1.03 0 1.42-.39.39-1.03.39-1.42 0a5.003 5.003 0 0 1 0-7.07l3.54-3.54a5.003 5.003 0 0 1 7.07 0 5.003 5.003 0 0 1 0 7.07l-1.49 1.49c.01-.82-.12-1.64-.4-2.42l.47-.48a2.982 2.982 0 0 0 0-4.24 2.982 2.982 0 0 0-4.24 0l-3.53 3.53a2.982 2.982 0 0 0 0 4.24zm2.82-4.24c.39-.39 1.03-.39 1.42 0a5.003 5.003 0 0 1 0 7.07l-3.54 3.54a5.003 5.003 0 0 1-7.07 0 5.003 5.003 0 0 1 0-7.07l1.49-1.49c-.01.82.12 1.64.4 2.43l-.47.47a2.982 2.982 0 0 0 0 4.24 2.982 2.982 0 0 0 4.24 0l3.53-3.53a2.982 2.982 0 0 0 0-4.24.973.973 0 0 1 0-1.42z"></path>
                                    <rect width="24" height="24"></rect>
                                </g>
                            </svg>
                            <div>Nach der Autorisierung wirst du außerhalb von Discord weitergeleitet
                                zu: <?php echo($state["redirect_uri"]); ?></div>
                        </div>
                    </div>
                </div>
                <div class="footer">
                    <button onclick="location.href = '<?php echo($state["redirect_uri"] . (str_contains($state["redirect_uri"], "?") ? "&" : "?") . "error=Autorisierung%20abgelehnt&state=" . $state["state"]); ?>';">
                        Abbrechen
                    </button>
                    <button class="blue"
                            onclick="location.href = '<?php echo($state["redirect_uri"] . (str_contains($state["redirect_uri"], "?") ? "&" : "?") . "code=$code&state=" . $state["state"]); ?>';">
                        Autorisieren
                    </button>
                </div>
            </div>

        <?php } else { ?>

            <div id="box">
                <div class="content">
                    <div class="block border-bottom" style="text-align: center;">
                        <img src="/assets/minecraft.png" alt="Minecraft">
                        <div class="line">Eine externe Anwendung</div>
                        <div id="app-display-name"><?php echo($service["DisplayName"]); ?></div>
                        <div class="line">möchte auf deinen Minecraft Account zugreifen</div>
                    </div>
                    <div class="block">
                        <div class="scope">
                            <div class="scope-icon">
                                <svg class="icon-hDztL8" aria-hidden="false" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                          d="M18.4 4L12 10.4L5.6 4L4 5.6L10.4 12L4 18.4L5.6 20L12 13.6L18.4 20L20 18.4L13.6 12L20 5.6L18.4 4Z"></path>
                                </svg>
                            </div>
                            <div class="scope-text">
                                Wir konnten nicht auf dein Minecraft Account zugreifen. Bitte versuche es später erneut.
                            </div>
                        </div>
                    </div>
                    <a href="<?php echo($state["redirect_uri"]); ?>">Zurück zu <?php echo($service["DisplayName"]); ?></a>
                </div>
            </div>

        <?php } ?>

        </body>

        </html>

    <?php } else {
        header("Location: https://github.com/FDHoho007/mc-oauth2");
    }
} ?>


