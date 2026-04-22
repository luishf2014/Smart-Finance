# Controle financeiro (PHP + sessão)

Projeto web simples em **PHP procedural**, sem framework e sem banco de dados. Os dados das transações ficam na **sessão** do PHP enquanto o navegador estiver com a sessão ativa.

## O que o sistema faz

- Login com usuário e senha fixos no código (senha armazenada com `password_hash` e verificada com `password_verify`)
- Cadastro de **receitas** e **despesas** (descrição, valor, tipo)
- Painel com totais: receitas, despesas e saldo
- Página de **histórico** em tabela, com percentual de cada despesa em relação ao total de despesas
- Opção de **limpar** o histórico (zera o array na sessão)
- **Logout** (encerra a sessão)

## O que precisam ter instalado

- [XAMPP](https://www.apachefriends.org/) (ou outro ambiente com PHP e Apache)
- PHP com extensão de sessão habilitada (no XAMPP costuma vir ok por padrão)

## Como rodar

1. Coloquem a pasta do projeto dentro de `htdocs` (ex.: `c:\xampp\htdocs\provaA2`)
2. Iniciem o **Apache** no painel do XAMPP
3. No navegador: `http://localhost/provaA2/login.php`

## Login de teste

| Campo    | Valor   |
| -------- | ------- |
| Usuário  | `aluno` |
| Senha    | `123456` |

Para mudar a senha: gerem um novo hash no terminal (com o PHP do XAMPP) e atualizem a variável `$senha_hash` em `login.php`:

```bash
c:\xampp\php\php.exe -r "echo password_hash('SUA_SENHA_AQUI', PASSWORD_DEFAULT);"
```

O usuário fixo está na variável `$usuario_sistema` no mesmo arquivo.

## Estrutura dos arquivos

```
provaA2/
├── login.php          # Tela de login
├── index.php          # Dashboard (resumo + formulário de transação)
├── historico.php      # Tabela do histórico + limpar
├── logout.php         # Destrói sessão e volta ao login
├── session.php        # Inicia sessão, protege páginas, garante array de transações
├── functions.php      # Funções auxiliares (totais, formatação, validação)
├── README.md
└── includes/
    ├── header.php     # HTML inicial + Bootstrap (CDN)
    └── menu.php       # Menu e saudação com nome do usuário
```

## Fluxo rápido (para quem for mexer no código)

- Páginas **privadas** (`index.php`, `historico.php`) começam com `require` de `session.php`. Se não estiver logado, redireciona para `login.php`.
- As transações são um array em `$_SESSION['transacoes']`. Cada item é um array associativo com: `data`, `descricao`, `valor`, `tipo` (`receita` ou `despesa`).
- `login.php` **não** inclui `session.php` completo da mesma forma que as outras páginas, porque ainda não há login; ele só usa `session_start()` e trata o formulário.

## Trabalho em dupla – sugestões

- **Git:** um repositório compartilhado evita sobrescrever trabalho do outro; combinem quem cuida de qual parte (ex.: um no layout, outro nas regras em `functions.php`).
- **Antes de entregar:** testem login errado, cadastro de receita/despesa, histórico, limpar histórico e sair.
- **Limitação do projeto:** sem banco, ao fechar o navegador ou expirar a sessão, o histórico some. Isso é esperado para este tipo de trabalho.

## Tecnologias

- PHP (procedural)
- HTML + [Bootstrap 5](https://getbootstrap.com/) via CDN
- Sessão PHP (`$_SESSION`)

---

*Trabalho acadêmico – controle financeiro com sessão.*
