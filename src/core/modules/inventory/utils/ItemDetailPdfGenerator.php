<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/19/19
 * Time: 3:41 PM
 */

namespace Core\Modules\Inventory\Utils;


use Core\Modules\Inventory\Entities\InventoryUnit;

interface ItemDetailPdfGenerator
{
    function addItemData(InventoryUnit $item) : ItemDetailPdfGenerator;
    function render() : ItemDetailPdfGenerator;
    function getDownloadUrl(string $filename);
}