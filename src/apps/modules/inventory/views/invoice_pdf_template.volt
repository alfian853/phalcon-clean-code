<html>
<style>
    /*thead, tbody, th { border: 1px solid black; padding: 10px; color: #000; }*/

    /*tfoot{ border: none; font-style: italic; }*/
</style>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>ID Unit</th>
                <th>Inventory</th>
                <th>Category</th>
                <th>Warehouse</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
        {% for item in items %}
            <tr>
                <td>{{ item.getId() }}</td>
                <td>{{ item.getInventory().getName() }}</td>
                <td>{{ item.getInventory().getCategory().getName() }}</td>
                <td>{{ item.getWarehouse().getName() }}</td>
                <td>{{ item.getInventory().getPrice() }}</td>
            </tr>
        {% endfor %}
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Grand Total : {{ grandTotal }}</td>
            </tr>
        </tfoot>
    </table>


</body>

</html>