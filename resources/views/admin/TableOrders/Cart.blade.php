<div class="uk-card uk-card-default">
    <div class="uk-overflow-auto uk-card-body">
        <div class="uk-grid-margin uk-first-column">
            <div uk-grid>
                <div class="uk-width-1-2">
                    <span style="float:left;">
                        <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                            <div class="uk-form-controls uk-width-1-1">
                                <label class="uk-form-label" for="form-h-text">Cambia Tutto Menu</label>
                                <select class="uk-select" id="admin_cart_menu" onchange="Change_Cart_Menu()">
                                    <option value="2">Carta</option>
                                    <option value="4">Cena</option>
                                    <option value="3">Pranzo</option>
                                </select>
                            </div>
                        </div>
                    </span>
                </div>
                <div class="uk-width-1-2">
                    <span style="float:right;">
                        <div class="uk-margin-small uk-grid-small uk-grid" uk-grid>
                        </div>
                    </span>
                </div>
            </div>
            <table class="uk-table uk-table-striped uk-table-small uk-table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nome</th>
                        <th>Menu</th>
                        <th>Quantita'</th>
                        <th class="uk-preserve-width">Azione</th>
                    </tr>
                </thead>
                <tbody id="tbody-id">
                </tbody>
            </table>
        </div>
    </div>
    <div class="uk-overflow-auto uk-card-body">
        <div id="dishs_area_new" uk-grid></div>
    </div>
</div>
<script>

function Change_Cart_Menu(){
    new_menu = document.getElementById("admin_cart_menu").value;
    var cart = getCookie('cart');
    if (cart) {
        cart = JSON.parse(getCookie('cart'));
        delete cart['row_number'];
    } else {
        console.log("no order to change.");
        return;
    }

    cart_array = Object.values(cart);
    //console.log("original array");
    //console.log(cart_array);
    new_cart = {};
    $("#tbody-id").html("");
    //console.log(dishs_indexed);
    for(i in cart_array){
        cart_array[i].menu = new_menu;
        newkey = cart_array[i].dish_id.toString()+ new_menu;
        if(new_cart[newkey]){
            //如果key已经有了，则啥都不做。
        }
        else
        {
            id = cart_array[i].dish_id;
            new_cart[newkey] = JSON.parse(JSON.stringify(cart_array[i]));
            var template = `<tr id="cart_${newkey}">\
                <td>${id}</td>\
                <td>${dishs_indexed[id].name}</td>\
                <td>${$("#admin_cart_menu").find("option:selected").text()}</td>\
                <td id="cart_number_${newkey}">${new_cart[newkey]['number']}</td>\
                <td class="uk-preserve-width"><a class="uk-button uk-button-small uk-button-primary" \
                onclick="Delitem(${id},${$("#admin_cart_menu").find("option:selected").val()},${tid},${newkey})">\
                <i uk-icon="minus-circle"></i></a></td></tr>`;

                $("#tbody-id").append(template);
        }
    }

    //console.log("new array");
    //console.log(new_cart);

    setCookie('cart', JSON.stringify(new_cart),1);

    
    




}

</script>