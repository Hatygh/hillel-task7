<?php

require_once 'validation.php';

$icons = [
    'email' => '<i class="fas fa-envelope-square"></i>',
    'skype' => '<i class="fab fa-skype"></i>',
    'phone' => '<i class="fas fa-phone"></i>',
    'address' => '<i class="fas fa-map-marker-alt"></i>'
];

if (!empty($_POST)) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $image = $_POST['image'];
    $vacancy = $_POST['vacancy'];
    $resume = $_POST['resume'];

    $contacts = $_POST['contacts'];

    $address = $_POST['address'];

    $coordinates = geocode($address);
    $address['latitude'] = $coordinates['latitude'];
    $address['longitude'] = $coordinates['longitude'];

    $experiences = $_POST['experiences'];
    foreach ($experiences as &$experience) {
        $experience['start_date'] = strtotime($experience['start_date']);
        $experience['end_date'] = strtotime($experience['end_date']);
    }
    unset($experience);

    $skills = $_POST['skills'];

    $sertificates = $_POST['sertificates'];
    foreach ($sertificates as &$sertificate) {
        $sertificate['start_date'] = strtotime($sertificate['start_date']);
        $sertificate['end_date'] = strtotime($sertificate['end_date']);
    }
    unset($sertificate);

    $education = $_POST['education'];
    $education['start_date'] = strtotime($education['start_date']);
    $education['end_date'] = strtotime($education['end_date']);

    $languages = $_POST['languages'];

    $interests = $_POST['interests'];

//    echo "<pre>";
//    var_dump($_POST);
//    echo "</pre>";

    include 'view_cv.php';

}

else {
    echo 'Something gone wrong';
}

