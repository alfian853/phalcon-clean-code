<!DOCTYPE html>
<html>
<head>
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="utf-8">

    <title>Inventory</title>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>


    <link rel="stylesheet" type="text/css" href="/assets/css/table.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.foundation.min.css">

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.foundation.min.js"></script>

    <script src="/assets/js/DataTablesAccess.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.foundation.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/css/foundation.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izimodal-1.6.0@1.6.1/css/iziModal.min.css">
    <script src="https://cdn.jsdelivr.net/npm/izimodal-1.6.0@1.6.1/js/iziModal.min.js"></script>

    <style>
        .dataTables_filter, .dataTables_info { display: none; }
    </style>

    <script>
        var tableAccess = null;
        let preparedCol = DTAccess.generateColumnSpec([
            {'col':'id'},
            {'col':'name'},
            {'col':'price','searchable' : false},
            {'col':'quantity','searchable' : false},
            {'col':'category'},
            {'col':'type','searchable' : false,'orderable':false},
            {'col':'action','searchable' : false,'orderable':false}
        ]);
        function loadInventoryDetail(idInventory){
            $('#inventory-detail-modal').iziModal({
                title : 'Inventory Detail',
                width : screen.width*0.9,
                height : screen.height*0.9,
                closeButton : true,
                fullScreen : true,
                history: false,
                onOpening : function (modal) {
                    modal.startLoading();
                    $('#update-item-form input[name=id]').val(idInventory);
                    $.get('/inventory/api/inventory/detail?id='+idInventory,function (response) {
                        console.log(response)
                        Object.keys(response).forEach(key => {
                            console.log(key)
                           $('#update-item-form [name='+key+']').val(response[key]);
                        });
                        modal.stopLoading();
                    }).fail(function (file,response) {
                        modal.stopLoading();
                        toastMessage('error','Failed','Something wrong :(');
                        $('.iziModal-button-close').click();
                    });
                },
                onClosed : function (modal) {
                    $('#inventory-detail-modal').iziModal('destroy');
                }

            });
            $('#inventory-detail-modal').iziModal('open');

        }
        $(document).ready(function(){

            var datatables = $('#itemsTable').DataTable({
                processing: true,
                serverSide : true,
                ajax : {
                    'type' : 'GET',
                    'url' : '/inventory/api/inventory/data',
                    'dataSrc' : function (response) {
                        let len = response.data.length;
                        let ref = response.data;
                        for(let i = 0; i<len; i++){
                            ref[i]['action'] =
                                '<button class="submit btn btn-success" type="submit" onclick="loadInventoryDetail('+ref[i].id+')">Detail</button>' +
                                '<button class="submit btn btn-danger" style="background-color: #BB281A;" type="submit" onclick="deleteInventory('+ref[i].id+')">' +
                                '<i class="fas fa-trash"></i>' +
                                '</button>'

                        }
                        return ref;
                    }
                },
                columns : preparedCol.column,
                columnDefs : preparedCol.columnDefs
            });

            var searchableList = ['id','name','category'];

            for(let i=0;i<searchableList.length;i++){
                let input = $('#itemsTable [target-col=\"'+searchableList[i]+'\"]');
                let target = datatables.column('#itemsTable th[col=\"'+searchableList[i]+'\"]');
                input.on('keyup change',function () {
                    if(target.search() !== input.val()){
                        target.search(input.val()).draw();
                    }
                });
            }

            tableAccess = new DTAccess(datatables,'row_',7);
            $('#itemsTable select[target-col=\"category\"]').select2({
                placeholder : 'Please select category..',
                ajax : {
                    url : '/inventory/api/category/search',
                    params : null,
                    delay : 350,
                    data : function (params) {
                        console.log('called');
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
                        let len = result.results.length;
                        let tmp = result.results;
                        for(let i = 0; i<len; i++){
                            tmp[i].id = tmp[i].text;
                        }
                        return result;
                    }
                },
                cache : true
            });


            $('#create-item-modal').iziModal({
                title : 'Create Item',
                width : screen.width*0.5,
                height : screen.height*0.9,
                closeButton : true,
                fullScreen : true,
                history: false,
                onOpening : function(){
                    $('select[name=\"category_id\"]').select2({
                        placeholder : 'Please select category...',
                        ajax : {
                            url : '/inventory/api/category/search',
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
                        },
                        cache : true
                    });
                },
                onClosed : function (modal) {
                    $('#create-item-form')[0].reset();
                }

            });

            $("#itemBtn").click(function(){
                $('#create-item-modal').iziModal('open');
            });

        });
    </script>
    <title>Inventory</title>

