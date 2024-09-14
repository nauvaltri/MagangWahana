<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * SalePayments Controller
 *
 * @property \App\Model\Table\SalePaymentsTable $SalePayments
 * @method \App\Model\Entity\SalePayment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SalePaymentsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->SalePayments = $this->fetchTable('SalePayments');  // Inisialisasi model
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
            'contain' => ['SaleTransactions'],
        ];
        $salePayments = $this->paginate($this->SalePayments);

        $this->set(compact('salePayments'));
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
        $query = $this->SalePayments->find()
            ->where([
                'payment_date >=' => $startDate,
                'payment_date <=' => $endDate
            ])
            ->contain(['SaleTransactions']);

        // Gunakan paginate dengan query builder yang sudah difilter
        $salePayments = $this->paginate($query);

        // Kirim data ke view
        $this->set(compact('salePayments', 'startDate', 'endDate'));
    }

    /**
     * View method
     *
     * @param string|null $id Sale Payment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $salePayment = $this->SalePayments->get($id, [
            'contain' => ['SaleTransactions'],
        ]);

        $this->set(compact('salePayment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $salePayment = $this->SalePayments->newEmptyEntity();
        if ($this->request->is('post')) {
            $salePayment = $this->SalePayments->patchEntity($salePayment, $this->request->getData());
            if ($this->SalePayments->save($salePayment)) {
                $this->Flash->success(__('The sale payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale payment could not be saved. Please, try again.'));
        }
        $saleTransactions = $this->SalePayments->SaleTransactions->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $this->set(compact('salePayment', 'saleTransactions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sale Payment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $salePayment = $this->SalePayments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $salePayment = $this->SalePayments->patchEntity($salePayment, $this->request->getData());
            if ($this->SalePayments->save($salePayment)) {
                $this->Flash->success(__('The sale payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sale payment could not be saved. Please, try again.'));
        }
        $saleTransactions = $this->SalePayments->SaleTransactions->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $this->set(compact('salePayment', 'saleTransactions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sale Payment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $salePayment = $this->SalePayments->get($id);
        if ($this->SalePayments->delete($salePayment)) {
            $this->Flash->success(__('The sale payment has been deleted.'));
        } else {
            $this->Flash->error(__('The sale payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}