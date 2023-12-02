<?php


// Total population
$populationQuery = "SELECT COUNT(resident_id) AS resident FROM resident";
$populationStatement = $pdo->query($populationQuery);
$totalPopulation = $populationStatement->fetch(PDO::FETCH_ASSOC);


// Total Voters
$voterQuery = "SELECT COUNT(resident_id) AS voters FROM `resident` WHERE `voter_status` = :voter";
$voterStatement = $pdo->prepare($voterQuery);
$voterStatement->bindValue(':voter', 'Registered Voter');
$voterStatement->execute();
$totalVoters = $voterStatement->fetch(PDO::FETCH_ASSOC);

// Total Male Resident
$maleQuery = "SELECT COUNT(resident_id) AS maleTotal FROM `resident` WHERE  sex = :sex";
$maleStatement = $pdo->prepare($maleQuery);
$maleStatement->bindValue(':sex', 'Male');
$maleStatement->execute();
$totalMale = $maleStatement->fetch(PDO::FETCH_ASSOC);

// Total Female Resident
$femaleQuery = "SELECT COUNT(resident_id) AS femaleTotal FROM `resident` WHERE sex = :sex";
$femaleStatement = $pdo->prepare($femaleQuery);
$femaleStatement->bindValue(':sex', 'Female');
$femaleStatement->execute();
$totalFemale = $femaleStatement->fetch(PDO::FETCH_ASSOC);


// SQL FOR AGE GROUP// 
$childQuery = "SELECT COUNT(resident_id) AS child FROM resident WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) <= 12";
$childStatement = $pdo->query($childQuery);
$totalChild = $childStatement->fetch(PDO::FETCH_ASSOC);

$adolescentQuery = "SELECT COUNT(resident_id) AS adolescent FROM resident WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 13 AND 18";
$adolescentStatement = $pdo->query($adolescentQuery);
$totalAdolescent = $adolescentStatement->fetch(PDO::FETCH_ASSOC);

$adultQuery = "SELECT COUNT(resident_id) AS adult FROM resident WHERE TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 19 AND 59";
$adultStatement = $pdo->query($adultQuery);
$totalAdult = $adultStatement->fetch(PDO::FETCH_ASSOC);

$seniorQuery = "SELECT COUNT(resident_id) AS senior FROM resident WHERE senior_status = :senior";
$seniorStatement = $pdo->prepare($seniorQuery);
$seniorStatement->bindValue(':senior', 'Senior Citizen');
$seniorStatement->execute();
$totalSenior = $seniorStatement->fetch(PDO::FETCH_ASSOC);


// SQL (TOTAL SALES )//

$janChart = "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";
$janStatement = $pdo->prepare($janChart);
$janStatement->bindValue(':month', 'January');
$janStatement->bindValue(':year', '2022');
$janStatement->execute();

$jan_count = $janStatement->fetch(PDO::FETCH_ASSOC);


$febChart = "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";

$febStatement = $pdo->prepare($febChart);
$febStatement->bindValue(':month', 'Febuary');
$febStatement->bindValue(':year', '2022');
$febStatement->execute();

$feb_count = $febStatement->fetch(PDO::FETCH_ASSOC);



$marChart =  "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";

$marStatement = $pdo->prepare($marChart);
$marStatement->bindValue(':month', 'March');
$marStatement->bindValue(':year', '2022');
$marStatement->execute();

$mar_count = $marStatement->fetch(PDO::FETCH_ASSOC);


$aprChart =  "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";

$aprStatement = $pdo->prepare($aprChart);
$aprStatement->bindValue(':month', 'April');
$aprStatement->bindValue(':year', '2022');
$aprStatement->execute();

$apr_count = $aprStatement->fetch(PDO::FETCH_ASSOC);

$mayChart = "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";

$mayStatement = $pdo->prepare($mayChart);
$mayStatement->bindValue(':month', 'May');
$mayStatement->bindValue(':year', '2022');
$mayStatement->execute();

$may_count = $mayStatement->fetch(PDO::FETCH_ASSOC);

$juneChart = "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";

$juneStatement = $pdo->prepare($juneChart);
$juneStatement->bindValue(':month', 'June');
$juneStatement->bindValue(':year', '2022');
$juneStatement->execute();

$jun_count = $juneStatement->fetch(PDO::FETCH_ASSOC);

$julyChart = "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";

$julyStatement = $pdo->prepare($julyChart);
$julyStatement->bindValue(':month', 'July');
$julyStatement->bindValue(':year', '2022');
$julyStatement->execute();

