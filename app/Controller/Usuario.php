<?php
/**
 * Controller: Usuario
 * Responsável pelo CRUD de usuários (Admin, Professor, Aluno)
 *  – nível 11 = Administrador
 *  – nível 21 = Professor
 *  – nível 31 = Aluno
 */

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Session;
use Core\Library\Redirect;

class Usuario extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();                 // carrega helpers / sessão / etc.
        $this->loadHelper(['formHelper','tabela']);

        // Métodos que QUALQUER usuário logado pode acessar
        $rotasLivres = ['formTrocarSenha', 'updateNovaSenha', 'registraUsuario'];

        $metodo = $this->request->getRotaParametros()['method'] ?? '';
        $acao   = $this->action ?? '';

        // Demais métodos exigem nível ≤ 11 (administrador) ou ≤ 21 (professor)
        if (!in_array($metodo, $rotasLivres, true) && !in_array($acao, $rotasLivres, true)) {
            $this->validaNivelAcesso(11);
        }
    }

    /* ============================================================
     *  LISTA & FORMULÁRIOS
     * ============================================================ */

    public function index()
    {
        $dados = $this->model->lista('nome');
        return $this->loadView('sistema/listas/listaUsuario', $dados);
    }

    /**
     * Formulário de Insert ou Update
     * /usuario/form/{insert|update}/{id}
     */
    public function form(string $action = 'insert', int $id = 0)
    {
        if ($action === 'insert') {
            $usuario = [
                'id'             => 0,
                'nome'           => '',
                'email'          => '',
                'statusRegistro' => 1,
                'nivel'          => 11
            ];
        } else {
            $usuario = $this->model->getById($id);
            if (!$usuario) {
                Session::set('msgError', 'Usuário não encontrado.');
                return Redirect::page('usuario');
            }
        }

        return $this->loadView('sistema/formularios/formUsuario',
            array_merge($usuario, ['formAction'=>$action])
        );
    }

    /* ============================================================
     *  INSERT
     * ============================================================ */

    public function insert()
    {
        $p = $this->request->getPost();

        // senha obrigatória no insert
        if (empty($p['senha'])) {
            Session::set('errors', ['senha'=>'Preencha a senha.']);
            Session::set('inputs', $p);
            return Redirect::page('usuario/form/insert/0');
        }

        // e‑mail único
        if ($this->model->db->where('email', $p['email'])->first()) {
            Session::set('errors', ['email'=>'E‑mail já cadastrado.']);
            Session::set('inputs', $p);
            return Redirect::page('usuario/form/insert/0');
        }

        $dados = [
            'nome'           => trim($p['nome']),
            'email'          => strtolower(trim($p['email'])),
            'senha'          => password_hash($p['senha'], PASSWORD_DEFAULT),
            'nivel'          => 11,
            'statusRegistro' => 1
        ];

        $id = $this->model->insertReturnId($dados);
        return Redirect::page('usuario',
            $id ? ['msgSucesso'=>'Administrador criado com sucesso.']
                : ['msgError'  =>'Erro ao inserir usuário.']
        );
    }

    /* ============================================================
     *  UPDATE
     * ============================================================ */

    public function update()
    {
        $p  = $this->request->getPost();
        $id = (int) $p['id'];

        $usuarioAtual = $this->model->getById($id);
        if (!$usuarioAtual) {
            return Redirect::page('usuario', ['msgError'=>'Usuário não encontrado.']);
        }

        // monta dados
        $set = [
            'nome'           => trim($p['nome']),
            'email'          => strtolower(trim($p['email'])),
            'statusRegistro' => (int) $p['statusRegistro']
        ];
        if (!empty($p['senha'])) {
            $set['senha'] = password_hash($p['senha'], PASSWORD_DEFAULT);
        }

        $ok = $this->model->db->where('id',$id)->update($set);

        // espelha nome/email se for professor ou aluno
        $nivel = (int) $usuarioAtual['nivel'];
        $espelho = ['nome'=>$set['nome'], 'email'=>$set['email']];
        if ($nivel === 31) {
            $this->loadModel('Aluno')->db->where('usuario_id',$id)->update($espelho);
        } elseif ($nivel === 21) {
            $this->loadModel('Professor')->db->where('usuario_id',$id)->update($espelho);
        }

        return Redirect::page('usuario',
            $ok ? ['msgSucesso'=>'Dados atualizados com sucesso.']
                : ['msgSucesso'=>'Nenhum campo alterado.']
        );
    }

    /* ============================================================
     *  DELETE
     * ============================================================ */

    public function delete()
    {
        $id = (int) ($this->request->getPost()['userId'] ?? 0);
        if ($id === 0) {
            return Redirect::page('usuario', ['msgError'=>'ID inválido.']);
        }

        $usuario = $this->model->getById($id);
        if (!$usuario) {
            return Redirect::page('usuario', ['msgError'=>'Usuário não encontrado.']);
        }

        // apaga vínculos
        $nivel = (int) $usuario['nivel'];
        if ($nivel === 31) {
            $this->loadModel('Aluno')->db->where('usuario_id',$id)->delete();
        } elseif ($nivel === 21) {
            $this->loadModel('Professor')->db->where('usuario_id',$id)->delete();
        }

        $ok = $this->model->db->where('id',$id)->delete();
        return Redirect::page('usuario',
            $ok ? ['msgSucesso'=>'Usuário excluído com sucesso.']
                : ['msgError'  =>'Falha ao excluir usuário.']
        );
    }

    /* ============================================================
     *  TROCA DE SENHA (próprio usuário)
     * ============================================================ */

    public function formTrocarSenha()
    {
        if (!Session::get('userId')) {
            return Redirect::page('login', ['msgError'=>'Faça login para trocar a senha.']);
        }
        return $this->loadView('sistema/formularios/formTrocarSenha');
    }

    public function updateNovaSenha()
    {
        $p         = $this->request->getPost();
        $userAtual = $this->model->getById($p['id']);

        if (!$userAtual) {
            return Redirect::page('usuario/formTrocarSenha', ['msgError'=>'Usuário inválido.']);
        }
        if (!password_verify(trim($p['senhaAtual']), $userAtual['senha'])) {
            return Redirect::page('usuario/formTrocarSenha', ['msgError'=>'Senha atual não confere.']);
        }
        if (trim($p['novaSenha']) !== trim($p['novaSenha2'])) {
            return Redirect::page('usuario/formTrocarSenha', ['msgError'=>'Nova senha e confirmação divergem.']);
        }

        $nova = password_hash(trim($p['novaSenha']), PASSWORD_DEFAULT);
        $ok = $this->model->db->where('id',$p['id'])->update(['senha'=>$nova]);
        if ($ok) Session::set('userSenha', $nova);

        return Redirect::page('usuario/formTrocarSenha',
            $ok ? ['msgSucesso'=>'Senha alterada com sucesso!']
                : ['msgError'  =>'Falha ao alterar senha.']
        );
    }

    /* ============================================================
     *  REGISTRO PÚBLICO (aluno/professor)
     * ============================================================ */

    public function registraUsuario()
    {
        $p = $this->request->getPost();
        if ($p['register-password'] !== $p['confirm-register-password']) {
            Session::set('errors', ['senha'=>'As senhas não conferem.']);
            Session::set('inputs', $p);
            return Redirect::page('login/cadastro');
        }

        $dados = [
            'nome'           => $p['register-name'],
            'email'          => $p['register-email'],
            'senha'          => password_hash($p['register-password'], PASSWORD_DEFAULT),
            'nivel'          => (int) $p['nivel'],
            'statusRegistro' => 1
        ];

        $id = $this->model->insertReturnId($dados);
        if (!$id) {
            return Redirect::page('login/cadastro', ['msgError'=>'Erro ao cadastrar.']);
        }

        // vincula em aluno ou professor
        if ($dados['nivel'] === 31) {
            $this->loadModel('Aluno')->insert([
                'nome'           => $dados['nome'],
                'email'          => $dados['email'],
                'curso'          => $p['curso'] ?? 'Não informado',
                'ra'             => uniqid(),
                'usuario_id'     => $id,
                'statusRegistro' => 1
            ]);
        } elseif ($dados['nivel'] === 21) {
            $this->loadModel('Professor')->insert([
                'nome'           => $dados['nome'],
                'email'          => $dados['email'],
                'especialidade'  => $p['especialidade'] ?? 'Não informada',
                'area'           => $p['area'] ?? 'Não informada',
                'usuario_id'     => $id,
                'statusRegistro' => 1
            ]);
        }

        return Redirect::page('login', ['msgSucesso'=>'Cadastro realizado com sucesso!']);
    }
}
