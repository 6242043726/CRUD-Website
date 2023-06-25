<?php
if (isset($_POST['submit'])) {
  // delete
  $contact = $_POST['contacts'];
  $arr = explode(",", $contact);

  $users = json_decode(file_get_contents("contacts.json"));
  for ($i = 0; $i < count($users); $i++) {
    array_splice($users, $i);
  }

  file_put_contents("contacts.json", json_encode($users, JSON_PRETTY_PRINT));

  // create
  for ($i = 0; $i < count($arr); $i += 3) {
    $j = $i + 1;
    $k = $i + 2;
    $new_contacts = "$arr[$i],$arr[$j],$arr[$k]";

    if (filesize("contacts.json") == 0) {
      $first_record = array($new_contacts);
      $data_to_save = $first_record;
    } else {
      $old_records = json_decode(file_get_contents("contacts.json"));
      array_push($old_records, $new_contacts);
      $data_to_save = $old_records;
    }

    $encoded_data = json_encode($data_to_save, JSON_PRETTY_PRINT);

    if (!file_put_contents("contacts.json", $encoded_data, LOCK_EX)) {
      $error = "Error, Please try again";
    } else {
      $success = "Save completed!";
    }
  }
}
?>

<!-- create -->