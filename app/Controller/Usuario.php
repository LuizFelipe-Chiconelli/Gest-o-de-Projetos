<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

/**
 * Controller responsável por gerenciar os usuários do sistema
 * Admins e professores têm acesso completo. Alunos podem apenas trocar a própria senha.
 */
class Usuario extends ControllerMain
{
    public function __construct()
    {
        $this->auxiliarConstruct(); // Garante que o sistema esteja pronto

        $this->loadHelper(['formHelper','tabela']); // Helpers para formulários e tabelas

        // Métodos que qualquer usuário logado pode acessar (mesmo aluno)
        $rotasLivres = ['formTrocarSenha', 'updateNovaSenha'];

        // Método atual sendo acessado
        $metodo = $this->request->getRotaParametros()['method'] ?? '';
        $acao   = $this->action ?? '';

        // Se não for método livre, exige nível até 11 (admin) ou 21 (professor)
        if (!in_array($metodo, $rotasLivres, true) &&
            !in_array($acao , $rotasLivres, true)) {
            $this->validaNivelAcesso(11); // apenas admin e professor acessam
        }
    }

    /** Lista todos os usuários */
    public function index()
    {
        $dados = $this->model->lista('nome'); // Busca todos os usuários
        return $this->loadView('sistema/listas/listaUsuario', $dados);
    }

    /** Carrega o formulário de cadastro ou edição */
    public function form(?string $action=null, ?int $id=null)
    {
        // Se for inserção, define valores padrão
        $dados = ($this->action==='insert')
               ? ['nivel'=>21,'trocarSenha'=>'S','statusRegistro'=>1]
               : $this->model->getById($id); // Se for edição, busca do banco

        return $this->loadView('sistema/formularios/formUsuario', $dados);
    }

    /** Insere um novo usuário e vincula à tabela de professor ou aluno */
    public function insert()
    {
        $post = $this->request->getPost();

        // Valida se a senha foi preenchida
        if (empty($post['senha'])) {
            Session::set('errors', ['senha' => 'Preencha a senha.']);
            Session::set('inputs', $post);
            return Redirect::page('usuario/form/insert/0');
        }

        // Gera o hash da senha
        unset($post['action'], $post['confSenha']);
        $post['senha'] = password_hash($post['senha'], PASSWORD_DEFAULT);

        // Insere usuário na tabela `usuario`
        $usuarioId = $this->model->insertReturnId($post);
        if (!$usuarioId) {
            return Redirect::page('usuario', ['msgError' => 'Erro ao inserir usuário.']);
        }

        // Se for aluno, vincula na tabela `aluno`
        if ((int)$post['nivel'] === 31) {
            $this->loadModel('Aluno')->insert([
                'nome'        => $post['nome'],
                'email'       => $post['email'],
                'curso'       => 'Não informado',
                'ra'          => uniqid(),
                'usuario_id'  => $usuarioId
            ]);
        }

        // Se for professor, vincula na tabela `professor`
        elseif ((int)$post['nivel'] === 21) {
            $this->loadModel('Professor')->insert([
                'nome'         => $post['nome'],
                'email'        => $post['email'],
                'especialidade'=> 'Não informada',
                'area'         => 'Não informada',
                'usuario_id'   => $usuarioId
            ]);
        }

        return Redirect::page('usuario', ['msgSucesso' => 'Usuário inserido com sucesso.']);
    }

    /** Atualiza os dados de um usuário */
    public function update()
    {
        $post = $this->request->getPost();
        unset($post['action'], $post['confSenha']);

        // Atualiza senha apenas se foi informada
        if (empty($post['senha'])) {
            unset($post['senha']);
        } else {
            $post['senha'] = password_hash($post['senha'], PASSWORD_DEFAULT);
        }

        $ok = $this->model->update($post);

        return Redirect::page('usuario',
            $ok ? ['msgSucesso'=>'Alterado com sucesso.'] : []);
    }

    /** Exclui um usuário */
    public function delete()
    {
        $ok = $this->model->delete($this->request->getPost());

        return Redirect::page('usuario',
            $ok ? ['msgSucesso'=>'Excluído.']
                : ['msgError'=>'Falha ao excluir.']);
    }

    /** Carrega o formulário para trocar a senha */
    public function formTrocarSenha()
    {
        return $this->loadView('sistema/formularios/formTrocarSenha');
    }

    /** Atualiza a senha do próprio usuário (pelo formulário de troca de senha) */
    public function updateNovaSenha()
    {
        $post = $this->request->getPost();
        $userAtual = $this->model->getById($post['id']);

        // Verifica se o usuário existe
        if (!$userAtual) {
            return Redirect::page('usuario/formTrocarSenha', ['msgError'=>'Usuário inválido.']);
        }

        // Valida senha atual
        if (!password_verify(trim($post['senhaAtual']), $userAtual['senha'])) {
            return Redirect::page('usuario/formTrocarSenha', ['msgError'=>'Senha atual não confere.']);
        }

        // Valida nova senha
        if (trim($post['novaSenha']) !== trim($post['novaSenha2'])) {
            return Redirect::page('usuario/formTrocarSenha', ['msgError'=>'Nova senha e confirmação divergem.']);
        }

        // Atualiza a senha
        $novaHash = password_hash(trim($post['novaSenha']), PASSWORD_DEFAULT);
        $ok = $this->model->db->where(['id' => $post['id']])->update(['senha' => $novaHash]);

        if ($ok) Session::set('userSenha', $novaHash);

        return Redirect::page('usuario/formTrocarSenha',
            $ok ? ['msgSucesso'=>'Senha alterada com sucesso!']
                : ['msgError'=>'Falha ao alterar senha.']);
    }

    /** Cadastro de usuário feito pela tela pública (ex: aluno se registrando sozinho) */
    public function registraUsuario()
    {
        $post = $this->request->getPost();

        // Verifica se as senhas coincidem
        if ($post['register-password'] !== $post['confirm-register-password']) {
            Session::set('errors', ['senha' => 'As senhas não conferem.']);
            Session::set('inputs', $post);
            return Redirect::page('login/cadastro');
        }

        // Prepara os dados para inserir na tabela `usuario`
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

        // Se for aluno, vincula na tabela `aluno`
        if ($dados['nivel'] === 31) {
            $this->loadModel('Aluno')->insert([
                'nome'           => $dados['nome'],
                'email'          => $dados['email'],
                'curso'          => $post['curso'] ?? 'Não informado',
                'ra'             => uniqid(),
                'usuario_id'     => $usuarioId,
                'statusRegistro' => 1
            ]);
        }

        // Se for professor, vincula na tabela `professor`
        elseif ($dados['nivel'] === 21) {
            $this->loadModel('Professor')->insert([
                'nome'           => $dados['nome'],
                'email'          => $dados['email'],
                'especialidade'  => $post['especialidade'] ?? 'Não informada',
                'area'           => $post['area'] ?? 'Não informada',
                'usuario_id'     => $usuarioId,
                'statusRegistro' => 1
            ]);
        }

        return Redirect::page('login', ['msgSucesso' => 'Cadastro realizado com sucesso!']);
    }
}
