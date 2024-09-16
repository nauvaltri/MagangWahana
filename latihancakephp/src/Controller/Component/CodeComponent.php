<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\ModelAwareTrait;

class CodeComponent extends Component
{
    use ModelAwareTrait;

    public function generateCodePCTS($transactionDate, $transactionType = 'PCTS')
    {
        // Format tanggal menjadi tahun dan bulan
        $yearMonth = $transactionDate->format('ym'); // Tahun dan bulan dari transaction_date

        // Ambil transaksi terakhir di bulan dan tahun yang sama
        $this->loadModel('PurchaseTransactions');
        $lastTransaction = $this->PurchaseTransactions->find('all', [
            'conditions' => [
                'YEAR(transaction_date)' => $transactionDate->year,
                'MONTH(transaction_date)' => $transactionDate->month
            ],
            'order' => ['code' => 'DESC']
        ])->first();

        // Jika ada transaksi di bulan dan tahun tersebut, ambil nomor urut terakhir
        if ($lastTransaction) {
            // Ambil 6 digit terakhir sebagai nomor urut
            $lastNumber = (int) substr($lastTransaction->code, -6);
            $newNumber = $lastNumber + 1;
        } else {
            // Jika belum ada transaksi, mulai dengan nomor urut 1
            $newNumber = 1;
        }

        // Format nomor urut menjadi 6 digit dengan padding 0
        $formattedNumber = str_pad($newNumber, 6, '0', STR_PAD_LEFT);

        // Gabungkan semuanya menjadi kode transaksi
        return $transactionType . $yearMonth . $formattedNumber;
    }

    public function generateCodeSLTS($transactionDate, $transactionType = 'SLTS')
    {
        // Format tanggal menjadi tahun dan bulan
        $yearMonth = $transactionDate->format('ym'); // Tahun dan bulan dari transaction_date

        // Ambil transaksi terakhir di bulan dan tahun yang sama
        $this->loadModel('SaleTransactions');
        $lastTransaction = $this->SaleTransactions->find('all', [
            'conditions' => [
                'YEAR(transaction_date)' => $transactionDate->year,
                'MONTH(transaction_date)' => $transactionDate->month
            ],
            'order' => ['code' => 'DESC']
        ])->first();

        // Jika ada transaksi di bulan dan tahun tersebut, ambil nomor urut terakhir
        if ($lastTransaction) {
            // Ambil 6 digit terakhir sebagai nomor urut
            $lastNumber = (int) substr($lastTransaction->code, -6);
            $newNumber = $lastNumber + 1;
        } else {
            // Jika belum ada transaksi, mulai dengan nomor urut 1
            $newNumber = 1;
        }

        // Format nomor urut menjadi 6 digit dengan padding 0
        $formattedNumber = str_pad($newNumber, 6, '0', STR_PAD_LEFT);

        // Gabungkan semuanya menjadi kode transaksi
        return $transactionType . $yearMonth . $formattedNumber;
    }
}