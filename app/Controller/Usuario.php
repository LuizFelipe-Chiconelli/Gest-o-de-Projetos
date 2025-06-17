<?php
/*--------------------------------------------------------------
 |  Controller Usuário — CRUD + “trocar senha”
 +-------------------------------------------------------------*/
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class Usuario extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarConstruct();
        $this->loadHelper(['formHelper','tabela']);
        $this->validaNivelAcesso(11);          // apenas níveis 1 ou 11
    }

    /* ============ LISTA ===================================== */
    public function index()
    {
        $dados = $this->model->lista('nome');
        return $this->loadView('sistema/listaUsuario',$dados);
    }

    /* ============ FORM ====================================== */
    public function form(?string $action=null, ?int $id=null)
    {
        $dados = ($this->action==='insert')
               ? ['nivel'=>21,'trocarSenha'=>'S','statusRegistro'=>1]
               : $this->model->getById($id);

        return $this->loadView('sistema/formUsuario',$dados);
    }

    /* ============ INSERT ==================================== */
    public function insert()
    {
        $post = $this->request->getPost();

        /* senha obrigatória no cadastro */
        if (empty($post['senha'])) {
            Session::set('errors',['senha'=>'Preencha a senha.']);
            Session::set('inputs',$post);
            return Redirect::page('usuario/form/insert/0');
        }

        unset($post['action'],$post['confSenha']);
        $post['senha'] = password_hash($post['senha'],PASSWORD_DEFAULT);

        $ok = $this->model->insert($post);

        return Redirect::page('usuario',
            $ok ? ['msgSucesso'=>'Inserido com sucesso.'] : []);
    }

    /* ============ UPDATE ==================================== */
    public function update()
    {
        $post = $this->request->getPost();
        unset($post['action'],$post['confSenha']);

        /* senha só muda se veio algo */
        if (empty($post['senha'])) {
            unset($post['senha']);
        } else {
            $post['senha'] = password_hash($post['senha'],PASSWORD_DEFAULT);
        }

        $ok = $this->model->update($post);

        return Redirect::page('usuario',
            $ok ? ['msgSucesso'=>'Alterado com sucesso.'] : []);
    }

    /* ============ DELETE ==================================== */
    public function delete()
    {
        $ok = $this->model->delete($this->request->getPost());

        return Redirect::page('usuario',
            $ok ? ['msgSucesso'=>'Excluído.']
                : ['msgError'=>'Falha ao excluir.']);
    }

    /* ============ TROCAR SENHA — form ======================= */
    public function formTrocarSenha()
    {
        return $this->loadView('sistema/formTrocarSenha');
    }

    /* ============ TROCAR SENHA — grava ====================== */
    public function updateNovaSenha()
    {
        $post      = $this->request->getPost();
        $userAtual = $this->model->getById($post['id']);

        if (!$userAtual) {
            return Redirect::page('usuario/formTrocarSenha',
                ['msgError'=>'Usuário inválido.']);
        }

        if (!password_verify(trim($post['senhaAtual']),$userAtual['senha'])) {
            return Redirect::page('usuario/formTrocarSenha',
                ['msgError'=>'Senha atual não confere.']);
        }

        if (trim($post['novaSenha']) !== trim($post['novaSenha2'])) {
            return Redirect::page('usuario/formTrocarSenha',
                ['msgError'=>'Nova senha e confirmação divergem.']);
        }

        $novaHash = password_hash(trim($post['novaSenha']),PASSWORD_DEFAULT);
        $ok = $this->model->db
                ->where(['id'=>$post['id']])
                ->update(['senha'=>$novaHash]);

        if ($ok) Session::set('userSenha',$novaHash);

        return Redirect::page('usuario/formTrocarSenha',
            $ok ? ['msgSucesso'=>'Senha alterada com sucesso!']
                : ['msgError'=>'Falha ao alterar senha.']);
    }
}
