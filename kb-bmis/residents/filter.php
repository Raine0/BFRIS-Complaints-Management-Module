<?php

$streetQuery = '';
$purokQuery = '';
$civilStatusQuery = '';
$ageQuery = '';

// Street
if (filter_has_var(INPUT_GET, 'street') && $_GET['street'] != "") {
    $street =  htmlspecialchars($_GET['street']);
    $streetQuery = "AND street = '$street'";
}

// Purok
if (filter_has_var(INPUT_GET, 'purok') && $_GET['purok'] != "") {
    $purok = htmlspecialchars($_GET['purok']);
    $purokQuery = "AND purok = '$purok'";
}

// Civil_status
if (filter_has_var(INPUT_GET, 'civil_status') && $_GET['civil_status'] != "") {
    $civil_status = htmlspecialchars($_GET['civil_status']);
    $civilStatusQuery = "AND civil_status = '$civil_status'";
}

// Age group
if (filter_has_var(INPUT_GET, 'age') && $_GET['age'] != "") {
    $age =  htmlspecialchars($_GET['age']);
    if ($age === "Children") {
        $ageQuery = 'AND TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= 12';
    } else if ($age === "Adolescents") {
        $ageQuery = 'AND TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 13 AND 18';
    } else if ($age === "Adults") {
        $ageQuery = 'AND TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 19 AND 59';
    } else if ($age === "Senior") {
        $ageQuery = 'AND TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) >= 60';
    }
}


// where condition in sql
$conditions = array($streetQuery, $purokQuery, $civilStatusQuery, $ageQuery);
$conditions = array_filter($conditions, function ($condition) {
    return !empty($condition);
});

$whereCondition = implode(' ', $conditions);
if (!empty($whereCondition)) {
    $condition = "1=1 " . $whereCondition;
}
