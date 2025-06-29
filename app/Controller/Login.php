<?php
// Define o namespace e importa as bibliotecas necessárias
namespace App\Controller;

use App\Model\UsuarioModel;
use Core\Library\ControllerMain;
use Core\Library\Email;
use Core\Library\Redirect;
use Core\Library\Session;

// Controller responsável pelo login e recuperação de senha
class Login extends ControllerMain
{
    // Construtor: configura o controller e carrega o model de usuário
    public function __construct()
    {
        $this->auxiliarConstruct();             // Verifica se o sistema está pronto
        $this->model = new UsuarioModel();      // Define o model que será usado
        $this->loadHelper("formHelper");        // Carrega funções auxiliares de formulário
    }

    // Exibe a tela de login
    public function index()
    {
        return $this->loadView("login/login", []);
    }

    // Função que realiza o login do usuário
    public function signIn()
    {
        $post   = $this->request->getPost();                    // Pega os dados enviados pelo formulário
        $aUser  = $this->model->getUserEmail($post['email']);  // Busca o usuário pelo e-mail

        // Se encontrou o usuário
        if (count($aUser) > 0) {

            // Verifica se a senha digitada confere com a salva no banco
            if (!password_verify(trim($post["senha"]), trim($aUser['senha'])) ) {
                return Redirect::page("login", [
                    "msgError" => 'Login ou senha inválido.',
                    'inputs'   => ["email" => $post['email']]
                ]);
            }

            // Verifica se o usuário está ativo
            if ($aUser['statusRegistro'] == 2 ) {
                return Redirect::page("login", [
                    "msgError" => 'Usuário Inativo.',
                    'inputs'   => ["email" => $post['email']]
                ]);
            }

            // Armazena dados do usuário na sessão
            Session::set("userId",    $aUser['id']);
            Session::set("userNome",  $aUser['nome']);
            Session::set("userEmail", $aUser['email']);
            Session::set("userNivel", $aUser['nivel']);
            Session::set("userSenha", $aUser['senha']);

            // Redireciona para o painel
            return Redirect::page("sistema");
        } else {
            // Se o usuário não for encontrado
            return Redirect::page("login", [
                "msgError" => 'Login ou senha inválido.',
                'inputs'   => ["email" => $post['email']]
            ]);
        }
    }

    // Função que realiza logout (encerra a sessão)
    public function signOut()
    {
        Session::destroy('userId');
        Session::destroy('userNome');
        Session::destroy('userEmail');
        Session::destroy('userNivel');
        Session::destroy('userSenha');

        return Redirect::Page("home"); // Volta para a página inicial
    }

    // Mostra o formulário "esqueci a senha"
    public function esqueciASenha()
    {
        return $this->loadView("login/esqueciASenha");
    }

    // Mostra o formulário de cadastro
    public function cadastro()
    {
        return $this->loadView("login/cadastro");
    }

    // Envia o e-mail com link para redefinir a senha
    public function esqueciASenhaEnvio()
    {
        $this->loadHelper("emailHelper");

        $post = $this->request->getPost(); // Recebe o e-mail digitado
        $user = $this->model->getUserEmail($post['email']); // Busca o usuário

        if (!$user) {
            // Se o e-mail não for encontrado
            return Redirect::page("Login/esqueciASenha", [
                "msgError" => "E-mail não localizado no sistema!"
            ]);
        } else {
            // Gera uma chave única de recuperação
            $created_at = date('Y-m-d H:i:s');
            $chave = sha1($user['id'] . $user['senha'] . date('YmdHis', strtotime($created_at)));
            $cLink = baseUrl() . "login/recuperarSenha/" . $chave;

            // Monta o conteúdo do e-mail
            $emailTexto = emailRecuperacaoSenha($cLink);

            // Envia o e-mail
            $lRetMail = Email::enviaEmail(
                $_ENV['MAIL.USER'],
                $_ENV['MAIL.NOME'],
                $emailTexto['assunto'],
                $emailTexto['corpo'],
                $user['email']
            );

            if ($lRetMail) {
                // Desativa chaves antigas e salva nova chave
                $usuarioRecuperaSenhaModel = $this->loadModel("UsuarioRecuperaSenha");
                $usuarioRecuperaSenhaModel->desativaChaveAntigas($user["id"]);

                $resIns = $usuarioRecuperaSenhaModel->db->table('usuariorecuperasenha')->insert([
                    "usuario_id" => $user["id"],
                    "chave" => $chave,
                    "created_at" => $created_at
                ]);

                if ($resIns) {
                    return Redirect::page("login", [
                        "msgSucesso" => "Link enviado para seu e-mail!"
                    ]);
                } else {
                    return Redirect::page("login/esqueciASenha");
                }

            } else {
                // Falha no envio do e-mail
                return Redirect::page("login/esqueciASenha", ["inputs" => $post]);
            }
        }
    }

