# 📊 MyFinance

> Um sistema web simples e funcional para controle de gastos pessoais.

---

## 📌 Descrição

**MyFinance** é um sistema de controle financeiro pessoal. Usuários podem se cadastrar e acessar um **dashboard seguro**, onde registram, editam e excluem seus **gastos diários**.

O objetivo é oferecer uma ferramenta simples para controle financeiro pessoal, com funcionalidades essenciais e uma interface limpa.

---

## ✅ Funcionalidades

- Cadastro e login de usuários
- Proteção de rotas via sessão
- Dashboard pessoal com:
  - Adição de gastos (valor, categoria, descrição e data)
  - Edição de gastos
  - Exclusão de gastos
- Modais interativos para adição e exclusão de dados do usuario e de gastos
- Interface interativa

---

## 💡 Futuras melhorias

- Relatórios financeiros mensais
- Gráficos interativos de despesas
- Filtros por período, categoria e valor
- Exportação de dados (CSV / PDF)

---

## 🧪 Tecnologias utilizadas

- **PHP** – Backend e controle de sessão
- **MySQL / SQL** – Banco de dados
- **HTML5** – Estrutura da interface
- **CSS3** – Estilização
- **JavaScript (Vanilla)** – Interatividade e manipulação do DOM
- **Git** – Controle de versão

## 🔐 Segurança e boas práticas implementadas

- Proteção contra ataques comuns como **SQL Injection** e **Cross-Site Scripting (XSS)**
- Uso de **sessions PHP** para autenticação e autorização
- Rotas protegidas para evitar acesso não autorizado
- Configuração segura do banco usando arquivos `.env` para variáveis sensíveis
- Passagem de dados do PHP para JavaScript via JSON, evitando exposição direta

---

## 🛠 Competências e técnicas desenvolvidas no projeto

- Implementação do padrão **MVC** em PHP
- Criação de API simples para comunicação backend/frontend
- Uso de sessões para gerenciar autenticação e persistência do usuário
- Manipulação DOM e eventos com JavaScript puro para modais interativos
- Controle de formulários para CRUD (Create, Read, Update, Delete)
- Organização do código para manter escalabilidade e legibilidade
- Desenvolvimento de URLs amigáveis para melhor SEO e experiência do usuário
- Utilização do Git para versionamento e controle de alterações
