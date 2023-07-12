<?php
  require_once('includes/load.php');
  error_reporting(E_ERROR | E_PARSE);

/*--------------------------------------------------------------*/
/* Function for find all database table rows by table name
/*--------------------------------------------------------------*/
function find_all($table) {
   global $db;
   if(tableExists($table))
   {
     return find_by_sql("SELECT * FROM ".$db->escape($table));
   }
}
/*--------------------------------------------------------------*/
/* Function for Perform queries
/*--------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
 return $result_set;
}
/*--------------------------------------------------------------*/
/*  Function for Find data from table by id
/*--------------------------------------------------------------*/
function find_by_id($table,$id)
{
  global $db;
  $id = (int)$id;
    if(tableExists($table)){
          $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE id='{$db->escape($id)}' LIMIT 1");
          if($result = $db->fetch_assoc($sql))
            return $result;
          else
            return null;
     }
}
/*--------------------------------------------------------------*/
/* Function for Delete data from table by id
/*--------------------------------------------------------------*/
function delete_by_id($table,$id)
{
  global $db;
  if(tableExists($table))
   {
    $sql = "DELETE FROM ".$db->escape($table);
    $sql .= " WHERE id=". $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
   }
}
/*--------------------------------------------------------------*/
/* Function for Count id  By table name
/*--------------------------------------------------------------*/

