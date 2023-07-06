<?php
require_once './../../config.php';
require_once './../../functions.php';
require_once 'fpdf/fpdf.php'; 

$pdf = new FPDF('L', 'mm', 'A4');

// Add a page
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 18); 

// Add header
$pdf->Cell(0, 15, 'KOPERASI SMPN 2 CISITU', 0, 1, 'C'); 
$pdf->Cell(0, 10, 'DATA PESANAN PRODUK', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 14); 
$pdf->Cell(35, 10, 'No. Invoice', 1, 0, 'C');
$pdf->Cell(60, 10, 'Nama', 1, 0, 'C');
$pdf->Cell(50, 10, 'Email', 1, 0, 'C');
$pdf->Cell(30, 10, 'No HP', 1, 0, 'C');
$pdf->Cell(60, 10, 'Total Pembayaran', 1, 0, 'C'); 
$pdf->Cell(40, 10, 'Tanggal', 1, 1, 'C'); 

// Set table data
$pdf->SetFont('Arial', '', 10);
$orders = getOrders();
foreach ($orders as $order) {
  $pdf->Cell(35, 10, $order['no_invoice'], 1, 0, 'C');
  $pdf->Cell(60, 10, $order['nama_siswa'], 1, 0, 'C');
  $pdf->Cell(50, 10, $order['email'], 1, 0, 'C');
  $pdf->Cell(30, 10, $order['no_hp'], 1, 0, 'C');
  $pdf->Cell(60, 10, number_format($order['total'] , 0, ',', '.'), 1, 0, 'C'); 
  $pdf->Cell(40, 10, $order['tgl_order'], 1, 1, 'C'); 
}

$pdf->Output('semua_data_order.pdf', 'D');
