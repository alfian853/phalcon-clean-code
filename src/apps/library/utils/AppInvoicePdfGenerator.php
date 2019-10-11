<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/22/19
 * Time: 11:52 AM
 */

namespace App\Library\Utils;


use Core\Modules\Inventory\Entities\ListOfInventoryUnit;
use Core\Modules\Inventory\Utils\InvoicePdfGenerator;
use Dompdf\Dompdf;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View\Simple;

class AppInvoicePdfGenerator implements InvoicePdfGenerator
{

    private $view, $viewPath = "invoice_pdf_template", $domPdf;

    function __construct(Simple $simpleView)
    {
        $this->view = $simpleView;
        $this->domPdf = new Dompdf();
    }

    function setViewPath($path){
        $this->viewPath = $path;
    }


    function addData(ListOfInventoryUnit $item, int $grandTotal): InvoicePdfGenerator
    {
        $this->view->setVars([
            'items' => $item->getList(),
            'grandTotal' => $grandTotal
        ]);
        return $this;
    }

    function render(): InvoicePdfGenerator
    {
        $this->domPdf->loadHtml($this->view->render($this->viewPath));
        $this->domPdf->render();
        return $this;
    }

    function getDownloadUrl(string $filename)
    {
        file_put_contents(PUBLIC_PATH . '/invoices/' . $filename, $this->domPdf->output());
        return '/invoices/'.$filename;
    }
}