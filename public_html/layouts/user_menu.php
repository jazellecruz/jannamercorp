<ul>
  <li>
    <a href="user_dashboard.php">
      <i class="glyphicon glyphicon-home"></i>
      <span>Dashboard</span>
    </a>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-th-list"></i>
      <span>Sales</span>
    </a>
    <ul class="nav submenu">
      <li><a href="sale_by_branch.php?branch_id=<?= $_SESSION['branch'] ?>">Manage Sales</a> </li>
    </ul>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-signal"></i>
      <span>Sales Report</span>
    </a>
    <ul class="nav submenu">
      <li><a href="sales_report.php">Sales by dates </a></li>
      <li><a href="daily_sales.php">Daily sales</a> </li>
    </ul>
  </li>
  <li>
    <a href="#" class="submenu-toggle">
      <i class="glyphicon glyphicon-th-large"></i>
      <span>Products</span>
    </a>
    <ul class="nav submenu">
       <li><a href="monthly_products.php">Inventory Report</a> </li>
       <li><a href="product_sold_by_branch.php">Products Sold</a> </li>
   </ul>
  </li>
</ul>