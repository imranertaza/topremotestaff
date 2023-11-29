<?php


function checkEmailValid($url){
    // Validate the URL format first
    if (!filter_var($url, FILTER_VALIDATE_URL)) {
        return 0;
    } else {
        // Initialize cURL session
        $ch = curl_init($url);

        // Set options
        curl_setopt($ch, CURLOPT_NOBODY, true); // we don't need body
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the result

        // Execute cURL
        curl_exec($ch);

        // Check HTTP response code
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        // Close cURL session
        curl_close($ch);

        // 200-299 status code indicates that the URL exists
        if ($statusCode >= 200 && $statusCode < 300) {
            return 1;
        } else {
            return 2;
        }
    }
}

?>