$jul_count = $julyStatement->fetch(PDO::FETCH_ASSOC);

$augChart = "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";

$augStatement = $pdo->prepare($augChart);
$augStatement->bindValue(':month', 'August');
$augStatement->bindValue(':year', '2022');
$augStatement->execute();

$aug_count = $augStatement->fetch(PDO::FETCH_ASSOC);

$septChart = "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";

$septStatement = $pdo->prepare($septChart);
$septStatement->bindValue(':month', 'September');
$septStatement->bindValue(':year', '2022');
$septStatement->execute();

$sept_count = $septStatement->fetch(PDO::FETCH_ASSOC);

$octChart = "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";

$octStatement = $pdo->prepare($octChart);
$octStatement->bindValue(':month', 'October');
$octStatement->bindValue(':year', '2022');
$octStatement->execute();

$oct_count = $octStatement->fetch(PDO::FETCH_ASSOC);

$novChart = "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";

$novStatement = $pdo->prepare($novChart);
$novStatement->bindValue(':month', 'November');
$novStatement->bindValue(':year', '2022');
$novStatement->execute();

$nov_count = $novStatement->fetch(PDO::FETCH_ASSOC);

$decChart = "SELECT SUM(fee) AS janSales, MONTHNAME(date_issued), YEAR(date_issued) FROM (SELECT brgy_clearance_id, date_issued, fee FROM brgy_clearance_view) ab WHERE MONTHNAME(date_issued) = :month AND YEAR(date_issued) = :year";

$decStatement = $pdo->prepare($decChart);
$decStatement->bindValue(':month', 'December');
$decStatement->bindValue(':year', '2022');
$decStatement->execute();

$dec_count = $decStatement->fetch(PDO::FETCH_ASSOC);


// SQL (Barangay Population Count by Purok)

$purok1Chart = "SELECT COUNT(resident_id) AS 'Purok_1' FROM resident WHERE purok = :purok";
$purok1Statement = $pdo->prepare($purok1Chart);
$purok1Statement->bindValue(':purok', 'Purok 1');
$purok1Statement->execute();
$purok1 = $purok1Statement->fetch(PDO::FETCH_ASSOC);

$purok2Chart = "SELECT COUNT(resident_id) AS 'Purok_2' FROM resident WHERE purok = :purok";
$purok2Statement = $pdo->prepare($purok2Chart);
$purok2Statement->bindValue(':purok', 'Purok 2');
$purok2Statement->execute();
$purok2 = $purok2Statement->fetch(PDO::FETCH_ASSOC);

$purok3Chart = "SELECT COUNT(resident_id) AS 'Purok_3' FROM resident WHERE purok = :purok";
$purok3Statement = $pdo->prepare($purok3Chart);
$purok3Statement->bindValue(':purok', 'Purok 3');
$purok3Statement->execute();
$purok3 = $purok3Statement->fetch(PDO::FETCH_ASSOC);

$purok4Chart = "SELECT COUNT(resident_id) AS 'Purok_4' FROM resident WHERE purok = :purok";
$purok4Statement = $pdo->prepare($purok4Chart);
$purok4Statement->bindValue(':purok', 'Purok 4');
$purok4Statement->execute();
$purok4 = $purok4Statement->fetch(PDO::FETCH_ASSOC);

$purok5Chart = "SELECT COUNT(resident_id) AS 'Purok_5' FROM resident WHERE purok = :purok";
$purok5Statement = $pdo->prepare($purok5Chart);
$purok5Statement->bindValue(':purok', 'Purok 5');
$purok5Statement->execute();
$purok5 = $purok5Statement->fetch(PDO::FETCH_ASSOC);

$purok6Chart = "SELECT COUNT(resident_id) AS 'Purok_6' FROM resident WHERE purok = :purok";
$purok6Statement = $pdo->prepare($purok6Chart);
$purok6Statement->bindValue(':purok', 'Purok 6');
$purok6Statement->execute();
$purok6 = $purok6Statement->fetch(PDO::FETCH_ASSOC);

$purok7Chart = "SELECT COUNT(resident_id) AS 'Purok_7' FROM resident WHERE purok = :purok";
$purok7Statement = $pdo->prepare($purok7Chart);
$purok7Statement->bindValue(':purok', 'Purok 7');
$purok7Statement->execute();
$purok7 = $purok7Statement->fetch(PDO::FETCH_ASSOC);

