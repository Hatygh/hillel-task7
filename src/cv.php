<?php
//
//require_once 'validation.php';
//
//$icons = [
//    'email' => '<i class="fas fa-envelope-square"></i>',
//    'skype' => '<i class="fab fa-skype"></i>',
//    'phone' => '<i class="fas fa-phone"></i>',
//    'address' => '<i class="fas fa-map-marker-alt"></i>'
//];
//
//$errors = [
//    'name' => array(),
//    'image' => array(),
//    'email' => array(),
//    'phone' => array(),
//    'address' => array(),
//    'date' => array()
//];
//
//if (!empty($_POST)) {
//
//    if (not_empty_validator($_POST['firstname']))
//        $firstname = $_POST['firstname'];
//    else
//        $errors['name'] = 'Firstname required';
//
//    $lastname = $_POST['lastname'];
//    $image = $_POST['image'];
//    $vacancy = $_POST['vacancy'];
//    $resume = $_POST['resume'];
//
//    $contacts = $_POST['contacts'];
//
//    $address = $_POST['address'];
//
//    $coordinates = geocode($address);
//    $address['latitude'] = $coordinates['latitude'];
//    $address['longitude'] = $coordinates['longitude'];
//
////    $experiences = $_POST['experiences'];
////    foreach ($experiences as &$experience) {
////        $experience['start_date'] = strtotime($experience['start_date']);
////        $experience['end_date'] = strtotime($experience['end_date']);
////    }
////    unset($experience);
////
////    $skills = $_POST['skills'];
////
////    $sertificates = $_POST['sertificates'];
////    foreach ($sertificates as &$sertificate) {
////        $sertificate['start_date'] = strtotime($sertificate['start_date']);
////        $sertificate['end_date'] = strtotime($sertificate['end_date']);
////    }
////    unset($sertificate);
////
////    $education = $_POST['education'];
////    $education['start_date'] = strtotime($education['start_date']);
////    $education['end_date'] = strtotime($education['end_date']);
////
////    $languages = $_POST['languages'];
////
////    $interests = $_POST['interests'];
//
//
////    echo "<pre>";
////    var_dump($_POST);
////    echo "</pre>";
//
//    //include 'view_cv.php';
//
//    $count = null;
//    foreach ($errors as $error) {
//        $count = $count + count($error);
//    }
//
//    if ($count == 0)
//        echo 'happy';
//        //include ('view_cv.php');
//    else
//        header('location: index.php');
//
//}
//
//else {
//    echo 'Something gone wrong';
//}
//
//    echo "<pre>";
//    var_dump($errors);
//    echo "</pre>";
