<?php 
if(session_id() == '' || !isset($_SESSION)){session_start();}
require_once('Nikki_fns.php');
$title = "Nikki Register";
$header = "Register";
$description = "Landing Page Description";

do_html_header($title, $header, $description);

?>
<body>
<div class="credentialInformation">
    <form method="post" action="registration_verification.php">
        <h1>Register</h1>
        <label class="credentialLabel">Username</label>
        <input class="credentialInput" type="text" id="username" name="username" />

        <label class="credentialLabel">First Name</label>
        <input class="credentialInput" type="text" id="first_name" name="first_name" />

        <label class="credentialLabel">Last Name</label>
        <input class="credentialInput" type="text" id="last_name" name="last_name" />

        <label class="credentialLabel">Date of Birth</label>
        <input class="credentialInput" type="date" id="date_of_birth" name="date_of_birth" value="01-22-1901" min="01-22-1901" max="2018-12-31" />

        <label class="credentialLabel">Email</label>
        <input class="credentialInput" type="text" id="email" name="email" />

        <label class="credentialLabel">Phone Number</label>
        <input class="credentialInput" type="text" id="phone_number" name="phone_number" />

        <label class="credentialLabel">Home Address</label>
        <input class="credentialInput" type="text" id="home_address" name="home_address" />

        <label class="credentialLabel">Password</label>
        <input class="credentialInput" type="password" id="password" name="password" />

        <label class="credentialLabel">Confirm Password</label>
        <input class="credentialInput" type="password" id="confirm_password" name="confirm_password" />

        <input class="credentialButton" type="submit" name="register" value="Register">
    </form>
    <form action="login_page.html" method="post">
        <input class="credentialButton" type="submit" name="login" value="Login">
    </form>
</div>
</body>

</html>