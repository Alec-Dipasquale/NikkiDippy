<?php

if(session_id() == '' || !isset($_SESSION)){
    session_start();
}
require_once('Nikki_fns.php');
$title = "Nikki Log In";
$header = "Login";
$description = "Landing Page Description";

doHtmlHeader($title, $header, $description);

?>
<header>
    <link href="credentials.css" rel="stylesheet" type="text/css">
</header>
<body>

    <div class="credentialInformation">
        <form action="login_verification.php" method="post">
            <h1>Login</h1>
            <label class="credentialLabel" id="username">Username: </label><br/>
            <input class="credentialInput" type="text" id="username" name="username" /><br/>
            <label class="credentialLabel" id="password">Password: </label><br/>
            <input class="credentialInput" type="password" id="password" name="password" /><br/>

            <div id="loginBtn">
                <input class="credentialButton" type="submit" name="login" value="Login">            </div>
        </form>
        <form action="register.php" method="post">
            <input class="credentialButton" type="submit" name="register" value="Register">
        </form>
    </div>
</body>

</html>


<?php
doHtmlFooter();
?>