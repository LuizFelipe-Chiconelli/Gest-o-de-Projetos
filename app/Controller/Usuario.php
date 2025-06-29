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

    /** Carrega o formulário de cadastro (insert) ou edição (update) */
    public function form(?string $action = 'insert', ?int $id = null)
    {
    if ($action === 'insert') {                     // valores default
        $usuario = [
            'id'             => '',
            'nome'           => '',
            'email'          => '',
            'statusRegistro' => 1,
            'nivel'          => 11                 // ← sempre Administrador
        ];
    } else {                                        // update
        $usuario = $this->model->getById($id);
        if (!$usuario) {
            Session::set('msgError', 'Usuário não encontrado.');
            return Redirect::page('usuario');
        }
        /* nada de carregar campos extras */
    }

    return $this->loadView(
        'sistema/formularios/formUsuario',
        array_merge($usuario, ['formAction' => $action])
    );
    }

    /** Insere novo usuário – sempre nível 11 (Administrador) */
    public function insert()
    {
    $post = $this->request->getPost();

    /* 1. Validação mínima */
    if (empty($post['senha'])) {
        Session::set('errors', ['senha' => 'Preencha a senha.']);
        Session::set('inputs', $post);
        return Redirect::page('usuario/form/insert/0');
    }

    /* 2. Garante que não exista outro e-mail igual */
    if ($this->model->db->where('email', $post['email'])->first()) {
        Session::set('errors', ['email' => 'E-mail já cadastrado.']);
        Session::set('inputs', $post);
        return Redirect::page('usuario/form/insert/0');
    }

    /* 3. Monta dados */
    $dados = [
        'nome'           => trim($post['nome']),
        'email'          => strtolower(trim($post['email'])),
        'senha'          => password_hash($post['senha'], PASSWORD_DEFAULT),
        'nivel'          => 11,   // sempre Administrador
        'statusRegistro' => 1
    ];

    $usuarioId = $this->model->insertReturnId($dados);

    if (!$usuarioId) {
        return Redirect::page('usuario', ['msgError' => 'Erro ao inserir usuário.']);
    }

    return Redirect::page(
        'usuario',
        ['msgSucesso' => 'Administrador criado com sucesso.']
    );
    }

    /** Atualiza usuário e mantém aluno/professor sincronizados */
    public function update()
    {
    /* ---------- entrada ---------- */
    $p        = $this->request->getPost();
    $id       = (int) $p['id'];                           // PK
    $camposOK = ['nome', 'email', 'statusRegistro', 'senha'];

    /* ------- senha opcional ------- */
    if (empty($p['senha'])) {
        unset($p['senha']);
    } else {
        $p['senha'] = password_hash($p['senha'], PASSWORD_DEFAULT);
    }

    /* ------- dados sem o ID (para SET) ------- */
    $dadosSet = [];
    foreach ($camposOK as $campo) {
        if (isset($p[$campo])) {
            $dadosSet[$campo] = $p[$campo];
        }
    }

    /* ---------- 1) registro atual ---------- */
    $usuarioAtual = $this->model->getById($id);
    if (!$usuarioAtual) {
        return Redirect::page('usuario', ['msgError' => 'Usuário não encontrado.']);
    }
    $nivel = (int) $usuarioAtual['nivel'];                // 21, 31 ou 11

    /* ---------- 2) valida (sem gravar) ---------- */
    $dadosVal = array_merge(['id' => $id], $dadosSet);     // id requerido p/ Validator
    if ($this->model->update($dadosVal) === false) {       // validação falhou
        return Redirect::page('usuario', ['msgError' => 'Falha de validação.']);
    }

    /* ---------- 3) executa UPDATE real (★) ---------- */
    $linhasAfetadas = $this->model->db
        ->where('id', $id)
        ->update($dadosSet);                               // id NÃO está no SET

    /* ---------- 4) espelha nome/e-mail ---------- */
    $espelho = [
        'nome'  => $dadosSet['nome']  ?? $usuarioAtual['nome'],
        'email' => $dadosSet['email'] ?? $usuarioAtual['email']
    ];

    if ($nivel === 31) {                                  // ALUNO
        $alunoModel = $this->loadModel('Aluno');
        $rows = $alunoModel->db
                           ->where('usuario_id', $id)
                           ->update($espelho);
        if ($rows === 0) {
            $alunoModel->insert($espelho + [
                'curso'          => 'Não informado',
                'ra'             => uniqid(),
                'usuario_id'     => $id,
                'statusRegistro' => 1
            ]);
        }

    } elseif ($nivel === 21) {                            // PROFESSOR
        $profModel = $this->loadModel('Professor');
        $rows = $profModel->db
                          ->where('usuario_id', $id)
                          ->update($espelho);
        if ($rows === 0) {
            $profModel->insert($espelho + [
                'especialidade'  => 'Não informada',
                'area'           => 'Não informada',
                'usuario_id'     => $id,
                'statusRegistro' => 1
            ]);
        }
    }
    /* nível 11 → nada a espelhar */

    /* ---------- 5) redireciona ---------- */
    return Redirect::page(
        'usuario',
        ($linhasAfetadas > 0)
            ? ['msgSucesso' => 'Dados atualizados com sucesso.']
            : ['msgSucesso' => 'Nenhum campo mudou, sincronização concluída.']
    );
    }



    public function delete()
    {
    /* 1. coleta id por POST ou GET */
    $post = $this->request->getPost();          // ← array completo
    $id   = (int) ($post['userId'] ?? 0
               ?: ($this->request->getRotaParametros()['id']     ?? 0)
               ?: ($this->request->getRotaParametros()['action'] ?? 0));

    if ($id === 0) {
        return Redirect::page('usuario', ['msgError' => 'ID inválido.']);
    }

    $usuario = $this->model->getById($id);
    if (!$usuario) {
        return Redirect::page('usuario', ['msgError' => 'Usuário não encontrado.']);
    }

    /* 2. exclui nas tabelas específicas, se necessário */
    switch ((int)$usuario['nivel']) {
        case 31: // Aluno
            $this->loadModel('Aluno')->db
                 ->where('usuario_id', $id)->delete();
            break;

        case 21: // Professor
            $this->loadModel('Professor')->db
                 ->where('usuario_id', $id)->delete();
            break;
        // nível 11 não precisa
    }

    /* 3. exclui o próprio usuário */
    $ok = $this->model->db->where('id', $id)->delete();

    return Redirect::page(
        'usuario',
        $ok ? ['msgSucesso' => 'Usuário excluído com sucesso.']
            : ['msgError'   => 'Falha ao excluir usuário.']
    );
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
