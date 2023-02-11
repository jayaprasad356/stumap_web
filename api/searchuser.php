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

if (!empty($_POST['search'])) {
    $search = $db->escapeString($_POST['search']);
    $sql = "SELECT * FROM `users` WHERE name like '%" . $search . "%' OR mobile like '%" . $search . "%'";
} else {
    $sql = "SELECT * FROM `users`";
}
$db->sql($sql);
$res = $db->getResult();
$num = $db->numRows($res);
if ($num >= 1) {
    foreach ($res as $row) {
        $temp['id'] = $row['id'];
        $temp['name'] = $row['name'];
        $temp['email'] = $row['email'];
        $temp['mobile'] = $row['mobile'];
        $temp['password'] = $row['password'];
        $temp['latitude'] = $row['latitude'];
        $temp['longtitude'] = $row['longtitude'];
        $rows[] = $temp;
        
    }
    $response['success'] = true;
    $response['message'] = "Users listed Successfully";
    $response['data'] = $rows;
    print_r(json_encode($response));

}else{
    $response['success'] = false;
    $response['message'] = "Users Not Found";
    print_r(json_encode($response));

}

?>