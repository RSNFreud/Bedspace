function addToCart(product, quantity = '', redirect = false) {
    if (quantity === 0) {
        $('.messageModal.error').html('Please enter a quantity higher than 0!');
        $('.messageModal.error').css({
            'right': 0
        });
        return setTimeout(() => {
            $('.messageModal.error').css({
                'right': -500
            });
        }, 5000);
    }
    $.ajax({
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            'product': product,
            'quantity': quantity
        },
        url: baseURL + "/api/updateCart",
        success: function (res) {
            if (redirect) return window.location.href = baseURL + '/cart';
            window.location.reload();
        }
    })
}

function deleteItem(id) {
    $.ajax({
        method: "POST",
        url: baseURL + "/api/deleteItem",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            productID: id
        },
        success: function (data) {
            $('#shoppingModal').hide();
            window.location.reload();
        }
    })
}


function findProduct(productName) {
    $('.searchResults').html("");
    if (productName == "") return;
    $.ajax({
        method: 'GET',
        url: baseURL + "/api/findProduct",
        data: {
            productName: productName
        },
        success: function (res, status, xhr) {
            if (xhr.status != 200) {
                $('.searchResults').html(
                    `<div style="padding: 10px 35px">
                    No results found...
                </div>`)
            } else {
                let searchResults = "";
                res.forEach(item => {
                    searchResults +=
                        `<div class="searchGrid" onclick="window.location.href = '${baseURL}/shop/${item['catURL']}/${item['url']}'">
                            ${item["productName"]}
                        </div>`
                });
                $('.searchResults').html(searchResults)
            }
        }
    })
}

function filterItem(searchTerm, items, type) {
    searchTerm = searchTerm.toLowerCase();
    $('.productsList').html("");
    let searchResults = "";
    switch (type) {
        case "categories":
            filteredItems = items.filter(item => item.catName.toLowerCase().includes(searchTerm));
            filteredItems.forEach(item => {
                searchResults +=
                    `<div class="productItemGrid">
                        <img src="${baseURL + '/images/' + item["catImage"]}" alt="">
                        <div class="productData">
                            <span class="description">
                                <strong>${item["catName"]}</strong>
                                <p></p>
                                ${item["catDescription"]}
                            </span>
                            <div class="productButtons">
                                <a class="button" href="${baseURL + '/admin/categories/' + item["catURL"] + '/edit'}">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <span class="button" onclick="removeCategory('${item["catURL"]}')">
                                    <i class="fa fa-times"></i> Delete
                                </span>
                            </div>
                        </div>
                    </div>`
            });
            break
        case "pages":
            filteredItems = items.filter(item => item.navName.toLowerCase().includes(searchTerm));
            filteredItems.forEach(item => {
                searchResults +=
                    `<div class="pageItemGrid">
                        <span class="description">
                            <strong>${item["navName"]}</strong>
                            <p></p>
                            ${item["navURL"]}
                        </span>
                        <div class="productButtons">
                            <a class="button" href="${baseURL + '/admin/pages/' + item["navURL"] + '/edit'}">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <span class="button" onclick="removePage('${item["catURL"]}')">
                                <i class="fa fa-times"></i> Delete
                            </span>
                        </div>
                    </div>`
            });
            break
        default:
            filteredItems = items.filter(item => item.productName.toLowerCase().includes(searchTerm));
            filteredItems.forEach(item => {
                searchResults +=
                    `<div class="productItemGrid">
                        <img src="${baseURL + '/images/' + item["displayImage"]}" alt="">
                        <div class="productData">
                            <span class="description">
                                <strong>${item["productName"]}</strong>
                                <p></p>
                                ${item["description"]}
                            </span>
                            <div class="productButtons">
                                <a class="button" href="${baseURL + '/admin/products/' + item["url"] + '/edit'}">
                                    <i class="fa fa-edit"></i> Edit
                                </a>
                                <span class="button" onclick="removeProduct('${item["url"]}')">
                                    <i class="fa fa-times"></i> Delete
                                </span>
                            </div>
                        </div>
                    </div>`
            });
    }
    if (searchResults == "") {
        $('.productsList').html("No results found...")
    } else {
        $('.productsList').html(searchResults)
    }
}
