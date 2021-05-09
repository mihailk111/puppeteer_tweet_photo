<?php

$http_request = <<< HEADERS
GET /home HTTP/1.1
Host: twitter.com
User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:88.0) Gecko/20100101 Firefox/88.0
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8
Accept-Language: en-US,en;q=0.5
Accept-Encoding: gzip, deflate, brk
Connection: keep-alive
HEADERS;
$http_request_ending = "\r\n\r\n";

// dd($http_request);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_connect($socket, gethostbyname("twitter.com"), 80);

$request_data = $http_request . $http_request_ending;

echo "Sending $request_data \n";

socket_write($socket,$request_data);

$data = socket_read($socket, 1024);
echo "Recived => " . $data . "\n";

$response_array = explode("\n", $data);
$neededCookies =[];
array_push($neededCookies, $response_array[4], $response_array[5]);

// print_r($neededCookies);

$finalCookie = "Cookie: ";

foreach ($neededCookies as $cookie) {
    preg_match("#set-cookie: (.*?);#", $cookie, $matches);
    $finalCookie .= $matches[1] . "; " ;
}

$finalCookie = trim( $finalCookie );

// dd($finalCookie);
$request_data = $http_request . "\r\n". $finalCookie . $http_request_ending;

// $test_url = "https://webhook.site/177f1e33-4483-41d9-a5a5-eddde256ad77";
$url = "https://twitter.com/home";

$requestWithAddedCookies = file_get_contents($url,
                                             context: stream_context_create(["http" => [
                                                 'header' => $finalCookie
                                             ]]));

echo "Recived => $requestWithAddedCookies \n";

file_put_contents("data.html", $requestWithAddedCookies);

$pattern = "/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i";
preg_match_all($pattern,$requestWithAddedCookies, $matched_urls);

$matched_urls = array_filter($matched_urls[0], function ($elem){
    return str_ends_with($elem, ".js") ;
});

print_r($matched_urls);


foreach ($matched_urls as $key => $url) {
    file_put_contents("$key.js",file_get_contents($url));
}

// echo "Sending => $request_data \n";

// socket_write($socket, $request_data);
// $data = socket_read($socket, 1024);

// echo "Recived => " . $data . "\n";


// echo $response_array[4] . "\n";
// echo $response_array[5] . "\n";


// Upgrade-Insecure-Requests: 1

// $data = "";
// $secondsWithoutData = 0;

// while($secondsWithoutData < 5)
// {
//     $data = socket_read($socket, 1024);
//     echo $data . "\n";
//     if (!$data) {
//         $secondsWithoutData ++;
//     }
//     else
//     {
//         $secondsWithoutData = 0;
//     }
//     sleep(1);
// }




function dd($data)
{
    var_dump($data);
    die;
}