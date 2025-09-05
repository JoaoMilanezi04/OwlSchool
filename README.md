# OLWSchool

Sistema escolar moderno, multiusuário e responsivo, feito em PHP + SQLite. Ideal para alunos, responsáveis, professores e administradores.

## Estrutura de Pastas

```
owl-school/
├─ public/         # arquivos públicos, páginas e assets (css, js, imagens)
│  ├─ aluno/       # área do aluno
│  ├─ responsavel/ # área do responsável
│  ├─ professor/   # área do professor
│  ├─ admin/       # área administrativa
│  └─ assets/      # arquivos estáticos (css, js, imagens)
├─ api/            # endpoints da API
├─ partials/       # componentes e partes reutilizáveis (navbar, footer, etc)
├─ db/             # banco de dados e scripts SQL
├─ README.md
```

## Funcionalidades

- Login rápido por papel (aluno, responsável, professor, admin)
- Dashboard personalizado
- Boletim, tarefas, agenda, comunicados, financeiro
- Gamificação: medalhas, missões, quiz
- API REST simples para integração
- Componentes reutilizáveis em PHP
- Banco SQLite fácil de instalar

## Como rodar

1. Instale o XAMPP ou similar
2. Coloque a pasta `olwschool` em `htdocs`
3. Acesse: [http://localhost/afonso/olw-school/olwschool/public/index.php](http://localhost/afonso/olw-school/olwschool/public/index.php)

## Sobre

Feito por AfonsoPTZ. Projeto open-source para escolas e desenvolvedores.

---

> Dúvidas, sugestões ou bugs? Abra uma issue!
