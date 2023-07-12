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

        tr = document.createElement('tr');
        tr.id = data.length + 1;
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

        localStorage.setItem("products", JSON.stringify(data));
    });
}

checkout.addEventListener('click', async function () {

    const uuid = generateUUID();
    // transaction details 
    const customer_name_value = customer_name.value
    const route_value = route.value
    const address_value = address.value
    const grandtotal_value = grandtotal.value
    const destination = route_value + ", " + address_value

    const transactionDetails = new URLSearchParams();
    transactionDetails.append("transaction_table_id", uuid);
    transactionDetails.append("customer_name", customer_name_value);
    transactionDetails.append("route", route_value);
    transactionDetails.append("address", address_value);
    transactionDetails.append("grandtotal", grandtotal_value);
    transactionDetails.append("destination", destination);

    await submitTransaction(transactionDetails);

    // let i = 0;
    // while (tbody.firstChild && data.length > -1) {
    //     const id = data[i]?.product_id;
    //     let price = disc_val < 0 ? data[i]?.finalPrice : data[i]?.finalPrice * disc_val;
    //     i++;
    //     setTimeout(function() {
    //         const body = new URLSearchParams();
    //         body.append('product_id', id);
    //         body.append('price', price.toFixed(2));
    //         body.append('qty', 1);
    //         fetch('checkout.php', {
    //             method: 'POST',
    //             headers: {
    //                 "Content-Type": "application/x-www-form-urlencoded"
    //             },
    //             body
    //         })
    //         .then(res =>
    //             res.text())
    //         .then(result => {
    //             data.shift();
    //         })
    //         .catch(err => console.error(err));
    //         }, 500);
    //     tbody.firstChild.remove();
    // }
    // num = 0;
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
    const element = e.target.parentElement.parentElement.parentElement;
    const elementId = e.id;
    console.log("Element ID: " + elementId);
    console.log(element);
    // let subtractTotal = element.getElementsByTagName('td')[3].innerText;
    // num = num - parseInt(subtractTotal.substring(2, price.length - 3));
    // const productName = element.getElementsByTagName('td')[1].innerText;

    // const index = data.map(data => data.name).indexOf(productName);

    // if (index > -1) {
    //     data.splice(index, 1);
    // }
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

window.addEventListener('load', function () {
    customer_name.value = "John Doe";
    route.value = "Malabon";
    address.value = "Del Carpio";
    grandtotal.value = "10000";

    console.log(this.localStorage.getItem("products"));
})

generateUUID();