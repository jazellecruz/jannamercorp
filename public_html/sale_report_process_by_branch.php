<?php
$page_title = 'Sales Report By Branch';
$results = '';
  require_once('includes/load.php');
  require('fpdf/fpdf.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
      if(isset($_POST['submit'])){
        $req_dates = array('start-date','end-date');
        validate_fields($req_dates);
    
        if(empty($errors)):
          $start_date   = remove_junk($db->escape($_POST['start-date']));
          $end_date     = remove_junk($db->escape($_POST['end-date']));
          $branch_id     = remove_junk($db->escape($_POST['branch']));
          $results = find_sale_by_dates_and_branch_v2($start_date, $end_date, $branch_id);
          $sales = total_sales_by_branch($start_date, $end_date, $branch_id);
          $sales = $sales->fetch_assoc();
          $branch = find_by_id("branches", $branch_id);
          
        else:
          $session->msg("d", $errors);
          redirect('sales_report.php', false);
        endif;
    
      } else {
        $session->msg("d", "Select dates");
        redirect('sales_report.php', false);
      }
?>

<?php

class PDF extends FPDF {
    private $branch;
    private $quantity;
    private $profit;
    private $grandTotal;

    function header() {
        $this->SetFont('Arial', 'B');
        $this->SetFontSize(16);
        $this->Cell(0, 12, 'SMIS - Sales Report - '. $this->branch .' Branch', 1, 1, 'C');
        $this->Cell(0, 12, '', 1, 1);
    }

    function subHeader() {
        // total page length is 190
        // 
        $this->SetFont('Arial');
        $this->SetFontSize(10);
        //upper subheader
        $this->Cell(0, 9, 'Total Results', 1, 1, 'C');
        $this->Cell(47.5, 9, 'Total Quantity', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->quantity, 1, 0);
        $this->Cell(47.5, 9, 'Grand Total(Pesos)', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->grandTotal, 1, 1);
        // lower subheader
        $this->Cell(47.5, 9, 'Branch Location', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->branch, 1, 0);
        $this->Cell(47.5, 9, 'Profit(Pesos)', 1, 0, 'C');
        $this->Cell(47.5, 9, $this->profit, 1, 1);
        $this->Cell(0, 12, '', 0, 1);
    }

    public function setBranch($branch) {
        $this->branch = $branch;
    }

    public function setTotalQuantity($quantity) {
        $this->quantity = $quantity;
    }

    public function setProfit($profit) {
        $this->profit = $profit;
    }

    public function setGrandTotal($grandTotal) {
        $this->grandTotal = $grandTotal;
    }
}

$pdf = new PDF();
// Setters
$pdf->setBranch((string)$branch['name']);
$pdf->setTotalQuantity($sales['t_sales']);
$pdf->setGrandTotal(number_format(total_price_v2($results)[0], 2));
$pdf->setProfit(number_format(total_price_v2($results)[1], 2) < 0 ? 0 : number_format(total_price_v2($results)[1], 2));
// Config
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->subHeader();
$pdf->SetFont('Times','',10);
$pdf->Cell(27.1428571 * 2, 9, 'Product Name', 1, 0, 'C');
$pdf->Cell(24.1428571, 9, 'SRP(Pesos)', 1, 0, 'C');
$pdf->Cell(30.1428571, 9, 'Selling Price(Pesos)', 1, 0, 'C');
$pdf->Cell(27.1428571, 9, 'Total Qty', 1, 0, 'C');
$pdf->Cell(27.1428571, 9, 'TOTAL', 1, 0, 'C');
$pdf->Cell(27.1428571, 9, 'Date', 1, 1, 'C');

foreach ($results as $result) {
    $pdf->Cell(27.1428571 * 2, 9, $result['name'], 1, 0, 'C');
    $pdf->Cell(24.1428571, 9, $result['buy_price'], 1, 0, 'C');
    $pdf->Cell(30.1428571, 9, $result['sale_price'], 1, 0, 'C');
    $pdf->Cell(27.1428571, 9, $result['total_sales'], 1, 0, 'C');
    $pdf->Cell(27.1428571, 9, $result['total_saleing_price'], 1, 0, 'C');
    $pdf->Cell(27.1428571, 9, $result['date'], 1, 1, 'C');
}

$pdf->Output();
?>