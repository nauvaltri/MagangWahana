<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * SaleTransactions Controller
 *
 * @property \App\Model\Table\SaleTransactionsTable $SaleTransactions
 * @method \App\Model\Entity\SaleTransaction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SaleTransactionsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->SaleTransactions = $this->fetchTable('SaleTransactions');  // Inisialisasi model
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
            'contain' => ['Employees', 'Customers', 'Stocks'],
        ];
        $saleTransactions = $this->paginate($this->SaleTransactions);

        $this->set(compact('saleTransactions'));
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
        $query = $this->SaleTransactions->find()
            ->where([
                'transaction_date >=' => $startDate,
                'transaction_date <=' => $endDate
            ])
            ->contain(['Employees', 'Customers', 'Stocks']);

        // Gunakan paginate dengan query builder yang sudah difilter
        $saleTransactions = $this->paginate($query);

        // Kirim data ke view
        $this->set(compact('saleTransactions', 'startDate', 'endDate'));
    }

    /**
     * View method
     *
     * @param string|null $id Sale Transaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $saleTransaction = $this->SaleTransactions->get($id, [
            'contain' => ['Employees', 'Customers', 'Stocks', 'SalePayments'],
        ]);

        $this->set(compact('saleTransaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $saleTransaction = $this->SaleTransactions->newEmptyEntity();
        if ($this->request->is('post')) {
            $saleTransaction = $this->SaleTransactions->patchEntity($saleTransaction, $this->request->getData());
            if ($this->SaleTransactions->save($saleTransaction)) {
                $this->Flash->success(__('The sale transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale transaction could not be saved. Please, try again.'));
        }
        $employees = $this->SaleTransactions->Employees->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $customers = $this->SaleTransactions->Customers->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $stocks = $this->SaleTransactions->Stocks->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $this->set(compact('saleTransaction', 'employees', 'customers', 'stocks'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sale Transaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $saleTransaction = $this->SaleTransactions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $saleTransaction = $this->SaleTransactions->patchEntity($saleTransaction, $this->request->getData());
            if ($this->SaleTransactions->save($saleTransaction)) {
                $this->Flash->success(__('The sale transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale transaction could not be saved. Please, try again.'));
        }
        $employees = $this->SaleTransactions->Employees->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $customers = $this->SaleTransactions->Customers->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $stocks = $this->SaleTransactions->Stocks->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $this->set(compact('saleTransaction', 'employees', 'customers', 'stocks'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sale Transaction id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $saleTransaction = $this->SaleTransactions->get($id);
        if ($this->SaleTransactions->delete($saleTransaction)) {
            $this->Flash->success(__('The sale transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The sale transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}