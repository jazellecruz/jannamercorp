<?php
$page_title = 'Products of users';
require_once('includes/load.php');
// Checkin What level user has permission to view this page
page_require_level(3);
// UI algortihm
$bg_colors = ["bg-green", "bg-red", "bg-blue2", "bg-secondary1", "bg-primary"];
$nums = 0;
$num_of_cols = 2;
$col_width = 10 / $num_of_cols;
// find products

$products = find_products_by_branch($_SESSION['branch']);
$branch_name = find_by_id('branches', $_SESSION['branch']);
$customers = get_customers();
$routes = get_routes();
$addresses = get_addresses();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row" style="margin-bottom: 20px;">
    <h3 class="text-left"><?= $branch_name['name'] ?> Branch</h3>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                <form class="row">
                    <div class="col-md-10 col-sm-10">
                        <input type="text" name="search-bar" id="search-bar" class="form-control">
                    </div>
                    <div class="col-md-2 col-sm-2">
                        <button class="btn btn-primary" id="search-btn">
                            <img src="https://www.freeiconspng.com/uploads/search-icon-png-21.png" alt="" height="15" width="15">
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row" style="margin: 10px;">
                    <div class="col-md-12">
                        <h6 class="col-md-12">Customer Name</h6>
                        <select name="discount" id="customer_name" class="form-control">
                            <option selected='selected' disabled>SELECT CUSTOMER</option>
                            <option value="John Doe">John Doe</option>
                            <?php foreach ($customers as $customer) : ?>
                                <option value="<?= $customer['fname'] ?> <?= $customer['lname'] ?>"><?= $customer['fname'] ?> <?= $customer['lname'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col">
                        <h6 class="mt-3 font-bold col-md-12">Transaction Options</h6>
                        <div class="col-md-6">
                            <h6>Pricing</h6>
                            <select class="form-control" name="selected_pricing" id="selected_pricing">
                                <option selected disabled>PRICING</option>
                                <option value="RETAIL">RETAIL</option>
                                <option value="MARKET">MARKET</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <h6>DELIVERY TYPE</h6>
                            <select class="form-control" name="delivery_type" id="delivery_type">
                                <option selected disabled>D.TYPE</option>
                                <option value="WALK-IN">WALK-IN</option>
                                <option value="DELIVERY">DELIVERY</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="col-md-12">Route</h6>
                        <select name="discount" id="route" class="form-control">
                            <option selected disabled>SELECT ROUTE</option>
                            <?php foreach ($routes as $route) : ?>
                                <option value="<?= $route['route_name'] ?>"><?= $route['route_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <h6 class="col-md-12">ADDRESS</h6>
                        <select name="discount" id="address" class="form-control">
                            <option selected='selected' disabled>SELECT ADDRESS</option>
                            <?php foreach ($addresses as $address) : ?>
                                <option value="<?= $address['address_name'] ?>"><?= $address['address_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="col-md-6">ADDONS</h6>
                                    <input type="number" id="addons" placeholder="ADD-ONS" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <h6 class="col-md-6">LESS</h6>
                                    <input type="number" id="less" placeholder="LESS" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <h6 class="col-md-6">SUB TOTAL</h6>
                            <input class="form-control" type="number" name="subtotal" id="subtotal" placeholder="SUB TOTAL" readonly value="9500">
                        </div>
                        
                    </div>
                    <div class="col-md-12">
                    <h6 class="col-md-6">GRAND TOTAL</h6>
                        <input class="form-control" type="number" name="grandtotal" id="grandtotal" placeholder="GRAND TOTAL" readonly>
                    </div>
                </div>
            </div>

            <div class="panel-body">
                <div class="pull-right">
                    <button id="checkout" class="btn btn-primary">Checkout</button>
                </div>
            </div>

            <table class="table">
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th></th>
                </tr>
                <tbody id="table-body">
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-8">
        <?php foreach ($products as $product) : ?>
            <?php $num = 0; ?>
            <?php if ($nums % $num_of_cols == 0) : ?><div class="row"><?php endif; ?>
                <?php $nums++; ?>
                <div class="col-md-<?php echo $col_width; ?> product" style="cursor: pointer">
                    <div class="panel panel-box clearfix">
                        <div class="panel-icon pull-left <?php echo $bg_colors[rand($num % count($bg_colors) == 0 ? $num = 0 : $num, (count($bg_colors) - 1))] ?>">
                            <?php if ($product['media_id'] === '0') : ?>
                                <img class="img-avatar img-circle" src="uploads/products/no_image.png" alt="">
                            <?php else : ?>
                                <img class="img-avatar img-circle" src="uploads/products/<?php echo $product['image']; ?>" alt="">
                            <?php endif; ?>
                        </div>
                        <div class="texts panel-value pull-right">
                            <h4 style="display: none; visibility: hidden;" id="prod_id"><?php echo $product["id"] ?></h4>
                            <h4 class="text-muted text-left" style="margin-left: 10px" id="name">
                                <?php echo $product["product"] ?></h4>
                            <h5 class="text-muted text-left" style="margin-left: 10px" id="cat">
                                <?php echo $product["category"] ?></h5>
                            <h5 class="text-muted text-right" id="price">₱ <?php echo $product["sale_price"] ?></h5>
                        </div>
                    </div>
                </div>
                <?php if ($nums % $num_of_cols == 0) : ?>
                </div><?php endif; ?>
            <?php $num++; ?>
        <?php endforeach; ?>
    </div>
</div>


</div>
<!-- <script src="libs/js/dashboard.js"></script> -->
<script>
const product = document.getElementsByClassName('product');
const delbtn = document.getElementsByClassName('remove-product');
const body = document.getElementById('table-body');
const checkout = document.getElementById('checkout');
const tbody = document.getElementById('table-body');
const searchBar = document.getElementById('search-bar');
const searchBtn = document.getElementById('search-btn');

// transaction details
const customer_name = document.getElementById('customer_name')
const route = document.getElementById('route')
const address = document.getElementById('route')
const addons = document.getElementById('addons')
const less = document.getElementById('less')
const subtotal = document.getElementById('subtotal')
const grandtotal = document.getElementById('grandtotal')
const selected_pricing = document.getElementById('selected_pricing')
const delivery_type = document.getElementById('delivery_type')

const data = [{}];
let tr = null;
let num = 0;
let count = 0;
let searchText = "";


for (let i = 0; i < product.length; i++) {
    product[i].addEventListener('click', function (e) {
        count++;
        const product_id = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h4')[0].innerText;
        const name = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h4')[1].innerText;
        const cat = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h5')[0].innerText;
        const price = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h5')[1].innerText;
        const finalPrice = parseInt(price.substring(2, price.length - 3));
        num += finalPrice;
        subtotal.value = num

        tr = document.createElement('tr');
        tr.id = data.length - 1;
        const td1 = document.createElement('td');
        const td2 = document.createElement('td');
        const td3 = document.createElement('td');
        const td4 = document.createElement('td');
        const td5 = document.createElement('td');
        const span = document.createElement('span');
        const btn = document.createElement('button');
        btn.className = "for-checkout btn btn-danger btn-xs";
        span.className = "glyphicon glyphicon-trash";
        btn.appendChild(span);
        td5.appendChild(btn);
        btn.onclick = deleteItem

        data.push({
            product_id,
            name,
            cat,
            finalPrice
        });

        localStorage.setItem("products", JSON.stringify(data));

        tr.id = data.length - 1;
        td1.innerHTML = count;
        td2.innerHTML = name;
        td3.innerHTML = cat;
        td4.innerHTML = price;

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        tr.appendChild(td4);
        tr.appendChild(td5)

        body.appendChild(tr);
    });
}

checkout.addEventListener('click', async function () {

    const uuid = generateUUID();
    // transaction details 
    const customer_name_value = customer_name.value
    const route_value = route.value
    const address_value = address.value
    const grandtotal_value = grandtotal.value
    const location = route_value + ", " + address_value
    const selected_pricing_value = selected_pricing.value
    const delivery_type_value = delivery_type.value
    const addons_value = addons.value
    const less_value = less.value

    const transactionDetails = new URLSearchParams();
    transactionDetails.append("transaction_table_id", uuid);
    transactionDetails.append("customer_name", customer_name_value);
    transactionDetails.append("route", route_value);
    transactionDetails.append("address", address_value);
    transactionDetails.append("location", location);
    transactionDetails.append("selected_pricing", selected_pricing_value)
    transactionDetails.append("grand_total", grandtotal_value);
    transactionDetails.append("delivery_type", delivery_type_value);
    transactionDetails.append("subtotal", subtotal_value);
    transactionDetails.append("addons", addons_value);
    transactionDetails.append("less", less_value);

    fetch('transaction.php', {
        method: 'POST',
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: transactionDetails
    })
    .then(res => res.text())
    .then(result => {
        console.log(result)
    })
    .catch(err => {
        console.err(err);
    })

    let i = 0;
    while (tbody.firstChild && data.length > -1) {
        const id = data[i]?.product_id;
        const price = Number(data[i]?.price)
        i++;
        setTimeout(function() {
            const body = new URLSearchParams();
            body.append('product_id', id);
            body.append('price', price.toFixed(2));
            body.append('qty', 1);
            body.append('transaction_item_id', uuid);
            fetch('checkout.php', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body
            })
            .then(res =>
                res.text())
            .then(result => {
                data.shift();
            })
            .catch(err => console.error(err));
            }, 500);
        tbody.firstChild.remove();
    }
    num = 0;
});

/**
 * 
 * This is how i will plan this shot
 * 
 * first load the json file from php
 * after loading the file append the respective elements to the container
 * 
 * <-- for search feature -->
 * 
 */

searchBar.addEventListener("keyup", function (event) {
    let value = event.target.value;
    let filter = value.toUpperCase();
    searchText = value;
    for (let i = 0; i < product.length; i++) {
        let name = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h4')[1];
        let category = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h5')[0];
        let textName = name.innerText || name.textContent;
        let categoryName = category.innerText || category.textContent;
        if ((name !== null) && (category !== null)) {
            if ((textName.toUpperCase().indexOf(filter) > -1) || (categoryName.toUpperCase().indexOf(filter) > -1)) {
                product[i].style.display = "";
            } else {
                product[i].style.display = "none";
            }
        }
    }
});

searchBtn.addEventListener("click", function (event) {
    event.preventDefault();
    let filter = searchText.toUpperCase();
    for (let i = 0; i < product.length; i++) {
        let name = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h4')[1];
        let category = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h5')[0];
        let textName = name.innerText || name.textContent;
        let categoryName = category.innerText || category.textContent;
        if (name !== null) {
            if ((textName.toUpperCase().indexOf(filter) > -1) || (categoryName.toUpperCase().indexOf(filter) > -1)) {
                product[i].style.display = "";
            } else {
                product[i].style.display = "none";
            }
        }
    }
});

function deleteItem(e) {
    e.target.parentElement.parentElement.remove();
    data.splice(e.target.parentElement.parentElement.id, 1);
    const element = e.target.parentElement.parentElement
    // let subtractTotal = e.target.parentElement.getElementsByTagName('td')[3].innerText;
    console.log(e.target.parentElement.parentElement.getElementsByTagName('td')[3]);
    console.log(data.length);
    // num = num - parseInt(subtractTotal.substring(2));
    // subtotal.value = num;
    // localStorage.setItem("products", JSON.stringify(data))
}

function generateUUID() { // Public Domain/MIT
    var d = new Date().getTime();//Timestamp
    var d2 = ((typeof performance !== 'undefined') && performance.now && (performance.now() * 1000)) || 0;//Time in microseconds since page-load or 0 if unsupported
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function (c) {
        var r = Math.random() * 16;//random number between 0 and 16
        if (d > 0) {//Use timestamp until depleted
            r = (d + r) % 16 | 0;
            d = Math.floor(d / 16);
        } else {//Use microseconds since page-load if supported
            r = (d2 + r) % 16 | 0;
            d2 = Math.floor(d2 / 16);
        }
        return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
    });
}

function submitTransaction(transactionDetails) {
    fetch('transaction.php', {
        method: 'POST',
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: transactionDetails
    })
    .then(res => res.text())
    .then(result => {
        console.log(result)
    })
    .catch(err => {
        console.err(err);
    })
}

generateUUID();
</script>

<?php include_once('layouts/footer.php'); ?>