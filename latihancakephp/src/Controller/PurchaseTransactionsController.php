<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * PurchaseTransactions Controller
 *
 * @property \App\Model\Table\PurchaseTransactionsTable $PurchaseTransactions
 * @method \App\Model\Entity\PurchaseTransaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchaseTransactionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->PurchaseTransactions = $this->fetchTable('PurchaseTransactions');  // Inisialisasi model
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

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Employees', 'Purchases'],
        ];
        $purchaseTransactions = $this->paginate($this->PurchaseTransactions);

        $this->set(compact('purchaseTransactions'));
    }

    public function latihan()
    {
        // Tangkap start_date dan end_date dari query string
        $startDate = $this->request->getQuery('start_date');
        $endDate = $this->request->getQuery('end_date');

        // Jika tidak ada input tanggal, atur nilai default
        if (empty($startDate)) {
            $startDate = '2024-01-01';  // Default start date
        }
        if (empty($endDate)) {
            $endDate = '2024-12-31';    // Default end date
        }

        // Menggunakan query builder ORM untuk memfilter berdasarkan tanggal
        $query = $this->PurchaseTransactions->find()
            ->where([
                'transaction_date >=' => $startDate,
                'transaction_date <=' => $endDate
            ])
            ->contain(['Employees', 'Purchases']);

        // Gunakan paginate dengan query builder yang sudah difilter
        $purchaseTransactions = $this->paginate($query);

        // Kirim data ke view
        $this->set(compact('purchaseTransactions', 'startDate', 'endDate'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Transaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchaseTransaction = $this->PurchaseTransactions->get($id, [
            'contain' => ['Employees', 'Purchases', 'PurchasePayments'],
        ]);

        $this->set(compact('purchaseTransaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadComponent('Code'); // Load komponen

        $purchaseTransaction = $this->PurchaseTransactions->newEmptyEntity();
        if ($this->request->is('post')) {
            $purchaseTransaction = $this->PurchaseTransactions->patchEntity($purchaseTransaction, $this->request->getData());

            // Panggil komponen untuk generate code berdasarkan transaction_date
            $transactionDate = $purchaseTransaction->transaction_date;
            $purchaseTransaction->code = $this->Code->generateCodePCTS($transactionDate);

            $session = $this->getRequest()->getSession();
            // Memeriksa keberadaan data authentikasi ID Employee di session
            if ($session->check('Auth.id')) {
                // Data Session tersedia
                $employeeId = $session->read('Auth.id');
                $purchaseTransaction->created_by = $employeeId;
                $purchaseTransaction->modified_by = $employeeId;
            } else {
                // Data Session tidak tersedia
                $this->Flash->error(__('Your session has expired. Please log in again.'));
                return $this->redirect([
                    'controller' => 'Employees',
                    'action' => 'login',
                    'login'
                ]);
            }

            if ($this->PurchaseTransactions->save($purchaseTransaction)) {
                $this->Flash->success(__('The purchase transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase transaction could not be saved. Please, try again.'));
        }
        $employees = $this->PurchaseTransactions->Employees->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $purchases = $this->PurchaseTransactions->Purchases->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $this->set(compact('purchaseTransaction', 'employees', 'purchases'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Transaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->loadComponent('TransactionCode'); // Load komponen

        $purchaseTransaction = $this->PurchaseTransactions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchaseTransaction = $this->PurchaseTransactions->patchEntity($purchaseTransaction, $this->request->getData());

            // Periksa jika transaction_date berubah, update kode transaksi
            $transactionDate = $purchaseTransaction->transaction_date;
            $purchaseTransaction->code = $this->Code->generateCodePCTS($transactionDate);

            if ($this->PurchaseTransactions->save($purchaseTransaction)) {
                $this->Flash->success(__('The purchase transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase transaction could not be saved. Please, try again.'));
        }
        $employees = $this->PurchaseTransactions->Employees->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $purchases = $this->PurchaseTransactions->Purchases->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $this->set(compact('purchaseTransaction', 'employees', 'purchases'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Transaction id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchaseTransaction = $this->PurchaseTransactions->get($id);
        if ($this->PurchaseTransactions->delete($purchaseTransaction)) {
            $this->Flash->success(__('The purchase transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}   