function count_by_id($table){
  global $db;
  if(tableExists($table))
  {
    $sql    = "SELECT COUNT(id) AS total FROM ".$db->escape($table);
    $result = $db->query($sql);
     return($db->fetch_assoc($result));
  }
}
/*--------------------------------------------------------------*/
/* Determine if database table exists
/*--------------------------------------------------------------*/
function tableExists($table){
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM '.DB_NAME.' LIKE "'.$db->escape($table).'"');
      if($table_exit) {
        if($db->num_rows($table_exit) > 0)
              return true;
         else
              return false;
      }
  }
 /*--------------------------------------------------------------*/
 /* Login with the data provided in $_POST,
 /* coming from the login form.
/*--------------------------------------------------------------*/
  function authenticate($username='', $password='', $branch_id='') {
    global $db;
    $username = $db->escape($username);
    $password = $db->escape($password);
    $branch_id = (int)$db->escape($branch_id);
    $sql  = sprintf("SELECT u.id, u.username, u.password, u.user_level, b.id as branch FROM users u INNER JOIN branches b ON b.id = u.branch_id WHERE u.username ='%s' AND u.branch_id = '%d' LIMIT 1", $username, $branch_id);
    $result = $db->query($sql);
    if($db->num_rows($result)){
      $user = $db->fetch_assoc($result);
      $password_request = sha1($password);
      if($password_request === $user['password'] ){
        return array($user['id'], $user['user_level'], $user['branch']);
      }
    }
   return false;
  }
  /*--------------------------------------------------------------*/
  /* Login with the data provided in $_POST,
  /* coming from the login_v2.php form.
  /* If you used this method then remove authenticate function.
 /*--------------------------------------------------------------*/
   function authenticate_v2($username='', $password='', $branch_id='') {
     global $db;
     $username = $db->escape($username);
     $password = $db->escape($password);
     $branch_id = (int)$db->escape($branch_id);
     $sql  = sprintf("SELECT u.id, u.username, u.password, u.user_level, b.id as branch FROM users u INNER JOIN branches b ON b.id = u.branch_id WHERE u.username ='%s' AND u.branch_id = '%d' LIMIT 1", $username, $branch_id);
     $result = $db->query($sql);
     if($db->num_rows($result)){
       $user = $db->fetch_assoc($result);
       $password_request = sha1($password);
       if($password_request === $user['password'] ){
        return array($user['id'], $user['user_level'], $user['branch']);
       }
     }
    return false;
   }


  /*--------------------------------------------------------------*/
  /* Find current log in user by session id
  /*--------------------------------------------------------------*/
  function current_user(){
      static $current_user;
      global $db;
      if(!$current_user){
         if(isset($_SESSION['user_id'])):
             $user_id = intval($_SESSION['user_id']);
             $current_user = find_by_id('users',$user_id);
        endif;
      }
    return $current_user;
  }
  /*--------------------------------------------------------------*/
  /* Find all user by
  /* Joining users table and user gropus table
  /*--------------------------------------------------------------*/
  function find_all_user(){
      global $db;
      $results = array();
      $sql = "SELECT u.id,u.name,u.username,u.user_level,u.status,u.last_login, b.name AS branch, ";
      $sql .="g.group_name ";
      $sql .="FROM users u ";
      $sql .="LEFT JOIN user_groups g ";
      $sql .="ON g.group_level=u.user_level ";
      $sql .="LEFT JOIN branches b ";
      $sql .="ON b.id=u.branch_id ";
      $sql .=" ORDER BY u.name ASC";
      $result = find_by_sql($sql);
      return $result;
  }
  /*--------------------------------------------------------------*/
  /* Function to update the last log in of a user
  /*--------------------------------------------------------------*/

 function updateLastLogIn($user_id)
	{
		global $db;
    $date = make_date();
    $sql = "UPDATE users SET last_login='{$date}' WHERE id ='{$user_id}' LIMIT 1";
    $result = $db->query($sql);
    return ($result && $db->affected_rows() === 1 ? true : false);
	}

  /*--------------------------------------------------------------*/
  /* Find all Group name
  /*--------------------------------------------------------------*/
  function find_by_groupName($val)
  {
    global $db;
    $sql = "SELECT group_name FROM user_groups WHERE group_name = '{$db->escape($val)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Find group level
  /*--------------------------------------------------------------*/
  function find_by_groupLevel($level)
  {
    global $db;
    $sql = "SELECT group_level FROM user_groups WHERE group_level = '{$db->escape($level)}' LIMIT 1 ";
    $result = $db->query($sql);
    return($db->num_rows($result) === 0 ? true : false);
  }
  /*--------------------------------------------------------------*/
  /* Function for cheaking which user level has access to page
  /*--------------------------------------------------------------*/
   function page_require_level($require_level){
     global $session;
     $current_user = current_user();
     $login_level = find_by_groupLevel($current_user['user_level']);
     //if user not login
     if (!$session->isUserLoggedIn(true)):
            $session->msg('d','Please login...');
            redirect('index.php', false);
      //if Group status Deactive
     elseif($login_level['group_status'] === '0'):
           $session->msg('d','This level user has been band!');
           redirect('home.php',false);
      //cheackin log in User level and Require level is Less than or equal to
     elseif($current_user['user_level'] <= (int)$require_level):
              return true;
      else:
            $session->msg("d", "Sorry! you dont have permission to view the page.");
            redirect('home.php', false);
        endif;

     }
   /*--------------------------------------------------------------*/
   /* Function for Finding all product name
   /* JOIN with categorie  and media database table
   /*--------------------------------------------------------------*/
  function join_product_table(){
     global $db;
     $sql  =" SELECT p.id,p.name,p.quantity,p.buy_price,p.sale_price,p.media_id,p.date,c.name";
    $sql  .=" AS categorie,m.file_name AS image";
    $sql  .=" FROM products p";
    $sql  .=" LEFT JOIN categories c ON c.id = p.categorie_id";
    $sql  .=" LEFT JOIN media m ON m.id = p.media_id";
    $sql  .=" ORDER BY p.id ASC";
    return find_by_sql($sql);

   }
  /*--------------------------------------------------------------*/
  /* Function for Finding all product name
  /* Request coming from ajax.php for auto suggest
  /*--------------------------------------------------------------*/

   function find_product_by_title($product_name){
     global $db;
     $p_name = remove_junk($db->escape($product_name));
     $sql = "SELECT name FROM products WHERE name like '%$p_name%' LIMIT 5";
     $result = find_by_sql($sql);
     return $result;
   }

  /*--------------------------------------------------------------*/
  /* Function for Finding all product info by product title
  /* Request coming from ajax.php
  /*--------------------------------------------------------------*/
  function find_all_product_info_by_title($title){
    global $db;
    $sql  = "SELECT * FROM products ";
    $sql .= " WHERE name ='{$title}'";
    $sql .=" LIMIT 1";
    return find_by_sql($sql);
  }

  /*--------------------------------------------------------------*/
  /* Function for Update product quantity
  /*--------------------------------------------------------------*/
  function update_product_qty($qty,$p_id){
    global $db;
    $qty = (int) $qty;
    $id  = (int)$p_id;
    $sql = "UPDATE products SET quantity=quantity -'{$qty}' WHERE id = '{$id}'";
    $result = $db->query($sql);
    return($db->affected_rows() === 1 ? true : false);

  }
  /*--------------------------------------------------------------*/
  /* Function for Display Recent product Added
  /*--------------------------------------------------------------*/
 function find_recent_product_added($limit){
   global $db;
   $sql   = " SELECT p.id,p.name,p.sale_price,p.media_id,c.name AS categorie,";
   $sql  .= "m.file_name AS image FROM products p";
   $sql  .= " LEFT JOIN categories c ON c.id = p.categorie_id";
   $sql  .= " LEFT JOIN media m ON m.id = p.media_id";
   $sql  .= " ORDER BY p.id DESC LIMIT ".$db->escape((int)$limit);
   return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Find Highest saleing Product
 /*--------------------------------------------------------------*/
 function find_higest_saleing_product($limit){
   global $db;
   $sql  = "SELECT p.name, COUNT(s.product_id) AS totalSold, SUM(s.qty) AS totalQty";
   $sql .= " FROM sales s";
   $sql .= " LEFT JOIN products p ON p.id = s.product_id ";
   $sql .= " GROUP BY s.product_id";
   $sql .= " ORDER BY SUM(s.qty) DESC LIMIT ".$db->escape((int)$limit);
   return $db->query($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for find all sales
 /*--------------------------------------------------------------*/
 function find_all_sale() {
  global $db;
  $sql  = "SELECT s.id,SUM(s.price) AS price,s.date,p.name, SUM(s.qty) as qty, b.name AS branch";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " LEFT JOIN branches b ON b.id = p.branch_id";
  $sql .= " GROUP BY p.name";
  $sql .= " ORDER BY s.date DESC";
  return find_by_sql($sql);
 }
 /*--------------------------------------------------------------*/
 /* Function for Display Recent sale
 /*--------------------------------------------------------------*/
function find_recent_sale_added($limit){
  global $db;
  $sql  = "SELECT s.id,s.qty,s.price,s.date,p.name";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " ORDER BY s.date DESC LIMIT ".$db->escape((int)$limit);
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates
/*--------------------------------------------------------------*/
function find_sale_by_dates($start_date,$end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  $sql .= " GROUP BY DATE(s.date),p.name";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Daily sales report
/*--------------------------------------------------------------*/
function  dailySales($year,$month){
  global $db;
  $sql  = "SELECT SUM(s.qty) AS qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(s.price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y-%m' ) = '{$year}-{$month}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%e' ),s.product_id";
  return find_by_sql($sql);
}
/*--------------------------------------------------------------*/
/* Function for Generate Monthly sales report
/*--------------------------------------------------------------*/
function  monthlySales($year){
  global $db;
  $sql  = "SELECT s.qty,";
  $sql .= " DATE_FORMAT(s.date, '%Y-%m-%e') AS date,p.name,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price";
  $sql .= " FROM sales s";
  $sql .= " LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " WHERE DATE_FORMAT(s.date, '%Y' ) = '{$year}'";
  $sql .= " GROUP BY DATE_FORMAT( s.date,  '%c' ),s.product_id";
  $sql .= " ORDER BY date_format(s.date, '%c' ) ASC";
  return find_by_sql($sql);
}

function total_sales($start_date, $end_date){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql = "SELECT SUM(s.qty) AS t_sales FROM sales s LEFT JOIN products p ON s.product_id = p.id WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}'";
  return $db->query($sql);
}

function total_sales_by_branch($start_date, $end_date, $branch_id){
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $branch_id = $db->escape($branch_id);
  $sql = "SELECT SUM(s.qty) AS t_sales FROM sales s INNER JOIN products p ON p.id = s.product_id WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}' AND p.branch_id = '{$branch_id}'";
  return $db->query($sql);
}

function find_users_by_branch($branch_id) {
   global $db;
   $branch_id = $db->escape($branch_id);
   $sql = "SELECT u.id, u.name, u.username, u.user_level, u.status, b.name as branch, b.location as location, ug.group_name";
   $sql .= " FROM users u INNER JOIN branches b ON b.id = u.branch_id"; 
   $sql .= " INNER JOIN user_groups ug ON ug.group_level = u.user_level";
   $sql .= " WHERE u.branch_id = '{$branch_id}'";
   return find_by_sql($sql);
}

function find_products_by_branch($branch_id) {
  global $db;
  $branch_id = $db->escape($branch_id);
  $sql = "SELECT p.id, p.name as product, p.quantity, p.buy_price, p.sale_price, p.date, b.name as branch, b.location as location, c.name as category, p.media_id, m.file_name as image";
  $sql .= " FROM products p";
  $sql .= " INNER JOIN branches b ON b.id = p.branch_id"; 
  $sql .= " INNER JOIN categories c ON c.id = p.categorie_id"; 
  $sql .= " LEFT JOIN media m ON m.id = p.media_id"; 
  $sql .= " WHERE p.branch_id = '{$branch_id}'";
  $sql .= " AND p.quantity > 0";
  return find_by_sql($sql);
}

function find_sales_by_branch($branch_id) {
  global $db;
  $branch_id = $db->escape($branch_id);
  $sql = "SELECT SUM(s.qty) AS qty, SUM(s.price) AS price, s.date, p.name, s.id, b.name as branch, b.location";
  $sql .= " FROM sales s";  
  $sql .= " INNER JOIN products p ON p.id = s.product_id";
  $sql .= " INNER JOIN branches b ON b.id = p.branch_id"; 
  $sql .= " WHERE p.branch_id = '{$branch_id}'";
  $sql .= " GROUP BY s.product_id";
  return find_by_sql($sql);
}

/*--------------------------------------------------------------*/
/* Function for Generate sales report by two dates and by branch
/*--------------------------------------------------------------*/
function find_sale_by_dates_and_branch($start_date, $end_date, $branch_id){
  global $db;
  $branch_id = $db->escape($branch_id);
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,b.name as branch, b.location,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(p.sale_price * s.qty) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " LEFT JOIN branches b ON p.branch_id = b.id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}' AND p.branch_id = '{$branch_id}'";
  $sql .= " GROUP BY DATE(s.date), p.name, s.product_id";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}

function find_added_products_by_date($start_date,$end_date, $branch_id) {
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql = "SELECT SUM(mp.amount_added) AS total_amount FROM monthly_products mp INNER JOIN products p ON mp.mp_id = p.id WHERE mp.date_added BETWEEN '{$start_date}' AND '{$end_date}' AND p.branch_id = '{$branch_id}'";
  return $db->query($sql);
}

function find_all_remaining_products($branch_id) {
  global $db;
  $branch_id = $db->escape((int)$branch_id);
  $sql = "SELECT SUM(p.quantity) AS remaining_products FROM products p INNER JOIN branches b ON b.id = p.branch_id WHERE p.branch_id = '{$branch_id}'";
  return $db->query($sql);
}

function getMonthlyProductId($product_id) {
  global $db;
  $product_id = $db->escape((int)$product_id);
  $sql = "SELECT mp_id FROM monthly_products WHERE mp_id = '{$product_id}'";
  return $db->query($sql);
}

// query conflict
function find_added_monthly_products_by_date($start_date, $end_date, $branch_id) {
  global $db;
  $branch_id = $db->escape((int)$branch_id);
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql = "SELECT p.name, p.quantity, p.date, mp.amount_added, mp.date_added FROM products p INNER JOIN monthly_products mp ON mp.mp_id = p.id WHERE p.branch_id = '{$branch_id}' AND mp.date_added BETWEEN '{$start_date}' AND '{$end_date}' GROUP BY p.id";
  return $db->query($sql);
}

// query conflict
function find_added_monthly_products($branch_id) {
  global $db;
  $branch_id = $db->escape((int)$branch_id);
  $sql = "SELECT p.id, p.name, p.quantity, p.date, mp.amount_added, mp.date_added FROM products p INNER JOIN monthly_products mp ON mp.mp_id = p.id WHERE p.branch_id = '{$branch_id}' GROUP BY mp.mp_id";
  return $db->query($sql);
}

function find_products_sold_by_date_and_branch($start_date, $end_date, $branch_id) {
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name, SUM(s.qty) AS qty, p.quantity ";
  $sql .= "FROM sales s ";
  $sql .= "INNER JOIN products p ON p.id = s.product_id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}' AND p.branch_id = '{$branch_id}'";
  $sql .= " GROUP BY s.product_id";
  return $db->query($sql);
}

function total_sales_by_branch_by_date($start_date, $end_date, $branch_id) {
  global $db;
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $branch_id = $db->escape((int)$branch_id);
  $sql = "SELECT SUM(s.qty) AS t_sales FROM products p INNER JOIN monthly_products mp ON mp.mp_id = p.id INNER JOIN sales s ON s.product_id = p.id WHERE p.branch_id = '{$branch_id}' AND mp.date_added BETWEEN '{$start_date}' AND '{$end_date}'";
  return $db->query($sql);
}

function find_sale_by_dates_and_branch_v2($start_date, $end_date, $branch_id){
  global $db;
  $branch_id = $db->escape($branch_id);
  $start_date  = date("Y-m-d", strtotime($start_date));
  $end_date    = date("Y-m-d", strtotime($end_date));
  $sql  = "SELECT s.date, p.name,p.sale_price,p.buy_price,b.name as branch, b.location,";
  $sql .= "COUNT(s.product_id) AS total_records,";
  $sql .= "SUM(s.qty) AS total_sales,";
  $sql .= "SUM(s.price * s.qty) AS total_saleing_price,";
  $sql .= "SUM(p.buy_price * s.qty) AS total_buying_price ";
  $sql .= "FROM sales s ";
  $sql .= "LEFT JOIN products p ON s.product_id = p.id";
  $sql .= " LEFT JOIN branches b ON p.branch_id = b.id";
  $sql .= " WHERE s.date BETWEEN '{$start_date}' AND '{$end_date}' AND p.branch_id = '{$branch_id}'";
  $sql .= " GROUP BY DATE(s.date), p.name, s.product_id";
  $sql .= " ORDER BY DATE(s.date) DESC";
  return $db->query($sql);
}

?>