$purok8Chart = "SELECT COUNT(resident_id) AS 'Purok_8' FROM resident WHERE purok = :purok";
$purok8Statement = $pdo->prepare($purok8Chart);
$purok8Statement->bindValue(':purok', 'Purok 8');
$purok8Statement->execute();
$purok8 = $purok8Statement->fetch(PDO::FETCH_ASSOC);

$purok9_AChart = "SELECT COUNT(resident_id) AS 'Purok_9_A' FROM resident WHERE purok = :purok";
$purok9_AStatement = $pdo->prepare($purok9_AChart);
$purok9_AStatement->bindValue(':purok', 'Purok 9-A');
$purok9_AStatement->execute();
$purok9_A = $purok9_AStatement->fetch(PDO::FETCH_ASSOC);


$purok9_BChart = "SELECT COUNT(resident_id) AS 'Purok_9_B' FROM resident WHERE purok = :purok";
$purok9_BStatement = $pdo->prepare($purok9_BChart);
$purok9_BStatement->bindValue(':purok', 'Purok 9-B');
$purok9_BStatement->execute();
$purok9_B = $purok9_BStatement->fetch(PDO::FETCH_ASSOC);

$purok10_AChart = "SELECT COUNT(resident_id) AS 'Purok_10_A' FROM resident WHERE purok = :purok";
$purok10_AStatement = $pdo->prepare($purok10_AChart);
$purok10_AStatement->bindValue(':purok', 'Purok 10-A');
$purok10_AStatement->execute();
$purok10_A = $purok10_AStatement->fetch(PDO::FETCH_ASSOC);

$purok10_BChart = "SELECT COUNT(resident_id) AS 'Purok_10_B' FROM resident WHERE purok = :purok";
$purok10_BStatement = $pdo->prepare($purok10_BChart);
$purok10_BStatement->bindValue(':purok', 'Purok 10-B');
$purok10_BStatement->execute();
$purok10_B = $purok10_BStatement->fetch(PDO::FETCH_ASSOC);

$purok11Chart = "SELECT COUNT(resident_id) AS 'Purok_11' FROM resident WHERE purok = :purok";
$purok11Statement = $pdo->prepare($purok11Chart);
$purok11Statement->bindValue(':purok', 'Purok 11');
$purok11Statement->execute();
$purok11 = $purok11Statement->fetch(PDO::FETCH_ASSOC);

$puroklower11_AChart = "SELECT COUNT(resident_id) AS 'Purok_Lower_11_A' FROM resident WHERE purok = :purok";
$puroklower11_AStatement = $pdo->prepare($puroklower11_AChart);
$puroklower11_AStatement->bindValue(':purok', 'Purok Lower 11-A');
$puroklower11_AStatement->execute();
$puroklower11_A = $puroklower11_AStatement->fetch(PDO::FETCH_ASSOC);

$purokupper11_AChart = "SELECT COUNT(resident_id) AS 'Purok_Upper_11_A' FROM resident WHERE purok = :purok";
$purokupper11_AStatement = $pdo->prepare($purokupper11_AChart);
$purokupper11_AStatement->bindValue(':purok', 'Purok Upper 11-A');
$purokupper11_AStatement->execute();
$purokupper11_A = $purokupper11_AStatement->fetch(PDO::FETCH_ASSOC);

$purok11_BChart = "SELECT COUNT(resident_id) AS 'Purok_11_B' FROM resident WHERE purok = :purok";
$purok11_BStatement = $pdo->prepare($purok11_BChart);
$purok11_BStatement->bindValue(':purok', 'Purok 11-B');
$purok11_BStatement->execute();
$purok11_B = $purok11_BStatement->fetch(PDO::FETCH_ASSOC);

$purok11_CChart = "SELECT COUNT(resident_id) AS 'Purok_11_C' FROM resident WHERE purok = :purok";
$purok11_CStatement = $pdo->prepare($purok11_CChart);
$purok11_CStatement->bindValue(':purok', 'Purok 11-C');
$purok11_CStatement->execute();
$purok11_C = $purok11_CStatement->fetch(PDO::FETCH_ASSOC);

$purok12Chart = "SELECT COUNT(resident_id) AS 'Purok_12' FROM resident WHERE purok = :purok";
$purok12Statement = $pdo->prepare($purok12Chart);
$purok12Statement->bindValue(':purok', 'Purok 12');
$purok12Statement->execute();
$purok12 = $purok12Statement->fetch(PDO::FETCH_ASSOC);

