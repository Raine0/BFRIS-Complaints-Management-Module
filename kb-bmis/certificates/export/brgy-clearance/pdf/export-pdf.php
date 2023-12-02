<?php
define('FPDF_FONTPATH', './../../../../../vendors/FPDF/font/');
require('./../../../../../vendors/FPDF/fpdf.php');
include "./../../../../../db_conn.php";



class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('./../../../../../assets/img/fatima-logo.png', 10, 6, 37);

        // Font
        $this->SetFont('Montserrat-Bold', '', 38);

        // Move to the right
        $this->Cell(68);

        // $this->SetTextColor(217, 185, 62);
        // Title
        $this->Cell(70, 20, 'RESIDENTS', 0, 0, 'C');

        // Font
        $this->SetFont('Montserrat-Regular', '', 14);
        $this->Cell(-60);
        $this->Cell(60, 45, 'Barangay Fatima, General Santos City ', 0, 0, 'C');

        // Line break
        $this->Ln(35);
    }


    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Montserrat-Regular', '', 10);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function createdDate()
    {
        date_default_timezone_set("Asia/Manila");
        $date = date("m/d/Y H:i:s");
        return $date;
    }

    function residentCount()
    {
        require("./../../../../db_conn.php");
        $where = $_GET['msg'];
        $populationSql = "SELECT * FROM residents $where";
        $populationQuery = $conn->query($populationSql);
        $countPopulation = $populationQuery->num_rows;
        return $countPopulation;
    }

    function Date()
    {


        $this->SetFont('Montserrat-Bold', '', 10);
        $this->Cell(220);
        $this->Cell(-408, 14, 'As of ' . $this->createdDate(),  0, 0, 'C');
        $this->Ln(5);
    }

    function TotalResidents()
    {


        $this->SetFont('Montserrat-Bold', '', 10);
        $this->Cell(220);
        $this->Cell(-100, 0, 'Total No. of Resident/s: ' . $this->residentCount(),  0, 0, 'C');
        $this->Ln(5);
    }

    function filter()
    {
        $sex = $_GET['gender'];
        if ("" == $sex) {
            $gender = "";
        } else {
            $gender = "Gender: " . $sex;
        }

        $prk = $_GET['purok'];
        if ("" == $prk) {
            $purok = "";
        } else {
            $purok = "Purok: " . $prk;
        }

        $cv = $_GET['civil_status'];
        if ("" == $cv) {
            $civil_status = "";
        } else {
            $civil_status = "Civil Status: " . $cv;
        }

        if ("" == $_GET['age']) {
            $age = "";
        } else {
            $age = "Age Status: " . $_GET['age'];
        }

        $array = [$gender, $purok, $civil_status, $age];
        $filter = implode('   ', $array);
        $this->SetFont('Montserrat-Regular', '', 8);
        // $this->Cell(0);
        $this->Cell(0, 8, $filter,  0, 0, 'L');
        $this->Ln(4);
    }
    function filter2()
    {
        if ("" == $_GET['voter']) {
            $voter = "";
        } else {
            $voter = "Voter Status: " . $_GET['voter'];
        }

        if ("" == $_GET['vaccine']) {
            $vaccine = "";
        } else {
            $vaccine = "Vaccine Status: " . $_GET['vaccine'];
        }

        $array = [$voter, $vaccine];

        $filter = implode('  ', $array);


        $this->SetFont('Montserrat-Regular', '', 8);
        $this->Cell(0, 10, $filter,  0, 0, 'L');
        $this->Ln(8);
    }



    function TableHeader()
    {

        $width_cell = array(20, 25, 35, 20, 10, 50, 30);
        $this->SetFont('Montserrat-Bold', '', 10);

        //Background color of header//
        $this->SetFillColor(198, 69, 69);
        $this->SetTextColor(255);

        // Header starts /// 

        //First header column //
        $this->Cell($width_cell[0], 9, 'ID', 0, 0, 'C', true);
        //Second header column//
        $this->Cell($width_cell[1], 9, 'LAST NAME', 0, 0, 'C', true);
        $this->Cell($width_cell[2], 9, 'FIRST NAME', 0, 0, 'C', true);
        $this->Cell($width_cell[3], 9, 'MIDDLE NAME', 0, 0, 'C', true);
        $this->Cell($width_cell[4], 9, 'SUFFIX', 0, 0, 'C', true);
        //Third header column//
        $this->Cell($width_cell[5], 9, 'ADDRESS', 0, 0, 'C', true);


        //Third header column//
        $this->Cell($width_cell[6], 9, 'CONTACT NO.', 0, 0, 'C', true);
        //// header ends ///////
        $this->Ln();
    }
}



// Instanciation of inherited class
$pdf = new PDF('P', 'mm', 'A4');

$pdf->AddFont('Montserrat-Regular', '', 'Montserrat-Regular.php');
$pdf->AddFont('Montserrat-Bold', '', 'Montserrat-Bold.php');

$pdf->AddPage();
$pdf->Date();
$pdf->TotalResidents();
$pdf->filter();
$pdf->filter2();
$pdf->TableHeader();

$pdf->AliasNbPages();

$pdf->SetTextColor(0, 0, 0);
$query = "SELECT * FROM residents";
$query_run = mysqli_query($conn, $query);



$width_cell = array(20, 25, 35, 20, 10, 50, 30);
if (mysqli_num_rows($query_run) > 0) {

    foreach ($query_run as $row) {
        $pdf->SetFont('Montserrat-Regular', '', 9);

        $pdf->Cell($width_cell[0], 6, $row['resident_id'], 1, 0, 'C');
        $pdf->Cell($width_cell[1], 6, $row['last_name'], 1, 0, 'L');
        $pdf->Cell($width_cell[2], 6, $row['first_name'], 1, 0, 'L');
        $pdf->Cell($width_cell[3], 6, $row['mid_name'], 1, 0, 'L');
        $pdf->Cell($width_cell[4], 6, $row['suffix'], 1, 0, 'L');
        $pdf->Cell($width_cell[5], 6, $row['purok'] . ", " . $row['street'] . ", " . $row['lot_number'], 1, 0, 'L');
        $pdf->Cell($width_cell[6], 6, $row['phone_number'], 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Montserrat-Regular', '', 11);
    }
}



// The desired filename

date_default_timezone_set("Asia/Manila");
$filename = 'Residents-' . date("Ymd")   . '.pdf';
$pdf->Output($filename, 'D');
