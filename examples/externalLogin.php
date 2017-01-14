<?php

require_once 'vendor/autoload.php';

use Flagrow\Flarum\Api\Client;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $client = new Client('http://example.com/api/');

    $identification = $_POST['username'];
    $password = $_POST['password'];

    $response = [];
    $invalid_credentials = false;

    try {
        // Fetch the Flarum api token
        $response = $client->getToken($identification, $password);
    } catch (GuzzleHttp\Exception\ClientException $e) {
        // Probably a 401, unauthorized.
        $invalid_credentials = true;
    }

    if(!$invalid_credentials){
        // Set the authentication token
        setcookie ('flarum_remember', $response['token']);
        echo 'you are now logged in<br>' . "\n";
        exit();
    }
} 

?>
<html>
<body>

<?php if($invalid_credentials) { echo 'Invalid credentials, please try again.<br><br>'; }?>

<form method="post">
   <p>Name: <input type="text" name="username" /></p>
   <p>Password: <input type="password" name="password" /></p>
   <input type="submit" name="submit" value="Submit" />
</form>

</body>
</html>
