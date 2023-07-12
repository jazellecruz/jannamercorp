<?php
$page_title = 'Monthly Products';
$results = '';
  require_once('includes/load.php');
  require('fpdf/fpdf.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
if(isset($_POST['get_sales'])){
  $req_field = array('start-date', 'end-date', 'branch_id');
  validate_fields($req_field);
  $start_date = remove_junk($db->escape($_POST['start-date']));
  $end_date = remove_junk($db->escape($_POST['end-date']));
  $branch_id = remove_junk($db->escape($_POST['branch_id']));
  if(empty($errors)){
   $result = find_added_products_by_date($start_date, $end_date, $branch_id);
   $branch = find_by_id('branches', $branch_id);
   $remaining_products = find_all_remaining_products($branch_id);
   $remaining_products = $remaining_products->fetch_assoc();
   $products = find_added_monthly_products_by_date($start_date, $end_date, $branch_id);
   $total_added_products = $result->fetch_assoc();
   $products_sold = total_sales_by_branch($start_date, $end_date, $branch_id);
   $products_sold = $products_sold->fetch_assoc();
  } else {
    $session->msg("d", $errors);
    redirect('monthly_products.php',false);
  }
}
?>

<?php

class PDF extends FPDF {
    private $branch;
    private $total_added_products;
    private $total_remaining_products;
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
        $this->Cell(47.5, 9, 'Total Added Products', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->total_added_products, 1, 0, 'C');
        $this->Cell(47.5, 9, 'Total Remaining Products', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->total_remaining_products, 1, 1, 'C');
        $this->Cell(47.5, 9, 'Products Sold', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->products_sold, 1, 0, 'C');
        $this->Cell(47.5, 9, 'Branch Location', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->branch, 1, 1, 'C');
        $this->Cell(0, 9, '', 1, 1, 'C');
    }

    public function setBranch($branch) {
        $this->branch = $branch;
    }

    public function setTotalAddedProducts($total_added_products) {
        $this->total_added_products = $total_added_products;
    }

    public function setTotalRemainingProducts($total_remaining_products) {
        $this->total_remaining_products = $total_remaining_products;
    }

    public function setProductsSold($products_sold) {
        $this->products_sold = $products_sold;
    }
}

$pdf = new PDF();
// Setters
$pdf->setBranch((string)$branch['name']);
$pdf->setTotalAddedProducts($total_added_products['total_amount']);
$pdf->setTotalRemainingProducts($remaining_products['remaining_products']);
$pdf->setProductsSold($products_sold['t_sales']);
// Config
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->subHeader();
$pdf->SetFont('Times','',10);
$pdf->Cell(63, 9, 'Product Name', 1, 0, 'C');
$pdf->Cell(32, 9, 'Added this month', 1, 0, 'C');
$pdf->Cell(32, 9, 'Remaining Products', 1, 0, 'C');
$pdf->Cell(63, 9, 'Date Added', 1, 1, 'C');

while ($product = $products->fetch_assoc()) {
    
    $pdf->Cell(63, 9, $product['name'], 1, 0, 'C');
    $pdf->Cell(32, 9, $product['amount_added'], 1, 0, 'C');
    $pdf->Cell(32, 9, $product['quantity'], 1, 0, 'C');
    $pdf->Cell(63, 9, $product['date_added'] != null ? date('Y-m-d', strtotime($product['date_added'])) : date('Y-m-d', strtotime($product['date'])), 1, 1, 'C');
}

$pdf->Output();
?>