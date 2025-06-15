<?php
/*------------------------------------------------------------------------
 | Controller  Usuário
 | – CRUD completo + troca de senha
 | – Somente Super-Admin (1) ou Admin (11) entram neste controller
 |   (validação feita no construtor)
 +-----------------------------------------------------------------------*/
namespace App\Controller;

use Core\Library\ControllerMain;   // classe-mãe (helpers, validator…)
use Core\Library\Redirect;         // redireciona com mensagens
use Core\Library\Session;          // leitura / gravação de sessão

class Usuario extends ControllerMain
{
    /*------------------------------------------------------------
     | CONSTRUTOR
     | • carrega Model + helpers
     | • bloqueia quem não for nível 1 ou 11
     +----------------------------------------------------------*/
    public function __construct()
    {
        $this->auxiliarConstruct();            // carrega Model + Request
        $this->loadHelper(['formHelper','tabela']);
        $this->validaNivelAcesso();            // default 20 → só 1 e 11 passam
    }

    /* LISTA ----------------------------------------------------*/
    public function index()
    {
        // lista todos os usuários ordenados por nome
        $dados = $this->model->lista('nome');
        return $this->loadView('sistema/listaUsuario', $dados);
    }

    /* FORM NOVO / EDITAR --------------------------------------*/
    public function form(?string $action = null, ?int $id = null)
    {
        // se “novo” envia valores default; senão busca do banco
        $dados = ($this->action === 'insert')
               ? ['nivel'=>21,'trocarSenha'=>'S','statusRegistro'=>1]
               : $this->model->getById($id);

        return $this->loadView('sistema/formUsuario', $dados);
    }

    /* INSERT ---------------------------------------------------*/
    public function insert()
    {
        $post = $this->request->getPost();

        // senha obrigatória no insert
        if (empty($post['senha'])) {
            Session::set('errors',['senha'=>'Preencha a senha.']);
            Session::set('inputs',$post);
            return Redirect::page('usuario/form/insert/0');
        }

        unset($post['confSenha']);                       // tira confirmação
        $post['senha'] = password_hash($post['senha'],PASSWORD_DEFAULT);

        $ok = $this->model->insert($post);

        return Redirect::page('usuario',
            $ok ? ['msgSucesso'=>'Inserido com sucesso.'] : []);
    }

    /* UPDATE ---------------------------------------------------*/
    public function update()
    {
        $post = $this->request->getPost();
        unset($post['confSenha']);

        // só muda senha se veio algo
        if (empty($post['senha'])) {
            unset($post['senha']);
        } else {
            $post['senha'] = password_hash($post['senha'],PASSWORD_DEFAULT);
        }

        $ok = $this->model->update($post);

        return Redirect::page('usuario',
            $ok ? ['msgSucesso'=>'Registro atualizado com sucesso.'] : []);
    }

    /* DELETE ---------------------------------------------------*/
    public function delete()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->delete(['id'=>$post['id']]);

        return Redirect::page('usuario',
            $ok ? ['msgSucesso'=>'Excluído com sucesso.']
                : ['msgError'=>'Falha ao excluir.']);
    }

    /* FORMULARIO TROCAR SENHA (próprio usuário) ---------------*/
    public function formTrocarSenha()
    {
        return $this->loadView('sistema/formTrocarSenha');
    }

    /* ATUALIZA SENHA (próprio usuário) ------------------------*/
    public function updateNovaSenha()
    {
        $post      = $this->request->getPost();
        $userAtual = $this->model->getById($post['id']);

        if (!$userAtual) {
            return Redirect::page('usuario/formTrocarSenha',
                ['msgError'=>'Usuário inválido.']);
        }

        // confere senha atual
        if (!password_verify(trim($post['senhaAtual']), $userAtual['senha'])) {
            return Redirect::page('usuario/formTrocarSenha',
                ['msgError'=>'Senha atual não confere.']);
        }

        // confere nova = confirmação
        if (trim($post['novaSenha']) !== trim($post['novaSenha2'])) {
            return Redirect::page('usuario/formTrocarSenha',
                ['msgError'=>'Nova senha e confirmação divergem.']);
        }

        // grava nova senha
        $novaHash = password_hash(trim($post['novaSenha']), PASSWORD_DEFAULT);
        $ok = $this->model->db
                ->where(['id'=>$post['id']])
                ->update(['senha'=>$novaHash]);

        if ($ok) Session::set('userSenha', $novaHash);

        return Redirect::page('usuario/formTrocarSenha',
            $ok ? ['msgSucesso'=>'Senha alterada com sucesso!']
                : ['msgError'=>'Falha ao alterar senha.']);
    }
}
