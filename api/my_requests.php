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
    $response['message'] = "User ID is empty";
    print_r(json_encode($response));
    return false;
}

$user_id = $db->escapeString($_POST['user_id']);
$status = $db->escapeString($_POST['status']);

$sql = "SELECT users.*
        FROM friends
        INNER JOIN users ON users.id = friends.user_id
        WHERE friends.friend_id = '$user_id' AND friends.status = 0";
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);

if ($num >= 1) {
    $sql = "UPDATE friends SET status='$status' WHERE friends.friend_id = '$user_id'";
    $db->sql($sql);
    $response['success'] = true;
    $response['message'] ="Requests listed successfully";
    $response['total_requests'] = $num;
    $response['data'] = $res;
    print_r(json_encode($response));
    return false;
} else {
    $response['success'] = false;
    $response['message'] = "No Requests found";
    print_r(json_encode($response));
}
?>
