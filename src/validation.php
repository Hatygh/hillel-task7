<?php

function diffDate($start_date, $end_date)
{

    if ( (!$start_date) or (!$end_date) ) {
        return 'That was not a timestamp';
    }

    if ($start_date > $end_date) {
        return 'Time traveler detected';
    };

    if ($start_date == $end_date) {
        return 'Just a second';
    };

    $local = [
        ['день', 'дня', 'дней'],
        ['месяц', 'месяца', 'месяцев'],
        ['год', 'года', 'лет'],
    ];

    $diff_date = $end_date - $start_date;
    $years = floor($diff_date / (365*60*60*24));
    $months = floor(($diff_date - $years * 365*60*60*24) / (30*60*60*24));
    $days = floor(($diff_date - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

    $date = [$days, $months, $years];

    $local_date = array();
    $i = 0;

    foreach ($date as $processed_date)
    {
        if (!$processed_date) {
            $local_date[] = null;
        }
        else {
            while ($processed_date >= 20) {
                $processed_date = $processed_date % 10;
            };
            if ($processed_date == 1) {
                $local_date[] = $local[$i][0];
            } elseif (($processed_date >= 2) and ($processed_date <= 4)) {
                $local_date[] = $local[$i][1];
            } else {
                $local_date[] = $local[$i][2];
            };
        };
        $i++;
    };

    $result = null;
    for ($i = 0; $i <= 2; $i++)
    {
        if ($date[$i]) {
            $result = $result . ' ' . $date[$i] . ' ' . $local_date[$i];
        }
    }

    $result = trim($result);
    return $result;

};

function period($start_date, $end_date)
{
    $result = null;
    if ( ($start_date) and ($end_date) ) {
        $result = date('m/Y', $start_date) . ' - ' . date('m/Y', $end_date);
    };

    if ( ($start_date) and (!$end_date) ) {
        $result = date('m/Y', $start_date);
    };

    if ( (!$start_date) and ($end_date) ) {
        $result = date('m/Y', $end_date);
    };
    return $result;
};

function between_validator($number, array $array, bool $isStrict = true) {

    // @TODO запихнуть это все в трай кетч

    if (count($array) != 2) {
        throw new Exception('В массиве должно быть два элемента');
        //return false;
    }

    foreach ($array as $num) {
        if (!is_numeric($num)) {
            throw new Exception('В массиве должны быть только числа');
            //return false;
        }
    }

    sort($array);

    $min = $array[0];
    $max = $array[1];

    if ($isStrict && ( $number == $min || $number == $max )) {
        return true;
    }

    if ( $number > $min && $number < $max) {
        return true;
    }
    else {
        return false;
    }

};

function digit_validator($number) {
    if (is_numeric($number)) return true;
        else return false;
};

function email_validator($email, $host = null) {
    $email = trim($email);

    $isEmail = false;
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $isEmail = true;
        if ($host) {
            //domain validation
            $exploded_email = explode('@', $email);
            if (!strcmp($exploded_email[1], $host)) return true;
                else return false;
        }
    }
    return $isEmail;
};

function string_length_validator($str, int $minlength, int $maxlength) {
    $length = strlen($str);
    if ( ($length >= $minlength) && ($length <= $maxlength) )
        return true;
    else
        return false;
};

function in_validator($value, array $array) {
    if (in_array($value, $array))
        return true;
    else
        return false;
};

function identical_validator($first_value, $second_value) {
    if (!strcmp($first_value, $second_value))
        return true;
    else
        return false;
};

function uri_validator($url) {
    if (!filter_var($url, FILTER_VALIDATE_URL))
        return true;
    else
        return false;
};

function not_empty_validator($value) {
    return empty($value);
}

function date_validator($date) {

}

//получить координаты по названию города и страны
function geocode ($address) {
    $url = "https://nominatim.openstreetmap.org/search?q=" . $address['city'] . ",%20" . $address['country'] . "&format=json&limit=1";

    // Create a stream
    $opts = array('http'=>array('header'=>"User-Agent: StevesCleverAddressScript 3.7.6\r\n"));
    $context = stream_context_create($opts);

    // Open the file using the HTTP headers set above
    $response_json = file_get_contents($url, false, $context);

    $response = json_decode($response_json, true);

    $latitude = $response[0]['lat'];
    $longitude = $response[0]['lon'];

    $result = [
        'latitude' => $latitude,
        'longitude' => $longitude,
    ];

    return $result;
};






