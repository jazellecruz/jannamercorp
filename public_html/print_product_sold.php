<?php
$page_title = 'Monthly Products Sold';
$results = '';
  require_once('includes/load.php');
  require('fpdf/fpdf.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);

?>
<?php
if(isset($_POST['get_products_sold'])){
  $req_field = array('start-date', 'end-date', 'branch_id');
  validate_fields($req_field);
  $start_date = remove_junk($db->escape($_POST['start-date']));
  $end_date = remove_junk($db->escape($_POST['end-date']));
  $branch_id = remove_junk($db->escape($_POST['branch_id']));
  if(empty($errors)) {
   $branch = find_by_id('branches', $branch_id);
   $products = find_products_sold_by_date_and_branch($start_date, $end_date, $branch_id);
   $products_sold = total_sales_by_branch($start_date, $end_date, $branch_id);
   $products_sold = $products_sold->fetch_assoc();
  } else {
    $session->msg("d", $errors);
    redirect('product_sold.php',false);
  }
}
?>

<?php

class PDF extends FPDF {
    private $branch;
    private $products_sold;

    function header() {
        $this->SetFont('Arial', 'B');
        $this->SetFontSize(16);
        $this->Cell(0, 12, 'SMIS - Inventory Report - '. $this->branch .' Branch', 1, 1, 'C');
        $this->Cell(0, 12, '', 1, 1);
    }

    function subHeader() {
        // total page length is 190
        // 
        $this->SetFont('Arial');
        $this->SetFontSize(10);
        //upper subheader
        $this->Cell(0, 9, 'Total Results', 1, 1, 'C');
        $this->Cell(47.5, 9, 'Products Sold', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->products_sold, 1, 0, 'C');
        $this->Cell(47.5, 9, 'Branch Location', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->branch, 1, 1, 'C');
        $this->Cell(0, 9, '', 1, 1, 'C');
    }

    public function setBranch($branch) {
        $this->branch = $branch;
    }

    public function setProductsSold($products_sold) {
        $this->products_sold = $products_sold;
    }
}

$pdf = new PDF();
// Setters
$pdf->setBranch((string)$branch['name']);
$pdf->setProductsSold($products_sold['t_sales']);
// Config
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->subHeader();
$pdf->SetFont('Times','',10);
$pdf->Cell(63, 9, 'Product Name', 1, 0, 'C');
$pdf->Cell(32, 9, 'Products Sold', 1, 0, 'C');
$pdf->Cell(32, 9, 'Remaining Products', 1, 0, 'C');
$pdf->Cell(63, 9, 'Date Sold', 1, 1, 'C');

while ($product = $products->fetch_assoc()) {
    $pdf->Cell(63, 9, $product['name'], 1, 0, 'C');
    $pdf->Cell(32, 9, $product['qty'], 1, 0, 'C');
    $pdf->Cell(32, 9, $product['quantity'], 1, 0, 'C');
    $pdf->Cell(63, 9, $product['date'] != null ? date('Y-m-d', strtotime($product['date_added'])) : date('Y-m-d', strtotime($product['date'])), 1, 1, 'C');
}

$pdf->Output();
?>