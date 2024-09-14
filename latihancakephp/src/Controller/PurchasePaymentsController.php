<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * PurchasePayments Controller
 *
 * @property \App\Model\Table\PurchasePaymentsTable $PurchasePayments
 * @method \App\Model\Entity\PurchasePayment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PurchasePaymentsController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->PurchasePayments = $this->fetchTable('PurchasePayments');  // Inisialisasi model
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
            'contain' => ['PurchaseTransactions'],
        ];
        $purchasePayments = $this->paginate($this->PurchasePayments);

        $this->set(compact('purchasePayments'));
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
        $query = $this->PurchasePayments->find()
            ->where([
                'payment_date >=' => $startDate,
                'payment_date <=' => $endDate
            ])
            ->contain(['PurchaseTransactions']);

        // Gunakan paginate dengan query builder yang sudah difilter
        $purchasePayments = $this->paginate($query);

        // Kirim data ke view
        $this->set(compact('purchasePayments', 'startDate', 'endDate'));
    }

    /**
     * View method
     *
     * @param string|null $id Purchase Payment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $purchasePayment = $this->PurchasePayments->get($id, [
            'contain' => ['PurchaseTransactions'],
        ]);

        $this->set(compact('purchasePayment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $purchasePayment = $this->PurchasePayments->newEmptyEntity();
        if ($this->request->is('post')) {
            $purchasePayment = $this->PurchasePayments->patchEntity($purchasePayment, $this->request->getData());
            if ($this->PurchasePayments->save($purchasePayment)) {
                $this->Flash->success(__('The purchase payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase payment could not be saved. Please, try again.'));
        }
        $purchaseTransactions = $this->PurchasePayments->PurchaseTransactions->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $this->set(compact('purchasePayment', 'purchaseTransactions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Purchase Payment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $purchasePayment = $this->PurchasePayments->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $purchasePayment = $this->PurchasePayments->patchEntity($purchasePayment, $this->request->getData());
            if ($this->PurchasePayments->save($purchasePayment)) {
                $this->Flash->success(__('The purchase payment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The purchase payment could not be saved. Please, try again.'));
        }
        $purchaseTransactions = $this->PurchasePayments->PurchaseTransactions->find('list', [
            'keyField' => 'id',
            'valueField' => 'full_description'  // Menggunakan virtual field
        ])->toArray();
        $this->set(compact('purchasePayment', 'purchaseTransactions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Purchase Payment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $purchasePayment = $this->PurchasePayments->get($id);
        if ($this->PurchasePayments->delete($purchasePayment)) {
            $this->Flash->success(__('The purchase payment has been deleted.'));
        } else {
            $this->Flash->error(__('The purchase payment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}