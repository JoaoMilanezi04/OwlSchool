# 🦉 OwlSchool

Portal Escolar acadêmico desenvolvido para facilitar a comunicação entre **alunos, responsáveis, professores e administradores**.  
Projeto simples, funcional e responsivo, utilizando **PHP + MySQL + Bootstrap**.

---

## 📚 Funcionalidades

- Login com perfis diferentes (Aluno, Professor, Responsável, Admin)
- Dashboard personalizado para cada usuário
- Visualização de notas, faltas e boletim
- Cadastro e vínculo de alunos e responsáveis
- Comunicação entre escola e responsáveis (avisos, mensagens)
- Gestão de disciplinas, turmas e professores
- Controle de mensalidades (protótipo)
- Área lúdica para alunos (jogos/atividades)
- Painel administrativo para gerenciamento

---

## 🛠️ Tecnologias

- **Frontend**: HTML5, CSS3, [Bootstrap 5](https://getbootstrap.com/)
- **Backend**: PHP 8
- **Banco de Dados**: MySQL
- **Servidor Local**: XAMPP (Apache + MySQL)

---

## 📂 Estrutura

```

OlwSchool/
├── public/           # arquivos públicos, páginas e assets (css, js, imagens)
│   ├── aluno/        # área do aluno
│   ├── responsavel/  # área do responsável
│   ├── professor/    # área do professor
│   ├── admin/        # área administrativa
│   └── assets/       # arquivos estáticos (css, js, imagens)
├── api/              # endpoints da API
├── partials/         # componentes e partes reutilizáveis (navbar, footer, etc)
├── db/               # banco de dados e scripts SQL
└── README.md

```

---

## 🚀 Como Rodar

1. Instale o [XAMPP](https://www.apachefriends.org/).
2. Clone o repositório em `htdocs/`.
   ```bash
   git clone https://github.com/seu-usuario/olwschool.git
   ```
3. Importe o banco de dados:
   - Abra o phpMyAdmin
   - Crie um banco chamado `olwschool`
   - Importe o arquivo `db/schema.sql` e, se quiser dados de exemplo, `db/seed.sql`
4. Inicie o Apache e MySQL pelo XAMPP
5. Acesse `http://localhost/olwschool/public/index.php` no navegador
6. Faça login com um dos usuários cadastrados (veja o seed.sql para exemplos)

Pronto! O sistema estará disponível para testes e desenvolvimento.
