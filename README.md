# Sistema de Restaurante

> Sistema web fullstack para gerenciamento de conteúdo de um restaurante, com autenticação de usuários e painel administrativo para edição dinâmica das informações do site.

O **Sistema de Restaurante** é um projeto desenvolvido com **PHP, MySQL, HTML, CSS e JavaScript**, simulando um sistema completo de site institucional com área pública para clientes e uma área administrativa protegida por autenticação.

O projeto teve como objetivo praticar o desenvolvimento de aplicações fullstack, incluindo autenticação de usuários, integração com banco de dados, gerenciamento dinâmico de conteúdo e organização da aplicação em múltiplas páginas.

> **Status:** projeto local, sem deploy.

---

## Tecnologias

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript (Vanilla)

---

## Funcionalidades

### Área pública

- Página inicial com cardápio e carrossel de imagens
- Seção de FAQ
- Exibição de pratos em formato de cards
- Página com as unidades do restaurante
- Informações de contato no rodapé

### Autenticação

- Login para administradores
- Armazenamento seguro de senhas utilizando hash

### Área administrativa

- Painel administrativo protegido por autenticação
- Gerenciamento dos conteúdos exibidos na página inicial
- Atualização dinâmica das informações do site através do banco de dados

---

## Banco de Dados

- MySQL
- Estrutura organizada para gerenciamento de usuários e conteúdos
- Senhas armazenadas utilizando hash de segurança
- Script SQL disponível para criação do ambiente local

---

## Conceitos aplicados

- Desenvolvimento Fullstack
- Autenticação de usuários
- Hash de senhas
- CRUD de conteúdos
- Integração entre front-end e back-end
- Manipulação de DOM com JavaScript
- Persistência de dados com MySQL
- Estruturação de aplicações web com múltiplas páginas

---

## Como executar localmente

### Pré-requisitos

- PHP instalado
- MySQL
- Servidor local (XAMPP, WAMP ou similar)

### Instalação

1. Clone o repositório:

```bash
git clone https://github.com/guilherme-bezerra-castro/php-restaurant-system.git
```

2. Importe o banco de dados utilizando o script SQL disponível no projeto.

3. Configure a conexão com o banco de dados no arquivo de configuração da aplicação.

4. Inicie o servidor PHP:

```bash
php -S localhost:8000
```

5. Acesse a aplicação pelo navegador:

```
http://localhost:8000/includes
```

---

## Contexto do projeto

Este projeto foi desenvolvido como trabalho da disciplina de Desenvolvimento Fullstack do curso de **Análise e Desenvolvimento de Sistemas (IFSP)**.

Posteriormente, o sistema passou por uma refatoração com foco na organização do código e na aplicação de boas práticas de desenvolvimento, visando melhorar sua legibilidade e manutenção.

---

## Evolução do projeto

Após sua implementação inicial, o projeto recebeu melhorias estruturais, incluindo:

- Organização da estrutura do código
- Separação de responsabilidades
- Refatoração de funções
- Melhorias na legibilidade e manutenção da aplicação