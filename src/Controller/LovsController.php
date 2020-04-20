<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Lovs Controller
 *
 * @property \App\Model\Table\LovsTable $Lovs
 *
 * @method \App\Model\Entity\Lov[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LovsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SystemUsers'],
        ];
        $lovs = $this->paginate($this->Lovs);

        $this->set(compact('lovs'));
    }

    /**
     * View method
     *
     * @param string|null $id Lov id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lov = $this->Lovs->get($id, [
            'contain' => ['SystemUsers'],
        ]);

        $this->set('lov', $lov);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lov = $this->Lovs->newEntity();
        if ($this->request->is('post')) {
            $lov = $this->Lovs->patchEntity($lov, $this->request->getData());
            if ($this->Lovs->save($lov)) {
                $this->Flash->success(__('The lov has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lov could not be saved. Please, try again.'));
        }
        $systemUsers = $this->Lovs->SystemUsers->find('list', ['limit' => 200]);
        $this->set(compact('lov', 'systemUsers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lov id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lov = $this->Lovs->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lov = $this->Lovs->patchEntity($lov, $this->request->getData());
            if ($this->Lovs->save($lov)) {
                $this->Flash->success(__('The lov has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lov could not be saved. Please, try again.'));
        }
        $systemUsers = $this->Lovs->SystemUsers->find('list', ['limit' => 200]);
        $this->set(compact('lov', 'systemUsers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lov id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lov = $this->Lovs->get($id);
        if ($this->Lovs->delete($lov)) {
            $this->Flash->success(__('The lov has been deleted.'));
        } else {
            $this->Flash->error(__('The lov could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
