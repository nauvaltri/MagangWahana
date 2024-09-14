<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Customers Controller
 *
 * @property \App\Model\Table\CustomersTable $Customers
 * @method \App\Model\Entity\Customer[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CustomersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Customers = $this->fetchTable('Customers');  // Inisialisasi model
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
            'contain' => ['Employees'],
        ];
        $customers = $this->paginate($this->Customers);

        $this->set(compact('customers'));
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
        $query = $this->Customers->find()
            ->where([
                'created >=' => $startDate,
                'created <=' => $endDate
            ]);

        // Gunakan paginate dengan query builder yang sudah difilter
        $customers = $this->paginate($query);

        // Kirim data ke view
        $this->set(compact('customers', 'startDate', 'endDate'));
    }

    /**
     * View method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => ['SaleTransactions', 'CreatedByEmployee', 'ModifiedByEmployee'],
        ]);

        $this->set(compact('customer'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $customer = $this->Customers->newEmptyEntity();
        if ($this->request->is('post')) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());

            $session = $this->getRequest()->getSession();
            // Memeriksa keberadaan data authentikasi ID Employee di session
            if ($session->check('Auth.id')) {
                // Data Session tersedia
                $employeeId = $session->read('Auth.id');
                $customer->created_by = $employeeId;
                $customer->modified_by = $employeeId;
            } else {
                // Data Session tidak tersedia
                $this->Flash->error(__('Your session has expired. Please log in again.'));
                return $this->redirect([
                    'controller' => 'Employees',
                    'action' => 'login',
                    'login'
                ]);
            }

            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $this->set(compact('customer'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $customer = $this->Customers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $customer = $this->Customers->patchEntity($customer, $this->request->getData());

            $session = $this->getRequest()->getSession();
            // Memeriksa keberadaan data authentikasi ID Employee di session
            if ($session->check('Auth.id')) {
                // Data Session tersedia
                $employeeId = $session->read('Auth.id');
                $customer->modified_by = $employeeId;
            } else {
                // Data Session tidak tersedia
                $this->Flash->error(__('Your session has expired. Please log in again.'));
                return $this->redirect([
                    'controller' => 'Employees',
                    'action' => 'login',
                    'login'
                ]);
            }

            // Cegah perubahan pada field created_by
            unset($customer->created_by);

            if ($this->Customers->save($customer)) {
                $this->Flash->success(__('The customer has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The customer could not be saved. Please, try again.'));
        }
        $this->set(compact('customer'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Customer id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $customer = $this->Customers->get($id);
        if ($this->Customers->delete($customer)) {
            $this->Flash->success(__('The customer has been deleted.'));
        } else {
            $this->Flash->error(__('The customer could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}