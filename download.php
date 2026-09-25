<?php
require __DIR__.'/store-config.php';
$session=$_GET['session_id']??''; if(!$session||str_contains(STRIPE_SECRET_KEY,'REPLACE_ME')){http_response_code(403);exit('Download unavailable.');}
$ch=curl_init('https://api.stripe.com/v1/checkout/sessions/'.rawurlencode($session));curl_setopt_array($ch,[CURLOPT_RETURNTRANSFER=>true,CURLOPT_USERPWD=>STRIPE_SECRET_KEY.':',CURLOPT_HTTPAUTH=>CURLAUTH_BASIC]);$raw=curl_exec($ch);curl_close($ch);$s=json_decode($raw,true);
$id=$s['metadata']['product_id']??''; if(($s['payment_status']??'')!=='paid'||!isset(PRODUCTS[$id])){http_response_code(403);exit('Payment not verified.');}
$file=__DIR__.'/'.PRODUCTS[$id]['file'];if(!is_file($file)){http_response_code(404);exit('Digital file has not been uploaded yet.');}
header('Content-Type: application/octet-stream');header('Content-Disposition: attachment; filename="'.basename($file).'"');header('Content-Length: '.filesize($file));readfile($file);
