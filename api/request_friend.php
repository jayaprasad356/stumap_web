<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
header("Expires: 0");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include_once('../includes/crud.php');
$db = new Database();
$db->connect();


if (empty($_POST['user_id'])) {
    $response['success'] = false;
    $response['message'] = "User Id is Empty";
    print_r(json_encode($response));
    return false;
}
if (empty($_POST['friend_id'])) {
    $response['success'] = false;
    $response['message'] = "Friend Id is Empty";
    print_r(json_encode($response));
    return false;
}
$user_id = $db->escapeString($_POST['user_id']);
$friend_id = $db->escapeString($_POST['friend_id']);
$status = $db->escapeString($_POST['status']);


$sql = "SELECT * FROM friends WHERE user_id = '$user_id' AND friend_id='$friend_id'";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    $response['success'] = false;
    $response['message'] ="Friend Request Already Sent";
    print_r(json_encode($response));
    return false;
}
else{
   
    $sql = "INSERT INTO friends (`user_id`,`friend_id`,`status`)VALUES('$user_id','$friend_id','$status')";
    $db->sql($sql);
    $res = $db->getResult(); 
    $response['success'] = true;
    $response['message'] = "Friend Request Sent Successfully";
    print_r(json_encode($response));

}

?>