<?php
$form_id = $_POST['form_id'] ?? '';

if ($form_id === 'form1') {
    // Existing form logic
    $name = $_POST["user_name"] ?? '';
    $email = $_POST["user_email"] ?? '';
    $phone = $_POST["user_phone"] ?? '';
    $company = $_POST["company_name"] ?? '';
    $no_of_users = $_POST["no_of_users"] ?? '';

    $address = $company;
    $requirement = "No of Users Required: " . $no_of_users;

} elseif ($form_id === 'form2') {
    // New form logic
    $name = $_POST["name"] ?? '';
    $email = $_POST["email"] ?? '';
    $phone = $_POST["user_phone"] ?? '';
    $company = $_POST["company_name"] ?? '';
    $no_of_users = $_POST["no_of_users"] ?? '';
    $message = $_POST["message"] ?? '';

    $address = $company;
    $requirement = "No of Users Required: " . $no_of_users . ". Message: " . $message;

} else {
    // Unknown form
    die("Unknown form submitted.");
}

// URL encode parameters
$name = urlencode($name);
$email = urlencode($email);
$phone = urlencode($phone);
$address = urlencode($address);
$requirement = urlencode($requirement);

// API URL
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

// Execute
$response = curl_exec($curl);

// Error check
if ($response === false) {
    $error = curl_error($curl);
    die("Error submitting form: " . $error);
}

curl_close($curl);

// Return success message
echo "✅ Thank you! Your demo request was submitted successfully. We'll get back to you shortly.";
?>