<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/22/19
 * Time: 11:50 AM
 */

namespace Core\Modules\Inventory\Utils;


use Core\Modules\Inventory\Orm\ListOfInventoryUnit;

interface InvoicePdfGenerator
{
    function addData(ListOfInventoryUnit $item,int $grandTotal) : InvoicePdfGenerator;
    function render() : InvoicePdfGenerator;
    function getDownloadUrl(string $filename);
}