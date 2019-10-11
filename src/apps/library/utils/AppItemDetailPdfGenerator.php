<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/19/19
 * Time: 3:48 PM
 */

namespace App\Library\Utils;


use Core\Modules\Inventory\Entities\InventoryUnit;
use Core\Modules\Inventory\Utils\ItemDetailPdfGenerator;
use Dompdf\Dompdf;
use Phalcon\Mvc\View\Simple;

/**
 * @property Simple view
 * @property Dompdf domPdf
 */
class AppItemDetailPdfGenerator implements ItemDetailPdfGenerator
{

    private $view, $viewPath = "inventory_pdf_template", $domPdf;

    function __construct(Simple $simpleView)
    {
        $this->view = $simpleView;
        $this->domPdf = new Dompdf();
    }

    function render() : ItemDetailPdfGenerator
    {
        $this->domPdf->loadHtml($this->view->render($this->viewPath));
        $this->domPdf->render();
        return $this;
    }

    function getDownloadUrl(string $filename)
    {
        file_put_contents(PUBLIC_PATH . '/unit_details/' . $filename, $this->domPdf->output());
        return 'unit_details/'.$filename;
    }

    function addItemData(InventoryUnit $item) : ItemDetailPdfGenerator
    {
        $this->view->setVars([
            'item' => $item,
            'inventory' => $item->getInventory(),
            'warehouse' => $item->getWarehouse(),
            'category' => $item->getInventory()->getCategory()
        ]);
        return $this;
    }
}