<?php
// total barangay clearance per week
$totalweekClearance = "SELECT COUNT(brgy_clearance_id) AS WeeklyBrgyClearanceTotal FROM brgy_clearance_view WHERE date(date_issued) > DATE_SUB(NOW(), INTERVAL 1 WEEK)";
$totalweekStatement = $pdo->query($totalweekClearance);
$weeklyClearance = $totalweekStatement->fetch(PDO::FETCH_ASSOC);


// total business clearance per week
// $totalWeekBusinessClrQuery = mysqli_query($conn, "SELECT COUNT(id) AS weeklyBusTotal FROM `business_clearance` WHERE date(date_issued) > DATE_SUB(NOW(), INTERVAL 1 WEEK)");
// $total_WeekBusinessClr = mysqli_fetch_array($totalWeekBusinessClrQuery);




// total barangay clearance per month

$totalmonthClearance = "SELECT MONTHNAME(date_issued) AS Month,
COUNT(brgy_clearance_id) AS MonthlyBrgyClearanceTotal,
(SELECT COUNT(brgy_clearance_id) FROM brgy_clearance_view WHERE YEAR(date_issued) = YEAR(CURRENT_DATE) AND date_issued <= CURRENT_DATE) AS TotalBrgyClearanceGenerated
FROM brgy_clearance_view
WHERE YEAR(date_issued) = YEAR(CURRENT_DATE)
GROUP BY Month";
$totalmonthStatement = $pdo->query($totalmonthClearance);
$monthlyClearance = $totalmonthStatement->fetch(PDO::FETCH_ASSOC);


// total business clearance per month
// $totalMonthBusinessClrQuery = mysqli_query($conn, "SELECT COUNT(ID) AS monthlyBusTotal FROM `business_clearance` WHERE MONTHNAME(date_issued) = MONTHNAME(CURRENT_DATE)");
// $total_MonthBusinessClr  = mysqli_fetch_array($totalMonthBusinessClrQuery);




// total barangay clearance per year
$totalyearClearance = "SELECT COUNT(brgy_clearance_id) AS YearlyBrgyClearanceTotal FROM brgy_clearance_view WHERE YEAR(date_issued) = YEAR(CURRENT_DATE)";

$totalyearStatement = $pdo->query($totalyearClearance);
$yearlyClearance = $totalyearStatement->fetch(PDO::FETCH_ASSOC);

// total business clearance per year
// $totalYearBusinessClrQuery = mysqli_query($conn, "SELECT COUNT(id) AS yearlyBusTotal FROM `business_clearance` WHERE YEAR(date_issued) = YEAR(CURRENT_DATE)");
// $total_YearBusinessClr = mysqli_fetch_array($totalYearBusinessClrQuery);
