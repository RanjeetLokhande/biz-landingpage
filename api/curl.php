<?php
// Enable error reporting (for debugging during development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check which form is submitted
$form_id = $_POST['form_id'] ?? '';

if ($form_id === 'form1') {
    // Form 1 logic
    $name = $_POST["user_name"] ?? '';
    $email = $_POST["user_email"] ?? '';
    $phone = $_POST["user_phone"] ?? '';
    $company = $_POST["company_name"] ?? '';
    $no_of_users = $_POST["no_of_users"] ?? '';

    $address = $company;
    $requirement = "No of Users Required: " . $no_of_users;

} elseif ($form_id === 'form2') {
    // Form 2 logic
    $name = $_POST["name"] ?? '';
    $email = $_POST["email"] ?? '';
    $phone = $_POST["user_phone"] ?? '';
    $company = $_POST["company_name"] ?? '';
    $no_of_users = $_POST["no_of_users"] ?? '';
    $message = $_POST["message"] ?? '';

    $address = $company;
    $requirement = "No of Users Required: $no_of_users. Message: $message";

} else {
    die("Unknown form submitted.");
}

// URL encode parameters
$name = urlencode($name);
$email = urlencode($email);
$phone = urlencode($phone);
$address = urlencode($address);
$requirement = urlencode($requirement);

// External API URL
$url = "https://ltpl.bizpluscrm.com/api/Leads/Website?user=Website&pass=WebsiteAPI&name=$name&phone=$phone&email=$email&address=$address&requirement=$requirement";

// cURL setup
$curl = curl_init();
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'Content-Length: 0'
    )
));

// Execute request
$response = curl_exec($curl);

// Handle errors
if ($response === false) {
    $error = curl_error($curl);
    curl_close($curl);
    echo "<!DOCTYPE html>
    <html><head><meta charset='UTF-8'><title>Error</title></head>
    <body>
    <script>
        alert('❌ Error submitting form: " . addslashes($error) . "');
        window.top.location.href = '../popup-form.html?success=0';
    </script>
    </body></html>";
    exit;
}

curl_close($curl);

// Success — redirect to thank you page outside iframe
echo "<!DOCTYPE html>
<html><head><meta charset='UTF-8'><title>Redirecting...</title></head>
<body>
<script>
    window.top.location.href = '../api/thankyou.html';
</script>
</body></html>";
exit;
?>