</head>
<body>
<button class="btn btn-success" id="itemBtn">Create Item</button>

<div id="create-item-modal">
    <div class="modal-body">
        <form id="create-item-form" action="/inventory/inventory/create" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Item Name *</label><br>
                <input class="form-input" name="name" type="text">
            </div>
            <div class="form-group">
                <label class="form-label">Item Quantity *</label><br>
                <input class="form-input" type="number" min="0" name="quantity" style="width: 95.5%;">
            </div>
            <div class="form-group">
                <label class="form-label">Item Price</label><br>
                <input class="form-input" type="number" min="0" name="price" style="width: 95.5%;">
            </div>
            <div class="form-group">
                <label class="form-label">Item Category</label><br>
                <select class="form-input" style="width: 95.5%;" name="category_id">
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Item type</label>
                <select class="form-input" style="width: 95.5%; padding-right: 25px;" name="type">
                        <option value="Consumable">Consumable</option>
                        <option value="Stockable">Stockable</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label><br>
                <textarea class="form-input" name="description"></textarea>
            </div>
            <div class="form-action">
                <button type="submit" class="submit btn btn-success" id="add-item-submit">Add Item</button>
            </div>
        </form>
    </div>
</div>
<div id="inventory-detail-modal" style="display: none">
    <form id="update-item-form" action="/inventory/inventory/update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id">
        <div class="form-group">
            <label class="form-label">Item Name *</label><br>
            <input class="form-input" name="name" type="text">
        </div>
        <div class="form-group">
            <label class="form-label">Item Quantity *</label><br>
            <input class="form-input" type="number" min="0" name="quantity" style="width: 95.5%;">
        </div>
        <div class="form-group">
            <label class="form-label">Item Price</label><br>
            <input class="form-input" type="number" min="0" name="price" style="width: 95.5%;">
        </div>
        <div class="form-group">
            <label class="form-label">Item Category</label><br>
            <select class="form-input" style="width: 95.5%;" name="category_id">
                <option value="1">/all</option>
                <option value="2">/all/book</option>
                <option value="3">/all/listrik</option>
                <option value="4">/all/book/software design</option>
                <option value="5">/all/book/algorithm</option>
                <option value="6">/all/novel</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Item type</label>
            <select class="form-input" style="width: 95.5%; padding-right: 25px;" name="type">
                <option value="Consumable">Consumable</option>
                <option value="Stockable">Stockable</option>
            </select>
        </div>
        <div class="form-group">
            <label class="form-label">Description</label><br>
            <textarea class="form-input" name="description"></textarea>
        </div>
        <div class="form-action">
            <button type="submit" class="submit btn btn-success" id="add-item-submit">Update Data</button>
        </div>
    </form>
</div>

<div id="content">

    <div style="padding: 50px;">
        <table id="itemsTable" class="display" style="width:100%;">
            <thead>
            <tr>
                <th><input type="text" style="width: 60px" placeholder="Id.." target-col="id"/></th>
                <th><input type="text" placeholder="Name.." target-col="name"/></th>
                <th></th>
                <th></th>
                <th>
                    <select target-col="category" style="width: 200px;">
                        <!--<th:block th:each="category : ${categories}">-->
                        <!--<option th:value="${category.name}" th:text="${category.name}">Option i</option>-->
                        <!--</th:block>-->
                    </select>
                </th>
                <th></th>
                <th></th>
            </tr>
            <tr>
                <th col="id">Id</th>
                <th col="name">Name</th>
                <th col="price">Price</th>
                <th col="quantity">Quantity</th>
                <th col="category">Category</th>
                <th col="type">Type</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody id="items-table-body" style="font-size: 15px;">
            </tbody>
            <tfoot>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Category</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>


<footer>
    <!--Layout footer-->
</footer>


</body>
</html>