$purok12_AChart = "SELECT COUNT(resident_id) AS 'Purok_12_A' FROM resident WHERE purok = :purok";
$purok12_AStatement = $pdo->prepare($purok12_AChart);
$purok12_AStatement->bindValue(':purok', 'Purok 12-A');
$purok12_AStatement->execute();
$purok12_A = $purok12_AStatement->fetch(PDO::FETCH_ASSOC);

$purok13Chart = "SELECT COUNT(resident_id) AS 'Purok_13' FROM resident WHERE purok = :purok";
$purok13Statement = $pdo->prepare($purok13Chart);
$purok13Statement->bindValue(':purok', 'Purok 13');
$purok13Statement->execute();
$purok13 = $purok13Statement->fetch(PDO::FETCH_ASSOC);

$purok13_AChart = "SELECT COUNT(resident_id) AS 'Purok_13_A' FROM resident WHERE purok = :purok";
$purok13_AStatement = $pdo->prepare($purok13_AChart);
$purok13_AStatement->bindValue(':purok', 'Purok 13-A');
$purok13_AStatement->execute();
$purok13_A = $purok13_AStatement->fetch(PDO::FETCH_ASSOC);

$purok13_BChart = "SELECT COUNT(resident_id) AS 'Purok_13_B' FROM resident WHERE purok = :purok";
$purok13_BStatement = $pdo->prepare($purok13_BChart);
$purok13_BStatement->bindValue(':purok', 'Purok 13-B');
$purok13_BStatement->execute();
$purok13_B = $purok13_BStatement->fetch(PDO::FETCH_ASSOC);

$purok14Chart = "SELECT COUNT(resident_id) AS 'Purok_14' FROM resident WHERE purok = :purok";
$purok14Statement = $pdo->prepare($purok14Chart);
$purok14Statement->bindValue(':purok', 'Purok 14');
$purok14Statement->execute();
$purok14 = $purok14Statement->fetch(PDO::FETCH_ASSOC);

$purok15Chart = "SELECT COUNT(resident_id) AS 'Purok_15' FROM resident WHERE purok = :purok";
$purok15Statement = $pdo->prepare($purok15Chart);
$purok15Statement->bindValue(':purok', 'Purok 15');
$purok15Statement->execute();
$purok15 = $purok15Statement->fetch(PDO::FETCH_ASSOC);

$purok16Chart = "SELECT COUNT(resident_id) AS 'Purok_16' FROM resident WHERE purok = :purok";
$purok16Statement = $pdo->prepare($purok16Chart);
$purok16Statement->bindValue(':purok', 'Purok 16');
$purok16Statement->execute();
$purok16 = $purok16Statement->fetch(PDO::FETCH_ASSOC);

$puroklower16Chart = "SELECT COUNT(resident_id) AS 'Purok_Lower_16' FROM resident WHERE purok = :purok";
$puroklower16Statement = $pdo->prepare($puroklower16Chart);
$puroklower16Statement->bindValue(':purok', 'Purok Lower 16');
$puroklower16Statement->execute();
$puroklower16 = $puroklower16Statement->fetch(PDO::FETCH_ASSOC);

$purokupper16Chart = "SELECT COUNT(resident_id) AS 'Purok_Upper_16' FROM resident WHERE purok = :purok";
$purokupper16Statement = $pdo->prepare($purokupper16Chart);
$purokupper16Statement->bindValue(':purok', 'Purok Upper 16');
$purokupper16Statement->execute();
$purokupper16 = $purokupper16Statement->fetch(PDO::FETCH_ASSOC);

$purok17_AChart = "SELECT COUNT(resident_id) AS 'Purok_17_A' FROM resident WHERE purok = :purok";
$purok17_AStatement = $pdo->prepare($purok17_AChart);
$purok17_AStatement->bindValue(':purok', 'Purok 17-A');
$purok17_AStatement->execute();
$purok17_A = $purok17_AStatement->fetch(PDO::FETCH_ASSOC);

$purok17_BChart = "SELECT COUNT(resident_id) AS 'Purok_17_B' FROM resident WHERE purok = :purok";
$purok17_BStatement = $pdo->prepare($purok17_BChart);
$purok17_BStatement->bindValue(':purok', 'Purok 17-B');
$purok17_BStatement->execute();
$purok17_B = $purok17_BStatement->fetch(PDO::FETCH_ASSOC);

$purok18Chart = "SELECT COUNT(resident_id) AS 'Purok_18' FROM resident WHERE purok = :purok";
$purok18Statement = $pdo->prepare($purok18Chart);
$purok18Statement->bindValue(':purok', 'Purok 18');
$purok18Statement->execute();
$purok18 = $purok18Statement->fetch(PDO::FETCH_ASSOC);

