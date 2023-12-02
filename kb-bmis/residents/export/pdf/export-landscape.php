<?php
define('FPDF_FONTPATH', '../../../../vendors/FPDF/font/');
require('../../../../vendors/FPDF/fpdf.php');
include "../../../../db_conn.php";



class PDF extends FPDF
{
    // Page header
    function Header()
    {

        if ($this->pageNo() === 1) {
            // Logo
            $this->Image('../../../../assets/img/fatima-logo.png', 40, 6, 40);

            // Font
            $this->SetFont('Montserrat-Bold', '', 40);

            // Move to the right
            $this->Cell(80);

            // $this->SetTextColor(217, 185, 62);
            // Title
            $this->Cell(140, 30, 'RESIDENTS', 0, 0, 'C');

            // Font
            $this->SetFont('Montserrat-Regular', '', 14);
            $this->Cell(-75);
            $this->Cell(11, 60, 'Barangay Fatima, General Santos City ', 0, 0, 'C');

            $this->SetDrawColor(198, 69, 69);
            $this->SetLineWidth(2);
            $this->Line(102, 45, 240 - 20, 45);

            // Line break
            $this->Ln(50);
        }
    }

    function createdDate()
    {
        date_default_timezone_set("Asia/Manila");
        $date = date("m-d-Y h:i:s a");
        return $date;
    }

    function Date()
    {


        $this->SetFont('Montserrat-Bold', '', 10);
        $this->Cell(220);
        $this->Cell(0, 0, 'As of ' . $this->createdDate(),  0, 0, 'C');
        $this->Ln(6);
    }

    function residentCount()
    {
        require("../../../../db_conn.php");
        $residentQuery = "SELECT * FROM resident";
        $residentStatement = $pdo->query($residentQuery);
        $residentCount = $residentStatement->rowCount();

        return $residentCount;
    }


    function totalResidents()
    {

        // $populationSql =  mysqli_query($conn, "SELECT count(id) FROM residents");
        // $w = mysqli_fetch_array($populationSql);

        $this->SetFont('Montserrat-Bold', '', 10);
        $this->Cell(220);
        $this->Cell(0, 0, 'Total No. of Residents: ' .  $this->residentCount(), 0, 0, 'C');
        $this->Ln(6);
    }

    function TableHeader()
    {

        $width_cell = array(20, 95, 105, 55);
        $this->SetFont('Montserrat-Bold', '', 10);

        //Background color of header//
        $this->SetFillColor(198, 69, 69);
        $this->SetTextColor(255);

        // Header starts /// 

        //First header column //
        $this->Cell($width_cell[0], 10, 'ID', 0, 0, 'C', true);
        //Second header column//
        $this->Cell($width_cell[1], 10, 'RESIDENT NAME', 0, 0, 'C', true);
        //Third header column//
        $this->Cell($width_cell[2], 10, 'ADDRESS', 0, 0, 'C', true);


        //Third header column//
        $this->Cell($width_cell[3], 10, 'CONTACT NO.', 0, 0, 'C', true);


        //// header ends ///////
        $this->Ln();
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
}



// Instanciation of inherited class
$pdf = new PDF('L', 'mm', 'A4');

$pdf->AddFont('Montserrat-Regular', '', 'Montserrat-Regular.php');
$pdf->AddFont('Montserrat-Bold', '', 'Montserrat-Bold.php');

$pdf->AddPage();

$pdf->totalResidents();

$pdf->Date();

$pdf->TableHeader();

$pdf->AliasNbPages();

$pdf->SetTextColor(0, 0, 0);


$residentQuery = "SELECT * FROM resident";
$residentStatement = $pdo->query($residentQuery);
$residentCount = $residentStatement->rowCount();

$width_cell = array(20, 95, 105, 55);
if ($residentCount > 0) {
    $residents = $residentStatement->fetchAll(PDO::FETCH_ASSOC);

    foreach ($residents as $resident) {
        $pdf->SetFont('Montserrat-Regular', '', 8);

        $pdf->Cell($width_cell[0], 10, $resident['resident_id'], 1, 0, 'C');
        $pdf->Cell($width_cell[1], 10, $resident['last_name'] . ", " . $resident['first_name'] . " " . $resident['mid_name'] . " " . $resident['suffix'], 1, 0, 'C');
        $pdf->Cell($width_cell[2], 10, $resident['lot_number'] . ", " . $resident['purok'] . ", " . $resident['street'], 1, 0, 'C');
        $pdf->Cell($width_cell[3], 10, $resident['phone_number'], 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Montserrat-Regular', '', 11);
    }
}

date_default_timezone_set("Asia/Manila");
$filename = 'Fatima-Residents (' . date('m-d-Y') . ').pdf';
$pdf->Output($filename, 'I');
