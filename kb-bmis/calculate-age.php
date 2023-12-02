<?php
function calculate_age($birthdate)
{
    $today = new DateTime('today');
    $birthdate = new DateTime($birthdate);
    $age = $today->diff($birthdate)->y;

    return $age;
}
