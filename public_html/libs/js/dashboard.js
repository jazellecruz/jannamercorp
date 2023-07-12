const product = document.getElementsByClassName('product');
const delbtn = document.getElementsByClassName('remove-product');
const body = document.getElementById('table-body');
const checkout = document.getElementById('checkout');
const amount = document.getElementById('amount');
const tbody = document.getElementById('table-body');
const discount = document.getElementById('discount');
const discValue = document.getElementById('disc-value');
const searchBar = document.getElementById('search-bar');
const searchBtn = document.getElementById('search-btn');
const data = [];
let tr = null;
let num = 0;
let disc_val = -1;
let count = 0;
let searchText = "";


for (let i = 0; i < product.length; i++) {
    product[i].addEventListener('click', function(e) {
        count++;
        const product_id = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h4')[0].innerText;
        const name = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h4')[1].innerText;
        const cat = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h5')[0].innerText;
        const price = product[i].getElementsByClassName('texts')[0].getElementsByTagName('h5')[1].innerText;
        const finalPrice = parseInt(price.substring(2, price.length - 3));
        num += finalPrice;

        tr = document.createElement('tr');
        tr.className = "remove-product";
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

        data.push({
            product_id,
            name,
            cat,
            finalPrice
        });

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

        // UPDATE: FIXED NA
        // <WARNING> this can delete single element but this also remove elements above the selected element
        for (let j = 0; j < delbtn.length; j++) {
            delbtn[j].getElementsByTagName('td')[4].addEventListener('click', function(e) {
                e.target.addEventListener('click', function() {
                    let subtractTotal = delbtn[j].getElementsByTagName('td')[3].innerText;
                    num = num - parseInt(subtractTotal.substring(2, price.length - 3));
                    const productName = delbtn[j].getElementsByTagName('td')[1].innerText;
                    const index = data.map(data => data.name).indexOf(productName);
                    if (index > -1) {
                        data.splice(index, 1);
                    }
                    document.getElementsByClassName('remove-product')[j].innerHTML = "";
                });
            });
        }
    });
}

checkout.addEventListener('click', function() {
    if (disc_val < 0) {
        amount.value = "₱ " + num + ".00";
    } else {
        let amountValue = parseFloat(num) * parseFloat(disc_val);
        amountValue = "₱ " + amountValue.toFixed(2);
        amount.value = amountValue;
    }
    let i = 0;
    while (tbody.firstChild && data.length > -1) {
        const id = data[i]?.product_id;
        let price = disc_val < 0 ? data[i]?.finalPrice : data[i]?.finalPrice * disc_val;
        i++;
        setTimeout(function() {
            const body = new URLSearchParams();
            body.append('product_id', id);
            body.append('price', price.toFixed(2));
            body.append('qty', 1);
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

amount.addEventListener('click', function() {
    amount.value = "";
    num = 0;
    discount.value = "Add discount";
    discValue.innerHTML = "...";
    disc_val = -1;
});
    
discount.addEventListener('change', function(e) {
    const value = e.target.value;
    console.log(value);
    disc_val = value;
    let discountRealValue = "...";
    switch (value) {
        case "0.95":
            discountRealValue = "-5%";
            break;
        case "0.9":
            discountRealValue = "-10%";
            break;
        case "0.85":
            discountRealValue = "-15%";
            break;
        case "0.8":
            discountRealValue = "-20%";
            break;
        case "0.75":
            discountRealValue = "-25%";
            break;
        case "0.5":
            discountRealValue = "-50%";
            break;
        case "0":
            discountRealValue = "-100%";
            break;
    }
    discValue.innerHTML = discountRealValue;
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

searchBar.addEventListener("keyup", function(event) {
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

searchBtn.addEventListener("click", function(event) {
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