$purok19Chart = "SELECT COUNT(resident_id) AS 'Purok_19' FROM resident WHERE purok = :purok";
$purok19Statement = $pdo->prepare($purok19Chart);
$purok19Statement->bindValue(':purok', 'Purok 19');
$purok19Statement->execute();
$purok19 = $purok19Statement->fetch(PDO::FETCH_ASSOC);

$purok20Chart = "SELECT COUNT(resident_id) AS 'Purok_20' FROM resident WHERE purok = :purok";
$purok20Statement = $pdo->prepare($purok20Chart);
$purok20Statement->bindValue(':purok', 'Purok 20');
$purok20Statement->execute();
$purok20 = $purok20Statement->fetch(PDO::FETCH_ASSOC);

$purok21Chart = "SELECT COUNT(resident_id) AS 'Purok_21' FROM resident WHERE purok = :purok";
$purok21Statement = $pdo->prepare($purok21Chart);
$purok21Statement->bindValue(':purok', 'Purok 21');
$purok21Statement->execute();
$purok21 = $purok21Statement->fetch(PDO::FETCH_ASSOC);

$purok22Chart = "SELECT COUNT(resident_id) AS 'Purok_22' FROM resident WHERE purok = :purok";
$purok22Statement = $pdo->prepare($purok22Chart);
$purok22Statement->bindValue(':purok', 'Purok 22');
$purok22Statement->execute();
$purok22 = $purok22Statement->fetch(PDO::FETCH_ASSOC);

$purok23Chart = "SELECT COUNT(resident_id) AS 'Purok_23' FROM resident WHERE purok = :purok";
$purok23Statement = $pdo->prepare($purok23Chart);
$purok23Statement->bindValue(':purok', 'Purok 23');
$purok23Statement->execute();
$purok23 = $purok23Statement->fetch(PDO::FETCH_ASSOC);

$purok24Chart = "SELECT COUNT(resident_id) AS 'Purok_24' FROM resident WHERE purok = :purok";
$purok24Statement = $pdo->prepare($purok24Chart);
$purok24Statement->bindValue(':purok', 'Purok 24');
$purok24Statement->execute();
$purok24 = $purok24Statement->fetch(PDO::FETCH_ASSOC);

$purok25Chart = "SELECT COUNT(resident_id) AS 'Purok_25' FROM resident WHERE purok = :purok";
$purok25Statement = $pdo->prepare($purok25Chart);
$purok25Statement->bindValue(':purok', 'Purok 25');
$purok25Statement->execute();
$purok25 = $purok25Statement->fetch(PDO::FETCH_ASSOC);

$purok26Chart = "SELECT COUNT(resident_id) AS 'Purok_26' FROM resident WHERE purok = :purok";
$purok26Statement = $pdo->prepare($purok26Chart);
$purok26Statement->bindValue(':purok', 'Purok 26');
$purok26Statement->execute();
$purok26 = $purok26Statement->fetch(PDO::FETCH_ASSOC);

$purok27Chart = "SELECT COUNT(resident_id) AS 'Purok_27' FROM resident WHERE purok = :purok";
$purok27Statement = $pdo->prepare($purok27Chart);
$purok27Statement->bindValue(':purok', 'Purok 27');
$purok27Statement->execute();
$purok27 = $purok27Statement->fetch(PDO::FETCH_ASSOC);

$purok28Chart = "SELECT COUNT(resident_id) AS 'Purok_28' FROM resident WHERE purok = :purok";
$purok28Statement = $pdo->prepare($purok28Chart);
$purok28Statement->bindValue(':purok', 'Purok 28');
$purok28Statement->execute();
$purok28 = $purok28Statement->fetch(PDO::FETCH_ASSOC);

$purok29Chart = "SELECT COUNT(resident_id) AS 'Purok_29' FROM resident WHERE purok = :purok";
$purok29Statement = $pdo->prepare($purok29Chart);
$purok29Statement->bindValue(':purok', 'Purok 29');
$purok29Statement->execute();
$purok29 = $purok29Statement->fetch(PDO::FETCH_ASSOC);


$purok30Chart = "SELECT COUNT(resident_id) AS 'Purok_30' FROM resident WHERE purok = :purok";
$purok30Statement = $pdo->prepare($purok30Chart);
$purok30Statement->bindValue(':purok', 'Purok 30');
$purok30Statement->execute();
$purok30 = $purok30Statement->fetch(PDO::FETCH_ASSOC);
