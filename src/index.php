<?php

require_once 'validation.php';

$icons = [
    'email' => '<i class="fas fa-envelope-square"></i>',
    'skype' => '<i class="fab fa-skype"></i>',
    'phone' => '<i class="fas fa-phone"></i>',
    'address' => '<i class="fas fa-map-marker-alt"></i>'
];

$errors = [
    'name' => array(),
    'image' => array(),
    'email' => array(),
    'date' => array(),
    'profi' => array(),
    'contact_email' => array(),
    'sert_date' => array(),
    'edu_date' => array(),
    //'else' => array(),
];

if (!empty($_POST)) {

    //common information
    if (not_empty_validator($_POST['firstname']))
        $firstname = $_POST['firstname'];
    else
        $errors['name'][] = 'Name required';

    $lastname = $_POST['lastname'];

    if (uri_validator($_POST['image']))
        $image = $_POST['image'];
    else
        $errors['image'][] = 'This field must contain URL';

    $vacancy = $_POST['vacancy'];
    $resume = $_POST['resume'];
    //common information


    //contacts
    if (email_validator($_POST['contacts']['email']))
        $contacts = $_POST['contacts'];
    else
        $errors['email'][] = 'Email should be valid';

    $address = $_POST['address'];

    $coordinates = geocode($address);
    $address['latitude'] = $coordinates['latitude'];
    $address['longitude'] = $coordinates['longitude'];
    //contacts

    //work experiences
    $experiences = $_POST['experiences'];

    $index = -1; //костыли, костыли
    foreach ($experiences as &$experience) {
        $index++;

        if (date_validator($experience['start_date']) && date_validator($experience['end_date'])) {
            $experience['start_date'] = strtotime($experience['start_date']);
            $experience['end_date'] = strtotime($experience['end_date']);
        }
        else {
            $errors['date'][] = 'Experience Date should be date';
            break;
        }

        if (!email_validator($experience['contacts']['email']) && !is_null($experience['contacts']['email'])) {
            $errors['contact_email'][] = 'Contact email should be correct email';
            break;
        }
    }
    unset($experience);
    //work experiences


    $skills = $_POST['skills'];
    foreach ($skills as $skill) {
        if (!between_validator($skill['profi'], [0, 100])) {
            $errors['profi'][] = 'Value should fit the interval between 0 and 100';
            break;
        }
    }

    //sertificates
    $sertificates = $_POST['sertificates'];
    foreach ($sertificates as &$sertificate) {
        if (date_validator($sertificate['start_date']) && date_validator($sertificate['end_date'])) {
            $sertificate['start_date'] = strtotime($sertificate['start_date']);
            $sertificate['end_date'] = strtotime($sertificate['end_date']);
        }
        else {
            $errors['sert_date'][] = 'In the Sertificate date field should be correct date';
            break;
        }
    }
    unset($sertificate);
    //sertificates


    $education = $_POST['education'];
    if (date_validator($education['start_date']) && date_validator($education['end_date'])) {
        $education['start_date'] = strtotime($education['start_date']);
        $education['end_date'] = strtotime($education['end_date']);
    }
    else {
        $errors['edu_date'][] = 'In the Education date field should be correct date';
    }

    $languages = $_POST['languages'];

    $interests = $_POST['interests'];


    $count = null;
    foreach ($errors as $error) {
        $count += count($error);
    }

    if ($count == 0)
        include "view_cv.php";
    //else echo 'bebebe';
}

//else {
//    echo 'Something gone wrong';
//}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title>CV</title>
    <style>
        .container {
            margin: 4em;
        }
        .interests span {
            border: 1px solid black;
            padding: 2px;
            margin: 6px;
        }
        .columns {
            column-count: 2;
        }
        .right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
