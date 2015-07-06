<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Clinicas Controller
 *
 * @property \App\Model\Table\ClinicasTable $Clinicas
 */
class ClinicasController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('clinicas', $this->paginate($this->Clinicas));
        $this->set('_serialize', ['clinicas']);
    }

    /**
     * View method
     *
     * @param string|null $id Clinica id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $clinica = $this->Clinicas->get($id, [
            'contain' => ['Consultorios', 'Medicos', 'Secretarias']
        ]);
        $this->set('clinica', $clinica);
        $this->set('_serialize', ['clinica']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $clinica = $this->Clinicas->newEntity();
        if ($this->request->is('post')) {
            $clinica = $this->Clinicas->patchEntity($clinica, $this->request->data);
            if ($this->Clinicas->save($clinica)) {
                $this->Flash->success(__('The clinica has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The clinica could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('clinica'));
        $this->set('_serialize', ['clinica']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Clinica id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $clinica = $this->Clinicas->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $clinica = $this->Clinicas->patchEntity($clinica, $this->request->data);
            if ($this->Clinicas->save($clinica)) {
                $this->Flash->success(__('The clinica has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The clinica could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('clinica'));
        $this->set('_serialize', ['clinica']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Clinica id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $clinica = $this->Clinicas->get($id);
        if ($this->Clinicas->delete($clinica)) {
            $this->Flash->success(__('The clinica has been deleted.'));
        } else {
            $this->Flash->error(__('The clinica could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