    // Página de redefinição de senha (validando a chave do link)
    public function recuperarSenha($chave)
    {
        $usuarioRecuperaSenhaModel = $this->loadModel('UsuarioRecuperaSenha');
        $userChave = $usuarioRecuperaSenhaModel->getRecuperaSenhaChave($chave);

        if ($userChave) {
            // Verifica se a chave ainda está válida (até 1h)
            if (date("Y-m-d H:i:s") <= date("Y-m-d H:i:s" , strtotime("+1 hours" , strtotime($userChave['created_at'])))) {

                $usuarioModel = $this->loadModel('Usuario');
                $user = $usuarioModel->getById($userChave['usuario_id']);

                if ($user) {
                    // Valida se a chave bate com os dados
                    $chaveRecSenha = sha1($userChave['usuario_id'] . $user['senha'] . date("YmdHis", strtotime($userChave['created_at'])));

                    if ($chaveRecSenha == $userChave['chave']) {
                        // Exibe o formulário para trocar a senha
                        $dbDados = [
                            "id" => $user['id'],
                            'nome' => $user['nome'],
                            'usuariorecuperasenha_id' => $userChave['id']
                        ];

                        Session::destroy("msgError");
                        return $this->loadView("login/recuperarSenha", $dbDados);
                    } else {
                        // Chave inválida
                        $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);
                        return Redirect::page("Login/esqueciASenha", [
                            "msgError" => "Link de recuperação inválido."
                        ]);
                    }
                } else {
                    // Usuário não encontrado
                    $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);
                    return Redirect::page("Login/esqueciASenha", [
                        "msgError" => "Usuário não encontrado."
                    ]);
                }
            } else {
                // Link expirado
                $usuarioRecuperaSenhaModel->desativaChave($userChave['id']);
                return Redirect::page("Login/esqueciASenha", [
                    "msgError" => "Link expirado."
                ]);
            }
        } else {
            // Chave inválida ou não encontrada
            return Redirect::page("Login/esqueciASenha", [
                "msgError" => "Link não encontrado."
            ]);
        }
    }

    // Atualiza a senha no banco após o usuário preencher o novo campo
    public function atualizaRecuperaSenha()
    {
        $UsuarioModel = $this->loadModel("Usuario");
        $post = $this->request->getPost(); // Dados do formulário
        $userAtual = $UsuarioModel->getById($post["id"]);

        if ($userAtual) {
            // Verifica se as duas senhas batem
            if (trim($post["NovaSenha"]) == trim($post["NovaSenha2"])) {
                // Atualiza a senha no banco
                if ($UsuarioModel->db->table("usuario")->where(['id' => $post['id']])
                    ->update([
                        'senha' => password_hash(trim($post["NovaSenha"]), PASSWORD_DEFAULT)
                    ])) {
                    
                    // Desativa o uso da chave
                    $usuarioRecuperaSenhaModel = $this->loadModel('UsuarioRecuperaSenha');
                    $usuarioRecuperaSenhaModel->desativaChave($post['usuariorecuperasenha_id']);

                    Session::destroy("msgError");
                    return Redirect::page("Login", [
                        "msgSuccesso" => "Senha atualizada com sucesso!"
                    ]);

                } else {
                    return $this->loadView("login/recuperarSenha", $post);
                }
            } else {
                // Senhas não coincidem
                Session::set("msgError", "As senhas informadas não coincidem.");
                return $this->loadView("login/recuperarSenha", $post);
            }
        } else {
            // Usuário inválido
            Session::set("msgError", "Usuário inválido!");
            return $this->loadView("login/recuperarSenha", $post);
        }
    }

    // Função para criar um superusuário (acesso nível 1)
    public function criaSuperUser()
    {
        $dados = [
            "nivel" => 1, // Nível de acesso máximo
            "nome" => "SuperUser",
            "email" => "superuser@gmail.com",
            "senha" => password_hash("admin123", PASSWORD_DEFAULT),
            "statusRegistro" => 1
        ];

        // Verifica se já existe um superusuário
        $aSuperUser = $this->model->getUserEmail($dados['email']);

        if (count($aSuperUser) > 0) {
            return Redirect::Page("login", ["msgError" => "Login já existe."]);
        } else {
            if ($this->model->insert($dados)) {
                return Redirect::Page("login", ["msgSucesso" => "Login criado com sucesso."]);
            } else {
                return Redirect::Page("login");
            }
        }
    }
}
