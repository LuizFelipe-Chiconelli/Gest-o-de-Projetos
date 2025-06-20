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

        /** Métodos que qualquer usuário logado pode acessar */
        $rotasLivres = ['formTrocarSenha', 'updateNovaSenha'];

        // 1. nome do método corrente que o Router definiu
        $metodo = $this->request->getRotaParametros()['method'] ?? '';

        // 2. action genérica (insert, update...) quando existir
        $acao   = $this->action ?? '';

        // Se NÃO for rota livre ➜ exige privilégio de admin/professor
        if (!in_array($metodo, $rotasLivres, true) &&
            !in_array($acao , $rotasLivres, true)) {

            /* níveis 1-20 (11 = admin, 21 = prof) */
            $this->validaNivelAcesso(11);
        }
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

    // Verificação de senha obrigatória
    if (empty($post['senha'])) {
        Session::set('errors', ['senha' => 'Preencha a senha.']);
        Session::set('inputs', $post);
        return Redirect::page('usuario/form/insert/0');
    }

    // Hash da senha
    unset($post['action'], $post['confSenha']);
    $post['senha'] = password_hash($post['senha'], PASSWORD_DEFAULT);

    // Insere o usuário
    $usuarioId = $this->model->insertReturnId($post); // usa insert que retorna ID
    if (!$usuarioId) {
        return Redirect::page('usuario', ['msgError' => 'Erro ao inserir usuário.']);
    }

    // Verifica o nível e vincula na tabela correta
    if ((int)$post['nivel'] === 31) {
        // Aluno
        $this->loadModel('Aluno')->insert([
            'nome'        => $post['nome'],
            'email'       => $post['email'],
            'curso'       => 'Não informado',
            'ra'          => uniqid(), // ou gere via input
            'usuario_id'  => $usuarioId
        ]);
    } elseif ((int)$post['nivel'] === 21) {
        // Professor
        $this->loadModel('Professor')->insert([
            'nome'        => $post['nome'],
            'email'       => $post['email'],
            'especialidade' => 'Não informada',
            'area'        => 'Não informada',
            'usuario_id'  => $usuarioId
        ]);
    }

        return Redirect::page('usuario', ['msgSucesso' => 'Usuário inserido com sucesso.']);
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

    public function registraUsuario()
    {
    $post = $this->request->getPost();

    // Validação de senha
    if ($post['register-password'] !== $post['confirm-register-password']) {
        Session::set('errors', ['senha' => 'As senhas não conferem.']);
        Session::set('inputs', $post);
        return Redirect::page('login/cadastro');
    }

    // Dados do usuário
    $dados = [
        'nome'           => $post['register-name'],
        'email'          => $post['register-email'],
        'senha'          => password_hash($post['register-password'], PASSWORD_DEFAULT),
        'nivel'          => (int)$post['nivel'],
        'statusRegistro' => 1
    ];

    // Insere usuário
    $usuarioId = $this->model->insertReturnId($dados);
    if (!$usuarioId) {
        return Redirect::page('login/cadastro', ['msgError' => 'Erro ao cadastrar usuário.']);
    }

    // Inserir na tabela de aluno ou professor
    if ($dados['nivel'] === 31) {
        $this->loadModel('Aluno')->insert([
            'nome'            => $dados['nome'],
            'email'           => $dados['email'],
            'curso'           => $post['curso'] ?? 'Não informado',
            'ra'              => uniqid(),
            'usuario_id'      => $usuarioId,
            'statusRegistro'  => 1
        ]);
    } elseif ($dados['nivel'] === 21) {
        $this->loadModel('Professor')->insert([
            'nome'            => $dados['nome'],
            'email'           => $dados['email'],
            'especialidade'   => $post['especialidade'] ?? 'Não informada',
            'area'            => $post['area'] ?? 'Não informada',
            'usuario_id'      => $usuarioId,
            'statusRegistro'  => 1
        ]);
    }

    return Redirect::page('login', ['msgSucesso' => 'Cadastro realizado com sucesso!']);
}

}
