<?php
define('FPDF_FONTPATH', './../../../../../vendors/FPDF/font/');
require('./../../../../../vendors/FPDF/fpdf.php');
include "./../../../../../db_conn.php";



class PDF extends FPDF
{
    // Page header
    function Header()
    {
        if ($this->PageNo() === 1) {
            // Logo
            $this->Image('./../../../../../assets/img/fatima-logo.png', 30, 10, 30);
            // Font
            $this->SetFont('Montserrat-Bold', '', 40);

            // Move to the right
            $this->Cell(75);

            // $this->SetTextColor(217, 185, 62);
            // Title
            $this->Cell(140, 30, 'BARANGAY CLEARANCE', 0, 0, 'C');

            // Font
            $this->SetFont('Montserrat-Regular', '', 14);
            $this->Cell(-75);
            $this->Cell(11, 50, 'Barangay Fatima, General Santos City ', 0, 0, 'C');

            $this->SetDrawColor(198, 69, 69);
            $this->SetLineWidth(2);
            $this->Line(102, 40, 225 - 20, 40);

            // Line break
            $this->Ln(50);
        }
    }

    function createdDate()
    {
        date_default_timezone_set("Asia/Manila");
        $date = date("m-d-Y h:i:s A");
        return $date;
    }

    function Date()
    {
        $this->SetFont('Montserrat-Bold', '', 10);
        $this->Cell(210);
        $this->Cell(0, -10, 'As of ' . $this->createdDate(),  0, 0, 'C');
        $this->Ln(3);
    }

    function clearanceCount()
    {
        require("./../../../../../db_conn.php");
        $clearanceQuery = "SELECT * FROM barangay_clearance";
        $clearanceStatement = $pdo->query($clearanceQuery);
        $clearanceStatement->fetchAll(PDO::FETCH_ASSOC);
        $clearanceCount = $clearanceStatement->rowCount();
        return $clearanceCount;
    }


    function totalClearance()
    {
        $this->SetFont('Montserrat-Bold', '', 10);
        $this->Cell(210);
        $this->Cell(0, -20, 'Total Brgy. Clearance Generated: ' .  $this->clearanceCount(), 0, 0, 'C');
        $this->Ln(3);
    }

    function TableHeader()
    {

        $width_cell = array(10, 55, 45, 30, 30, 20, 55, 35);
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
        $this->Cell($width_cell[2], 10, 'PURPOSE', 0, 0, 'C', true);


        //Third header column//
        $this->Cell($width_cell[3], 10, 'RECEIPT NO.', 0, 0, 'C', true);
        $this->Cell($width_cell[4], 10, 'CEDULA NO.', 0, 0, 'C', true);
        $this->Cell($width_cell[5], 10, 'FEE', 0, 0, 'C', true);
        $this->Cell($width_cell[6], 10, 'ISSUED BY', 0, 0, 'C', true);
        $this->Cell($width_cell[7], 10, 'DATE ISSUED', 0, 0, 'C', true);


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

$pdf->totalClearance();

$pdf->Date();

$pdf->TableHeader();
$pdf->AliasNbPages();

$pdf->SetTextColor(0, 0, 0);


$clearanceQuery2 = "SELECT * FROM brgy_clearance_view";

$clearanceStatement2 = $pdo->query($clearanceQuery2);
$clearances = $clearanceStatement2->fetchAll(PDO::FETCH_ASSOC);
$clearancCount2 = $clearanceStatement2->rowCount();

$width_cell = array(10, 55, 45, 30, 30, 20, 55, 35);
if ($clearancCount2 > 0) {

    foreach ($clearances as $clearance) {
        $pdf->SetFont('Montserrat-Regular', '', 8);

        $pdf->Cell($width_cell[0], 10, $clearance['brgy_clearance_id'], 1, 0, 'C');
        $pdf->Cell($width_cell[1], 10, $clearance['resident_name'], 1, 0, 'C');
        $pdf->Cell($width_cell[2], 10, $clearance['purpose'], 1, 0, 'C');
        $pdf->Cell($width_cell[3], 10, $clearance['receipt_number'], 1, 0, 'C');
        $pdf->Cell($width_cell[4], 10, $clearance['cedula_number'], 1, 0, 'C');
        $pdf->Cell($width_cell[5], 10, $clearance['fee'], 1, 0, 'C');
        $pdf->Cell($width_cell[6], 10, $clearance['issued_by'], 1, 0, 'C');
        $pdf->Cell($width_cell[7], 10, date('m-d-Y h:i:s a', strtotime($clearance['date_issued'])), 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Montserrat-Regular', '', 11);
    }
}

$filename = 'Fatima-Brgy-Clearance (' . date("m-d-Y") . ').pdf';
$pdf->Output($filename, 'I');
