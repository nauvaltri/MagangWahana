<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Response;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html as HtmlWriter;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Laminas\Diactoros\Stream;

class ReportPurchasesTransactionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication'); // Memuat AuthenticationComponent
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        // Aksi yang bisa diakses tanpa autentikasi
        // $this->Authentication->addUnauthenticatedActions(['publicAction']);

        // Cek apakah pengguna sudah terautentikasi
        $result = $this->Authentication->getResult();
        if (!$result->isValid()) {
            // Jika pengguna belum login, arahkan ke halaman login
            $this->Flash->error('Anda harus login terlebih dahulu.');
            return $this->redirect(['controller' => 'Employees', 'action' => 'login']);
        }
    }

    public function index()
    {
        if ($this->request->is('post')) {
            $startDate = $this->request->getData('startdate');
            $endDate = $this->request->getData('enddate');
            $format = $this->request->getData('format');

            $purchaseTransactionsTable = TableRegistry::getTableLocator()->get('PurchaseTransactions');
            $transactions = $purchaseTransactionsTable->find()
                ->where(['transaction_date >=' => $startDate, 'transaction_date <=' => $endDate])
                ->contain(['Employees', 'Purchases'])
                ->all();

            if ($format === 'excel') {
                return $this->exportExcel($transactions, $startDate, $endDate);
            } elseif ($format === 'html') {
                return $this->exportHtml($transactions, $startDate, $endDate);
            }
        }
    }

    protected function exportExcel($purchaseTransactions, $startDate, $endDate): Response
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set company name
        $sheet->setCellValue('A1', 'Wahana Artha Group')
            ->mergeCells('A1:J1');
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(14);

        // set filename
        $sheet->setCellValue('A2', 'Purchase Transactions Report')
            ->mergeCells('A2:J2');
        $sheet->getStyle('A2:J2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:J2')->getFont()->setSize(12);

        // Set period
        $sheet->setCellValue('A3', "Period: $startDate to $endDate")
            ->mergeCells('A3:J3');
        $sheet->getStyle('A3:J3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:J3')->getFont()->setItalic(true);

        // Set header
        $sheet->setCellValue('A5', 'Id');
        $sheet->setCellValue('B5', 'Code');
        $sheet->setCellValue('C5', 'Employee');
        $sheet->setCellValue('D5', 'Purchase');
        $sheet->setCellValue('E5', 'Price');
        $sheet->setCellValue('F5', 'Quantity');
        $sheet->setCellValue('G5', 'Total Price');
        $sheet->setCellValue('H5', 'Transaction Date');
        $sheet->setCellValue('I5', 'Created');
        $sheet->setCellValue('J5', 'Modified');
        $sheet->getStyle('A5:J5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:J5')->getFont()->setBold(true);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(9);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);

        // Set data
        $row = 6;
        foreach ($purchaseTransactions as $transaction) {
            $sheet->setCellValue("A{$row}", $transaction->id);
            $sheet->setCellValue("B{$row}", $transaction->code);
            $sheet->setCellValue("C{$row}", $transaction->employee->fullname);
            $sheet->setCellValue("D{$row}", $transaction->purchase->merk);
            $sheet->setCellValue("E{$row}", $transaction->price);
            $sheet->setCellValue("F{$row}", $transaction->quantity);
            $sheet->setCellValue("G{$row}", $transaction->total_price);
            $sheet->setCellValue("H{$row}", $transaction->transaction_date->format('Y-m-d H:i:s'));
            $sheet->setCellValue("I{$row}", $transaction->created);
            $sheet->setCellValue("J{$row}", $transaction->modified);
            $row++;
        }

        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        $response = $this->response->withType('xlsx');
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $excelOutput);
        rewind($stream);

        $formattedStartDate = date('Ymd', strtotime($startDate));
        $formattedEndDate = date('Ymd', strtotime($endDate));
        $filename = "Purchase-Transactions-Report_{$formattedStartDate}-to-{$formattedEndDate}.html";

        return $response->withBody(new Stream($stream))
            ->withHeader('Content-Disposition', "attachment; filename=\"{$filename}\".xlsx");
    }

    protected function exportHtml($purchaseTransactions, $startDate, $endDate): Response
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set company name
        $sheet->setCellValue('A1', 'Wahana Artha Group')
            ->mergeCells('A1:J1');
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:J1')->getFont()->setBold(true)->setSize(14);

        // Set period
        $sheet->setCellValue('A2', "Period: $startDate to $endDate")
            ->mergeCells('A2:J2');
        $sheet->getStyle('A2:J2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:J2')->getFont()->setItalic(true);

        // Set header
        $sheet->setCellValue('A5', 'Id');
        $sheet->setCellValue('B5', 'Code');
        $sheet->setCellValue('C5', 'Employee');
        $sheet->setCellValue('D5', 'Purchase');
        $sheet->setCellValue('E5', 'Price');
        $sheet->setCellValue('F5', 'Quantity');
        $sheet->setCellValue('G5', 'Total Price');
        $sheet->setCellValue('H5', 'Transaction Date');
        $sheet->setCellValue('I5', 'Created');
        $sheet->setCellValue('J5', 'Modified');
        $sheet->getStyle('A5:J5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:J5')->getFont()->setBold(true);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(12);
        $sheet->getColumnDimension('F')->setWidth(9);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(20);

        // Set data
        $row = 6;
        foreach ($purchaseTransactions as $transaction) {
            $sheet->setCellValue("A{$row}", $transaction->id);
            $sheet->setCellValue("B{$row}", $transaction->code);
            $sheet->setCellValue("C{$row}", $transaction->employee->fullname);
            $sheet->setCellValue("D{$row}", $transaction->purchase->merk);
            $sheet->setCellValue("E{$row}", $transaction->price);
            $sheet->setCellValue("F{$row}", $transaction->quantity);
            $sheet->setCellValue("G{$row}", $transaction->total_price);
            $sheet->setCellValue("H{$row}", $transaction->transaction_date->format('Y-m-d H:i:s'));
            $sheet->setCellValue("I{$row}", $transaction->created);
            $sheet->setCellValue("J{$row}", $transaction->modified);
            $row++;
        }

        $writer = new HtmlWriter($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $htmlOutput = ob_get_clean();

        // Format dates for filename
        $formattedStartDate = date('Ymd', strtotime($startDate));
        $formattedEndDate = date('Ymd', strtotime($endDate));
        $filename = "Purchase-Transactions-Report_{$formattedStartDate}-to-{$formattedEndDate}.html";

        $response = $this->response->withType('text/html');
        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $htmlOutput);
        rewind($stream);

        return $response->withBody(new Stream($stream))
            ->withHeader('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}