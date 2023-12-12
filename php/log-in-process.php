<?php

include_once "UserDataCheck.php";

// declare constants for input data
$inputData = json_decode(file_get_contents("php://input"), true);
define("passedLogin", $inputData["login"]);
define("passedPassword", $inputData["password"]);


// validate input data

// validate input login
if (strlen(passedLogin) < 4) {
    die("Login must be at least 4 characters long");
}
if (strlen(passedLogin) > 20) {
    die("Login can be max 20 characters long");
}
// validate input password
if (strlen(passedPassword) < 8) {
    die("Password must be at least 8 characters long");
}
if (strlen(passedPassword) > 20) {
    die("Password can be max 40 characters long");
}


// hash the password
$hashedPassword = password_hash(passedPassword, PASSWORD_DEFAULT);

// save new user's data to the JSON file

// get data from the JSON file and decode it
$usersJsonData = file_get_contents("../data/users.json");
$usersList = json_decode($usersJsonData);

// define variable to store searching result
$result = new UserDataCheck(false, false);
// check if fetched JSON data already contain the login
foreach ($usersList as $user) {
    // return TRUE if login already exists
    // if login exists in the JSON file, then check if the passwords match
    if ($user->login == passedLogin) {
        $result->loginExists = true;
        // if the passwords match, save TRUE to the $result variable and break the cycle
        if (password_verify(passedPassword, $user->password)) {
            $result->passwordMatches = true;
        }
        break;
    }
}
// return result (TRUE if login was founded in the JSON file and the passwords match, or FALSE if not)
echo json_encode($result);
