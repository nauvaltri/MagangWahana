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

class ReportPurchasesPaymentsController extends AppController
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

            $purchasePaymentsTable = TableRegistry::getTableLocator()->get('PurchasePayments');
            $payments = $purchasePaymentsTable->find()
                ->where(['payment_date >=' => $startDate, 'payment_date <=' => $endDate])
                ->contain(['PurchaseTransactions'])
                ->all();

            if ($format === 'excel') {
                return $this->exportExcel($payments, $startDate, $endDate);
            } elseif ($format === 'html') {
                return $this->exportHtml($payments, $startDate, $endDate);
            }
        }
    }

    protected function exportExcel($purchasePayments, $startDate, $endDate): Response
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set company name
        $sheet->setCellValue('A1', 'Wahana Artha Group')
            ->mergeCells('A1:I1');
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I1')->getFont()->setBold(true)->setSize(14);

        // set filename
        $sheet->setCellValue('A2', 'Purchase Payments Report')
            ->mergeCells('A2:I2');
        $sheet->getStyle('A2:I2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:I2')->getFont()->setSize(12);

        // Set period
        $sheet->setCellValue('A3', "Period: $startDate to $endDate")
            ->mergeCells('A3:I3');
        $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:I3')->getFont()->setItalic(true);

        // Set header
        $sheet->setCellValue('A5', 'Id');
        $sheet->setCellValue('B5', 'Purchase Transaction Id');
        $sheet->setCellValue('C5', 'Payment Method');
        $sheet->setCellValue('D5', 'Status');
        $sheet->setCellValue('E5', 'Proof');
        $sheet->setCellValue('F5', 'Nominal');
        $sheet->setCellValue('G5', 'Payment Date');
        $sheet->setCellValue('H5', 'Created');
        $sheet->setCellValue('I5', 'Modified');
        $sheet->getStyle('A5:I5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:I5')->getFont()->setBold(true);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);

        // Set data
        $row = 6;
        foreach ($purchasePayments as $payment) {
            $sheet->setCellValue("A{$row}", $payment->id);
            $sheet->setCellValue("B{$row}", $payment->purchase_transaction->id);
            $sheet->setCellValue("C{$row}", $payment->payment_method);
            $sheet->setCellValue("D{$row}", $payment->status);
            $sheet->setCellValue("E{$row}", $payment->proof);
            $sheet->setCellValue("F{$row}", $payment->nominal);
            $sheet->setCellValue("G{$row}", $payment->payment_date->format('Y-m-d H:i:s'));
            $sheet->setCellValue("H{$row}", $payment->created);
            $sheet->setCellValue("I{$row}", $payment->modified);
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
        $filename = "Purchase-Payments-Report_{$formattedStartDate}-to-{$formattedEndDate}.html";

        return $response->withBody(new Stream($stream))
            ->withHeader('Content-Disposition', "attachment; filename=\"{$filename}\".xlsx");
    }

    protected function exportHtml($purchasePayments, $startDate, $endDate): Response
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set company name
        $sheet->setCellValue('A1', 'Wahana Artha Group')
            ->mergeCells('A1:I1');
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I1')->getFont()->setBold(true)->setSize(14);

        // set filename
        $sheet->setCellValue('A2', 'Purchase Payments Report')
            ->mergeCells('A2:I2');
        $sheet->getStyle('A2:I2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2:I2')->getFont()->setSize(12);

        // Set period
        $sheet->setCellValue('A3', "Period: $startDate to $endDate")
            ->mergeCells('A3:I3');
        $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3:I3')->getFont()->setItalic(true);

        // Set header
        $sheet->setCellValue('A5', 'Id');
        $sheet->setCellValue('B5', 'Purchase Transaction Id');
        $sheet->setCellValue('C5', 'Payment Method');
        $sheet->setCellValue('D5', 'Status');
        $sheet->setCellValue('E5', 'Proof');
        $sheet->setCellValue('F5', 'Nominal');
        $sheet->setCellValue('G5', 'Payment Date');
        $sheet->setCellValue('H5', 'Created');
        $sheet->setCellValue('I5', 'Modified');
        $sheet->getStyle('A5:I5')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A5:I5')->getFont()->setBold(true);

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(15);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);

        // Set data
        $row = 6;
        foreach ($purchasePayments as $payment) {
            $sheet->setCellValue("A{$row}", $payment->id);
            $sheet->setCellValue("B{$row}", $payment->purchase_transaction->id);
            $sheet->setCellValue("C{$row}", $payment->payment_method);
            $sheet->setCellValue("D{$row}", $payment->status);
            $sheet->setCellValue("E{$row}", $payment->proof);
            $sheet->setCellValue("F{$row}", $payment->nominal);
            $sheet->setCellValue("G{$row}", $payment->payment_date->format('Y-m-d H:i:s'));
            $sheet->setCellValue("H{$row}", $payment->created);
            $sheet->setCellValue("I{$row}", $payment->modified);
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