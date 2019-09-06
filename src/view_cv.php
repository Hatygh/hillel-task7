<?php
//
//require_once('validation.php');
//
//?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title><?php echo $firstname . ' ' . $lastname; ?></title>
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
<!--            <div class="col-sm-12">-->
<!--                <a href="index.php">Edit</a>-->
<!--            </div>-->
        </div>
        <div class="row">
            <div class="col-sm-2">
                <img src="<?php echo $image; ?>" alt="">
            </div>
            <div class="col-sm-4">
                <h1><?php echo $firstname . ' ' . $lastname; ?></h1>
                <p><?php echo $vacancy; ?></p>
            </div>
            <div class="col-sm-6 right">
                <p><?php echo $contacts['email']; ?> <a href="mailto:<?php echo $contacts['email']; ?>" target="_blank" > <?php echo $icons['email']; ?> </a> </p>
                <p><?php echo $contacts['phone']; ?> <a href="tel:<?php echo $contacts['phone']; ?>" target="_blank" > <?php echo $icons['phone']; ?> </a> </p>
                <p><?php echo $address['city'] . ', ' . $address['country']; ?> <a href="https://www.google.com/maps/place/<?php echo $address['latitude']; ?>+<?php echo $address['longitude']; ?>" target="_blank" > <?php echo $icons['address']; ?> </a> </p>
                <p><?php echo $contacts['skype'];?> <a href="skype:<?php echo $contacts['skype']; ?>" target="_blank" > <?php echo $icons['skype']; ?> </a> </p>
            </div>
        </div>

        <div class="row">
            <p><?php echo $resume; ?></p>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <h2>Work Experience</h2>
                <hr>
                <?php foreach ($experiences as $experience): ?>
                    <h2><?php echo $experience['position']; ?></h2>
                    <p><?php echo $experience['place']; ?></p>
                    <p><?php echo period($experience['start_date'], $experience['end_date']); ?></p>
                    <p><?php echo $experience['address']['city'] . ', ' . $experience['address']['country']; ?></p>
                    <div class="tasks">
                        <p>Tasks:</p>
                        <ul>
                            <?php foreach ($experience['tasks'] as $task): ?>
                                <li><?php echo $task; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php
                        $contacts = $experience['firstname'] . ' ' . $experience['lastname'];
                        foreach ($experience['contacts'] as $contact) {
                            if ($contact)
                                $contacts = $contacts . ' - ' . $contact;
                        }
                    ?>
                    <p>Contacts: <?php echo $contacts; ?></p>
                 <?php endforeach; ?>
            </div>
            <div class="col-sm-5">
                <div class="skills">
                    <h2>Skills & Competences</h2>
                    <hr>
                    <div class="row">
                        <?php foreach ($skills as $skill): ?>
                            <div class="col-sm-6">
                                <?php echo $skill['skill']; ?>
                            </div>
                            <div class="col-sm-6">
                                <progress value="<?php echo $skill['profi']; ?>" max="100"></progress>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="sertificates">
                    <h2>Sertificates</h2>
                    <hr>
                    <?php foreach ($sertificates as $sertificate): ?>
                        <p><?php echo $sertificate['title'] . ' (' .  period($sertificate['start_date'], $sertificate['end_date']) . ')'; ?></p>
                        <p><?php echo $sertificate['comment']; ?></p>
                        <br>
                    <?php endforeach; ?>
                </div>
                <div class="education">
                    <h2>Education</h2>
                    <hr>
                    <p><?php echo $education['profession']; ?></p>
                    <p><?php echo $education['university']; ?></p>
                    <p><?php echo period($education['start_date'], $education['end_date']); ?></p>
                </div>
                <div class="languages">
                    <h2>Languages</h2>
                    <hr>
                    <div class="columns">
                        <?php foreach ($languages as $language): ?>
                            <div class="language">
                                <p><?php echo $language['language']; ?></p>
                                <p><i><?php echo $language['level']; ?></i></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="interests">
                    <?php if ($interests): ?>
                        <h2>Interests</h2>
                        <hr>
                        <?php foreach ($interests as $interest): ?>
                            <span><?php echo $interest; ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

