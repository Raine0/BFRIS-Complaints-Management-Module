<?php
define('FPDF_FONTPATH', './../../../../../vendors/FPDF/font/');
require('./../../../../../vendors/FPDF/fpdf.php');
include "./../../../../../db_conn.php";



class PDF extends FPDF
{
    // Page header
    function Header()
    {
        if ($this->pageNo() === 1) {
            // Logo
            $this->Image('./../../../../../assets/img/fatima-logo.png', 30, 10, 30);
            // Font
            $this->SetFont('Montserrat-Bold', '', 40);

            // Move to the right
            $this->Cell(75);

            // $this->SetTextColor(217, 185, 62);
            // Title
            $this->Cell(140, 30, 'GOOD MORAL', 0, 0, 'C');

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

    function goodmoralCount()
    {
        require("./../../../../../db_conn.php");
        $goodmoralQuery = "SELECT * FROM good_moral_certificate";
        $goodmoralStatement = $pdo->query($goodmoralQuery);
        $goodmoralStatement->fetchAll(PDO::FETCH_ASSOC);
        $goodmoralCount = $goodmoralStatement->rowCount();
        return $goodmoralCount;
    }


    function totalGoodmoral()
    {
        $this->SetFont('Montserrat-Bold', '', 10);
        $this->Cell(210);
        $this->Cell(0, -20, 'Total Good Moral Generated: ' .  $this->goodmoralCount(), 0, 0, 'C');
        $this->Ln(3);
    }

    function TableHeader()
    {

        $width_cell = array(15, 60, 50, 60, 55, 35);
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
        $this->Cell($width_cell[3], 10, 'ADDRESS', 0, 0, 'C', true);
        $this->Cell($width_cell[4], 10, 'ISSUED BY', 0, 0, 'C', true);
        $this->Cell($width_cell[5], 10, 'DATE ISSUED', 0, 0, 'C', true);


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

$pdf->totalGoodmoral();

$pdf->Date();

$pdf->TableHeader();

$pdf->AliasNbPages();

$pdf->SetTextColor(0, 0, 0);


$goodmoralQuery2 = "SELECT * FROM good_moral_certificate_view";

$goodmoralStatement2 = $pdo->query($goodmoralQuery2);
$goodmorals = $goodmoralStatement2->fetchAll(PDO::FETCH_ASSOC);
$clearancCount2 = $goodmoralStatement2->rowCount();

$width_cell = array(15, 60, 50, 60, 55, 35);
if ($clearancCount2 > 0) {

    foreach ($goodmorals as $goodmoral) {
        $pdf->SetFont('Montserrat-Regular', '', 8);

        $pdf->Cell($width_cell[0], 10, $goodmoral['good_moral_id'], 1, 0, 'C');
        $pdf->Cell($width_cell[1], 10, $goodmoral['resident_name'], 1, 0, 'C');
        $pdf->Cell($width_cell[2], 10, $goodmoral['purpose'], 1, 0, 'C');
        $pdf->Cell($width_cell[3], 10, $goodmoral['address'], 1, 0, 'C');
        $pdf->Cell($width_cell[4], 10, $goodmoral['issued_by'], 1, 0, 'C');
        $pdf->Cell($width_cell[5], 10, date('m-d-Y h:i:s a', strtotime($goodmoral['date_issued'])), 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetFont('Montserrat-Regular', '', 11);
    }
}

$filename = 'Fatima-Good-Moral (' . date("m-d-Y") . ').pdf';
$pdf->Output($filename, 'I');
