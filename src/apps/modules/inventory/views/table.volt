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

        });
    </script>
    <title>Inventory</title>

</head>
<body>

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
