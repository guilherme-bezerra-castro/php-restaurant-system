# Sistema de Restaurante

> Sistema web fullstack para gerenciamento de conteúdo de um restaurante, com autenticação de usuários e painel administrativo para edição dinâmica de informações.

O Sistema de Restaurante é um projeto pessoal desenvolvido com PHP, MySQL, HTML, CSS e JavaScript. Ele simula um sistema completo de site institucional com área pública (cliente) e área administrativa protegida por autenticação.

O objetivo do projeto foi praticar desenvolvimento fullstack, autenticação de usuários com hash de senha, manipulação de banco de dados e estruturação de páginas dinâmicas.

---

## Tecnologias

* PHP
* MySQL
* HTML5
* CSS3
* JavaScript (vanilla)

---

## Funcionalidades

### Área pública

* Página inicial com cardápio e carrossel de imagens
* Seção de FAQ
* Seção de pratos (cards de refeições)
* Página de locais com cards das unidades do restaurante
* Footer com informações de contato

### Autenticação

* Sistema de login de administrador
* Senhas armazenadas com hash no banco de dados (MySQL)

### Área administrativa

* Painel administrativo protegido por login
* Edição de conteúdos exibidos na página inicial (cards e seções)
* Atualização dinâmica de informações do site via banco de dados

---

## Banco de Dados

* MySQL
* Estrutura baseada em usuários e conteúdos do site
* Senhas armazenadas utilizando hash de segurança
* Script SQL disponível no repositório para criação do ambiente local

---

## Conceitos aplicados

* Desenvolvimento fullstack
* Autenticação de usuários
* Hash de senha para segurança
* CRUD de conteúdos dinâmicos
* Integração entre front-end e back-end
* Manipulação de DOM via JavaScript
* Estruturação de sistema web com múltiplas páginas

---

## Como executar localmente

### Pré-requisitos

* Servidor local (XAMPP, WAMP ou similar)
* PHP instalado
* MySQL

### Passos

1. Clonar o repositório:

```bash
git clone <URL_DO_REPOSITORIO>
```

2. Importar o banco de dados MySQL usando o script disponível no projeto

3. Configurar a conexão com o banco no arquivo de configuração PHP

4. Executar o projeto em servidor local (localhost)

5. Acessar:

* Dentro do diretório do projeto clonado no terminal:
```
php -S localhost:8000
```

* Clique no link localhost do servidor usando CTRL + click e, na URL do sistema:
```
http://localhost{porta}/includes
```

---

## Contexto do projeto

Este projeto foi desenvolvido como trabalho avaliativo da disciplina de Desenvolvimento Fullstack no curso de Análise e Desenvolvimento de Sistemas (IFSP).

Posteriormente, o sistema passou por refatoração com foco em boas práticas de desenvolvimento, incluindo princípios de Clean Code, visando melhoria de legibilidade, organização e manutenção do código.

## Evolução do projeto

O sistema foi inicialmente desenvolvido com foco acadêmico e posteriormente revisado para aplicação de melhores práticas de desenvolvimento.

As melhorias realizadas incluíram:
- Organização de código
- Separação de responsabilidades
- Refatoração de funções e estrutura geral

Futuras melhorias incluirão:
- Melhoria do design front-end da aplicação
- Consumo de APIs externas em novas features para as páginas de clientes

## Observações do projeto

* Projeto desenvolvido como primeiro sistema fullstack
* Front-end ainda em processo de evolução e refatoração
* Algumas funcionalidades de UI (como busca na navbar) ainda não estão implementadas
* Estrutura passou por melhorias seguindo princípios básicos de Clean Code