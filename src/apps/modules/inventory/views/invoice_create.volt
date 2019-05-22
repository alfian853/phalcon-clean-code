<div style="margin-top :10px;padding:10px;" xmlns:th="http://www.w3.org/1999/xhtml">
    <div class="row" style="padding: 0px 20px 10px 20px;">
        <div class="col-5">
            <label>Warehouse : </label>
        </div>
        <div class="col-7">
            <select id="AI-warehouse-select" style="width: 300px;">
            </select>
        </div>
    </div>
    <div class="row" style="padding: 0px 20px 10px 20px;">
        <div class="col-md-5">
            <label>Selected Items : </label>
        </div>
        <div class="col-md-5">
            <select id="AI-item-select" style="width: 300px;">
                <!--<option></option>-->
            </select>
        </div>
        <div class="col-md-2">
            <button id="assign-item-add" type="button" class="btn btn-secondary">
                <i class="fas fa-plus"></i>
            </button>
        </div>
    </div>
    <div class="row" style="padding: 0px 20px;">
        <div class="col-3">
            <label>Id</label>
        </div>
        <div class="col-3">
            <label>Name</label>
        </div>
        <div class="col-3">
            <label>Price</label>
        </div>
        <div class="col-3">
            <label>Warehouse</label>
        </div>
    </div>
    <div class="row" id="selected-items" style="padding: 10px 35px;">
    </div>
    <div class="modal-footer">
        <button id="item-assign-submit" class="btn btn-primary">Assign</button>
        <button id="item-assign-cancel" class="btn btn-primary">Cancel</button>
    </div>
</div>

<a id="invoice-document" style="display: none" href="" target="_blank"></a>
<!--/*
Documentation

        list of global variable usage
        [
            tableAccess => global access for dataTables, initialize in inventory_list.html,
        ]
*/-->

<script>

    var isSelected = {};

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_csrf"]').attr('content')
        }
    });

    function removeItem(id){
        $('#selected-items div[item_id=\"'+id+'\"]').remove();
        isSelected[id]=false;
    }

    $('#AI-warehouse-select').select2({
        placeholder : 'Please select warehouse...',
        ajax : {
            url : '/inventory/api/warehouse/search',
            params : null,
            delay : 350,
            data : function (params) {
                let query = {
                    search : (params.term != null)?params.term:"",
                    page : (params.page)?params.page:0,
                    length : 10
                };
                this.params = query;
                return query;
            },
            processResults : function (result) {
                let params = this['$element'].params;
                result.pagination = {
                    more : params.length*params.page < result['recordsFiltered']
                };
                return result;
            }

        }
    });

    var itemData = {};

    var item_select = $('#AI-item-select');
    item_select.select2({
        placeholder : 'Please select item...',
        ajax : {
            url : '/inventory/api/inventory_unit/search',
            params : null,
            delay : 350,
            data : function (params) {
                let query = {
                    search : (params.term != null)?params.term:"",
                    page : (params.page)?params.page:0,
                    length : 10,
                    warehouse_id: $('#AI-warehouse-select').val()
                };
                this.params = query;
                return query;
            },
            processResults : function (result) {
                let params = this['$element'].params;
                result.pagination = {
                    more : params.length*params.page < result['recordsFiltered']
                };
                let tmp = result.results;
                let len = tmp.length;
                for(let i=0; i<len; i++){
                    itemData[tmp[i].id] = {
                        'ctg': tmp[i].id, 'qty':tmp[i].price, 'name':tmp[i].name,
                        'warehouse_name': tmp[i].warehouse_name, 'warehouse_id': tmp[i].warehouse_id
                    };
                    tmp[i].text = tmp[i].name + ' ('+tmp[i].id+')';
                }
                return result;
            }
        },cache : true
    });

    $('#assign-item-add').click(function () {
        var id = $('#AI-item-select').val();
        if(id == '' || isSelected[id] === true){
            return;
        }
        isSelected[id] = true;
        var row = $('#AI-item-select').find('option[value='+id+']');
        var ctg = itemData[""+id].ctg;
        var qty = itemData[""+id].qty;
        var name = itemData[""+id].name;
        var warehouse = itemData[""+id].warehouse_name;
        $('#selected-items').append(
            '<div class="row selected-item-row" item_id="'+id+'">' +
            '   <div class="col-3">' +
            '       <input type="text" name="category" disabled="disabled" value="'+ctg+'">' +
            '   </div>' +
            '   <div class="col-3">' +
            '       <input type="text" name="name" disabled="disabled" value="'+name+'\">' +
            '   </div>' +
            '   <div class="col-2">' +
            '       <input type="text" name="price" disabled value="'+qty+'">' +
            '   </div>' +
            '   <div class="col-2">' +
            '       <input type="text" name="warehouse" disabled value="'+warehouse+'">' +
            '   </div>' +
            '   <div class="col-2">' +
            '       <button type="button" class="btn btn-secondary" onclick="removeItem(\''+id+'\')">' +
            '           <i class="fas fa-minus"></i>' +
            '       </button>' +
            '   </div>' +
            '</div>'
        );
    });

    $('#item-assign-cancel').click(function () {
        $('.iziModal-button-close').click();
    });

    $('#item-assign-submit').click(function () {
        var data = {};
        // data['warehouse_id'] = $('#AI-warehouse-select').val();
        var items = [];
        var valid = true;
        $('#selected-items > .row').each(function () {
            var item = {};
            item = $(this).attr('item_id');
            items.push(item);
        });
        if(!valid){
            return;
        }
        data['items'] = items;
        $.ajax({
            type: "POST",
            url: "/inventory/api/inventory_unit/createInvoice",
            data: JSON.stringify(data),
            contentType : "application/json; charset=utf-8",
            success: function(response){
                $('#invoice-document').attr('href',response['document_url']);
                $('#invoice-document')[0].click();
            }
        }).fail(function () {
        });


    });


</script>