<!--                <div>-->
<!--                    --><?php //if (count($errors['else'])): ?>
<!--                        <p>Где-то в этой огромной форме были допущены следующие ошибки: </p> <br>-->
<!--                        --><?php //foreach ($errors['else'] as $error): ?>
<!--                            <b style="color: red"> --><?//= $error ?><!-- </b> <br>-->
<!--                        --><?php //endforeach ?>
<!--                    --><?php //endif ?>
<!--                </div>-->
                <form method="post">
                    <fieldset class="form-group">
                        <legend>Common information</legend>
                        <div class="form-group">
                            <label for="firstname">First name: </label>
                            <?php if (count($errors['name'])): ?>
                                <?php foreach ($errors['name'] as $error): ?>
                                    <b class="alert alert-danger"> <?= $error ?> </b>
                                <?php endforeach ?>
                            <?php endif ?>
                            <input type="text" name="firstname" value=<?= $_POST['firstname'] ?? "John"?> >
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last name: </label>
                            <input type="text" name="lastname" value=<?= $_POST['lastname'] ?? "Doe"?> >
                        </div>
                        <div class="form-group">
                            <label for="vacancy">Vacancy: </label>
                            <input type="text" name="vacancy" value=<?= $_POST['vacancy'] ?? "Bar manager"?> >
                        </div>
                        <div class="form-group">
                            <label for="image">Link to photo</label>
                            <?php if (count($errors['image'])): ?>
                                <?php foreach ($errors['image'] as $error): ?>
                                    <b class="alert alert-danger"> <?= $error ?> </b>
                                <?php endforeach ?>
                            <?php endif ?>
                            <input type="text" name="image" value="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/08dc5673-6005-4fa8-b302-66b573530923/dd5i4ss-f916ba26-94dd-4ef8-b21f-004ffad22987.png/v1/fill/w_150,h_150,strp/cute_cthulhu_sticker_by_tardisghost_dd5i4ss-fullview.png?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9NjAwIiwicGF0aCI6IlwvZlwvMDhkYzU2NzMtNjAwNS00ZmE4LWIzMDItNjZiNTczNTMwOTIzXC9kZDVpNHNzLWY5MTZiYTI2LTk0ZGQtNGVmOC1iMjFmLTAwNGZmYWQyMjk4Ny5wbmciLCJ3aWR0aCI6Ijw9NjAwIn1dXSwiYXVkIjpbInVybjpzZXJ2aWNlOmltYWdlLm9wZXJhdGlvbnMiXX0.9AV2M_W2obwwS6jpQ4b0COenGn87MEBq4I5MC2WMmFE">
                        </div>
                        <div class="form-group">
                            <label for="resume">Few words about yourself</label>
                            <textarea name="resume">Few words about yourself</textarea>
                        </div>
                    </fieldset>
                    <fieldset class="form-group">
                        <legend>Contacts</legend>
                        <div class="form-group">
                            <label for="contacts[email]">Email: </label>
                            <?php if (count($errors['email'])): ?>
                                <?php foreach ($errors['email'] as $error): ?>
                                    <b class="alert alert-danger"> <?= $error ?> </b>
                                <?php endforeach ?>
                            <?php endif ?>
                            <input type="text" name="contacts[email]" value=<?= $_POST['contacts']['email'] ?? "johndoe@gmail.com" ?> >
                        </div>
                        <div class="form-group">
                            <label for="contacts[phone]">Phone: </label>
                            <input type="text" name="contacts[phone]" value=<?= $_POST['contacts']['phone'] ?? "0043312436" ?> >
                        </div>
                        <div class="form-group">
                            <label for="contacts[skype]">Skype: </label>
                            <input type="text" name="contacts[skype]" value=<?= $_POST['contacts']['skype'] ?? "johndoe" ?> >
                        </div>
                        <div class="form-group">
                            <label for="address[city]">City: </label>
                            <input type="text" name="address[city]" value="Sydney">
                        </div>
                        <div class="form-group">
                            <label for="address[country]">Country: </label>
                            <input type="text" name="address[country]" value="Australia">
                        </div>
                    </fieldset>
                    <fieldset class="form-group">
                        <legend>Work Experience</legend>
                        <?php for ($i = 0; $i<3; $i++):?>
                            <fieldset class="form-group">
                                <legend>Experience <?= $i ?> </legend>
                                <label for="experiences[<?= $i ?>][position]">Position: </label>
                                <input type="text" name="experiences[<?= $i ?>][position]" value="Some position <?= $i ?>"> <br>
                                <label for="experiences[<?= $i ?>][place]">Place: </label>
                                <input type="text" name="experiences[<?= $i ?>][place]" value="Some place <?= $i ?>"> <br>
                                <?php if (count($errors['date'])): ?>
                                    <?php if ($i == $index): ?>
                                        <?php foreach ($errors['date'] as $error): ?>
                                            <b class="alert alert-danger"> <?= $error ?> </b>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                <?php endif ?>
                                <label for="experiences[<?= $i ?>][start_date]">Start date: </label>
                                <input type="text" name="experiences[<?= $i ?>][start_date]" value="2013-06-01">
                                <label for="experiences[<?= $i ?>][end_date]">End date: </label>
                                <input type="text" name="experiences[<?= $i ?>][end_date]" value="2016-12-01"> <br>
                                <fieldset class="form-group">
                                    <legend>Address</legend>
                                    <label for="experiences[<?= $i ?>][address][city]">City: </label>
                                    <input type="text" name="experiences[<?= $i ?>][address][city]" value="Sydney">
                                    <label for="experiences[<?= $i ?>][address][country]">Country: </label>
                                    <input type="text" name="experiences[<?= $i ?>][address][country]" value="Australia">
                                </fieldset>
                                <fieldset class="form-group">
                                    <legend>Tasks: </legend>
                                    <?php for ($j = 0; $j<4; $j++): ?>
                                        <label for="experiences[<?= $i ?>][tasks][<?= $j ?>]">Task: <?= $j ?> </label>
                                        <textarea name="experiences[<?= $i ?>][tasks][<?= $j ?>]">I've done plenty of useless things <?= $j ?> </textarea> <br>
                                    <?php endfor; ?>
                                </fieldset>
                                <fieldset class="form-group">
                                    <legend>Contact</legend>
                                    <label for="experiences[<?= $i ?>][firstname]">Firstname: </label>
                                    <input type="text" name="experiences[<?= $i ?>][firstname]" value="Vince">
                                    <label for="experiences[<?= $i ?>][lastname]">Lastname: </label>
                                    <input type="text" name="experiences[<?= $i ?>][lastname]" value="Scarlett"> <br>
                                    <?php if (count($errors['contact_email'])): ?>
                                        <?php if ($i == $index): ?>
                                            <?php foreach ($errors['contact_email'] as $error): ?>
                                                <b class="alert alert-danger"> <?= $error ?> </b>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    <?php endif ?>
                                    <label for="experiences[<?= $i ?>][contacts][email]">Email: </label>
                                    <input type="text" name="experiences[<?= $i ?>][contacts][email]" value="vince@scarlett.com"> <br>
                                    <label for="experiences[<?= $i ?>][contacts][phone]">Phone: </label>
                                    <input type="text" name="experiences[<?= $i ?>][contacts][phone]" value="0021213235"> <br>
                                    <label for="experiences[<?= $i ?>][contacts][skype]">Email: </label>
                                    <input type="text" name="experiences[<?= $i ?>][contacts][skype]" value="vincescarlett"> <br>
                                </fieldset>
                            </fieldset>
                        <?php endfor; ?>
                    </fieldset>
                    <fieldset class="form-group">
                        <legend>Skills</legend>
                        <?php if (count($errors['profi'])): ?>
                            <?php foreach ($errors['profi'] as $error): ?>
                                <b class="alert alert-danger"> <?= $error ?> </b> <br>
                            <?php endforeach ?>
                        <?php endif ?>
                        <?php for ($i = 0; $i<8; $i++): ?>
                            <label for="skills[<?= $i ?>][skill]">Skill: </label>
                            <input type="text" name="skills[<?= $i ?>][skill]" value="Skill <?= $i ?>">
                            <label for="skills[<?= $i ?>][profi]">Value from 0 to 100</label>
                            <input type="text" name="skills[<?= $i ?>][profi]" min="0" max="100" value="<?= (80 + 2*$i) ?>"> <br>
                        <?php endfor; ?>
                    </fieldset>
                    <fieldset class="form-group">
                        <legend>Sertificates</legend>
                        <?php if (count($errors['sert_date'])): ?>
                            <?php foreach ($errors['sert_date'] as $error): ?>
                                <b class="alert alert-danger"> <?= $error ?> </b> <br>
                            <?php endforeach ?>
                        <?php endif ?>
                        <?php for ($i = 0; $i<3; $i++): ?>
                            <label for="sertificates[<?= $i ?>][title]">Title: </label>
                            <input type="text" name="sertificates[<?= $i ?>][title]" value="Foundation Leadership Program Certificate"> <br>
                            <label for="sertificates[<?= $i ?>][start_date]">Start date: </label>
                            <input type="text" name="sertificates[<?= $i ?>][start_date]" value="2016-01-01"> <br>
                            <label for="sertificates[<?= $i ?>][end_date]">End date</label>
                            <input type="text" name="sertificates[<?= $i ?>][end_date]" value="2016-01-01"> <br>
                            <label for="sertificates[<?= $i ?>][title]">Comment: </label>
                            <input type="text" name="sertificates[<?= $i ?>][title]" value="By CSE EMTW Education institute"> <br>
                        <?php endfor; ?>
                    </fieldset>
                    <fieldset class="form-group">
                        <legend>Education</legend>
                        <label for="education[university]">University</label>
                        <input type="text" name="education[university]" value="Brisbane University">
                        <label for="education[profession]">Profession</label>
                        <input type="text" name="education[profession]" value="Service Management"> <br>
                        <?php if (count($errors['edu_date'])): ?>
                            <?php foreach ($errors['edu_date'] as $error): ?>
                                <b class="alert alert-danger"> <?= $error ?> </b> <br>
                            <?php endforeach ?>
                        <?php endif ?>
                        <label for="education[start_date]">Start_date</label>
                        <input type="text" name="education[start_date]" value="2005-08-01">
                        <label for="education[end_date]">End_date</label>
                        <input type="text" name="education[end_date]" value="2008-08-01">
                    </fieldset>
                    <fieldset class="form-group">
                        <legend>Languages</legend>
                        <?php for ($i = 0; $i<4; $i++): ?>
                            <label for="languages[<?= $i ?>][language]">Language: </label>
                            <input type="text" name="languages[<?= $i ?>][language]" value="English">
                            <select name="languages[<?= $i ?>][level]">
                                <option disabled>Level: </option>
                                <option selected value ="Beginner">Beginner</option>
                                <option value="Expert">Expert</option>
                                <option value="Fluent">Fluent</option>
                                <option value="Native">Native</option>
                            </select> <br>
                        <?php endfor; ?>
                    </fieldset>
                    <fieldset class="form-group">
                        <legend>Interests</legend>
                        <input type="checkbox" name="interests[]" value="Economics"> Economics
                        <input type="checkbox" name="interests[]" value="Psychology"> Psychology
                        <input type="checkbox" name="interests[]" value="Mixology"> Mixology
                        <input type="checkbox" name="interests[]" value="Chess"> Chess
                        <input type="checkbox" name="interests[]" value="Serfing"> Serfing
                        <input type="checkbox" name="interests[]" value="Marketing"> Marketing
                    </fieldset>

                    <input type="submit" value="Save">
                </form>
            </div>
        </div>
    </div>
</body>
</html>

