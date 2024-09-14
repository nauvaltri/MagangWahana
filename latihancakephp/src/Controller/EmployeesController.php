<?php

declare(strict_types=1);

namespace App\Controller;

use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Employees Controller
 *
 * @property \App\Model\Table\EmployeesTable $Employees
 * @method \App\Model\Entity\Employee[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmployeesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication'); // Memuat AuthenticationComponent
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $employees = $this->paginate($this->Employees);

        $this->set(compact('employees'));
    }

    /**
     * View method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => ['Customers', 'PurchaseTransactions', 'SaleTransactions'],
        ]);

        $this->set(compact('employee'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $employee = $this->Employees->newEmptyEntity();
        if ($this->request->is('post')) {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $this->set(compact('employee'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $employee = $this->Employees->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $employee = $this->Employees->patchEntity($employee, $this->request->getData());
            if ($this->Employees->save($employee)) {
                $this->Flash->success(__('The employee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The employee could not be saved. Please, try again.'));
        }
        $this->set(compact('employee'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Employee id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $employee = $this->Employees->get($id);
        if ($this->Employees->delete($employee)) {
            $this->Flash->success(__('The employee has been deleted.'));
        } else {
            $this->Flash->error(__('The employee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Mengizinkan aksi login untuk pengguna yang belum terautentikasi
        $this->Authentication->addUnauthenticatedActions(['login']);
    }

    public function login()
    {
        // Mengizinkan metode GET dan POST untuk login
        $this->request->allowMethod(['get', 'post']);

        // Cek apakah ini adalah request POST
        if ($this->request->is('post')) {
            // Mendapatkan data dari form
            $username = $this->request->getData('username'); // Bisa username atau email
            $password = $this->request->getData('password');

            // Cek apakah form memiliki nilai username dan password
            if (!empty($username) && !empty($password)) {
                // Mencari employee berdasarkan username atau email
                $employee = $this->Employees->find('auth', ['username' => $username])->first();

                // Jika employee ditemukan dan password sesuai
                if ($employee && password_verify($password, $employee->password)) {
                    // Set session atau autentikasi di sini, misalnya menggunakan plugin Authentication
                    $this->Authentication->setIdentity($employee);

                    //create session users
                    $authUser = $this->Authentication->getIdentity();
                    $session = $this->getRequest()->getSession();
                    $session->write('Auth.id', $authUser->get('id'));

                    // Redirect ke halaman yang diminta atau default
                    $redirect = $this->request->getQuery('redirect', [
                        'controller' => 'Pages',
                        'action' => 'display',
                        'home'
                    ]);

                    return $this->redirect($redirect);
                }

                // Jika autentikasi gagal
                return $this->Flash->error(__('Username atau password tidak valid'));
            }

            // Jika autentikasi gagal
            return $this->Flash->error(__('Username atau password harus diisi'));
        }

        // Jika GET request, tampilkan form login
    }


    public function logout()
    {
        // Cek apakah pengguna sudah terautentikasi sebelum logout
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();
            // Menghapus semua data session
            $session = $this->getRequest()->getSession();
            $session->destroy();
            return $this->redirect(['controller' => 'Employees', 'action' => 'login']);
        }
    }

    // Method untuk meng-hash password yang sudah ada. Fungsi sekali pakai !!! http://localhost:8765/employees/hashExistingPasswords
    // public function hashExistingPasswords()
    // {
    //     // Ambil semua karyawan yang masih menggunakan password "rahasia"
    //     $employees = $this->Employees->find('all')->where(['password' => 'rahasia']);

    //     // Lakukan hash pada password "rahasia"
    //     foreach ($employees as $employee) {
    //         $hashedPassword = (new DefaultPasswordHasher())->hash('rahasia');
    //         $employee->password = $hashedPassword;
    //         $this->Employees->save($employee);
    //     }

    //     // Berikan notifikasi bahwa password sudah diperbarui
    //     $this->Flash->success(__('Passwords have been updated.'));

    //     // Redirect ke halaman lain setelah selesai
    //     return $this->redirect(['action' => 'index']);
    // }
}