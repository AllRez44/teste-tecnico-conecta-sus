# Teste Técnico Conecta SUS - Gestão para Saúde Pública Municipal

Este é um projeto full stack desenvolvido para avaliação técnica, focando na gestão de pacientes e seus respectivos endereços. A aplicação é dividida em um backend em PHP (Laravel) e um frontend em JavaScript (Vue.js 2). Todo o ambiente de desenvolvimento e execução é orquestrado através do Docker.

## Requisitos

Para rodar este projeto, você precisará ter instalado em sua máquina:
- [Docker](https://docs.docker.com/get-docker/)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Como Executar o Projeto

Siga as instruções abaixo para iniciar a aplicação pela primeira vez. O projeto é bem simples e quase tudo foi automatizado no Docker.

### 1. Configurar as Variáveis de Ambiente (.env)

O projeto depende de arquivos de configuração `.env` em 3 lugares diferentes. Você só precisa copiar os arquivos de exemplo para configurá-los nestes diretórios:
- **Raiz do projeto**
- **Frontend**
- **Backend**

No terminal, na raiz do projeto, execute:
```bash
# Copia o .env da raiz do projeto
cp .env.example .env

# Copia o .env do backend
cp backend/.env.example backend/.env

# Copia o .env do frontend
cp frontend/.env.example frontend/.env
```

### 2. Comandos de Execução

Após configurar os arquivos `.env`, você pode utilizar os comandos esperados pelo Docker Compose para levantar toda a stack:

| Finalidade | Comando |
|---|---|
| **Iniciar todos os containers** | `docker-compose up -d --build` |
| **Rodar as migrations e dados de seed** | `docker-compose exec app php artisan migrate --seed` |
| **Rodar testes automatizados (Backend)** | `docker-compose exec app php artisan test` |

**Notas importantes sobre a execução:**
- O comando `docker-compose exec app composer install` **não é obrigatório** (assim como nenhum outro comando além das migrations no backend), pois o script `entrypoint.sh` do container do backend já se encarrega de instalar as dependências do PHP e gerar a `APP_KEY` caso ela não exista.
- **Não é necessário rodar nenhum comando no container do frontend**, pois o container do frontend (`node`) já executa a instalação de dependências e build automaticamente na sua inicialização, gerando a pasta `dist/` que será servida pelo Nginx.

### 3. Acessar a Aplicação

Depois que os containers estiverem rodando e os builds finalizados:
- **Frontend da Aplicação:** Acesse [http://localhost:8080](http://localhost:8080)
- **Backend (API):** Responde internamente no Nginx e pode ser acessado também através da porta 8080 nas rotas da API.

---

## Estrutura de Containers

A infraestrutura foi desenhada para separar as responsabilidades e garantir a persistência dos dados:

| Serviço | Porta | Notas |
|---|---|---|
| **app** (PHP-FPM) | `9000` (interno) | Container principal com PHP 8.x. `Composer` e `Artisan` estão disponíveis aqui. |
| **nginx** | `8080` (host) &rarr; `80` (container) | Atua como proxy reverso para o PHP-FPM e serve os arquivos estáticos compilados do frontend (`/dist`). |
| **db** (MySQL 8.0) | `3306` (interno) | Banco de dados relacional. Utiliza um volume persistente (`db_data`) para que os dados não sejam perdidos. |
| **frontend** (Node) | `3000` (interno/dev) | Container temporário ou de dev que executa o build da SPA Vue.js para que os arquivos sejam expostos no Nginx. |

---

## Estrutura do Projeto e Tecnologias

### Servidor e Banco de Dados
- **Proxy/Servidor Web:** Nginx (Proxy reverso para o PHP-FPM e servidor de arquivos estáticos para o frontend)
- **Banco de Dados:** MySQL 8.0

### Backend
- **Tecnologia:** Laravel 8.x
- **Bibliotecas Adicionais:** Utiliza a biblioteca `laravellegends/pt-br-validator` para validação de dados brasileiros como CPF e CNS.
- **Onde encontrar a lógica principal:**
  - Controladores (Controllers) em `backend/app/Http/Controllers/`
  - Repositórios (Repositories) abstraindo as consultas de banco de dados em `backend/app/Repositories/`
  - Serviços (Services) contendo as regras de negócio em `backend/app/Services/`
  - Rotas da API em `backend/routes/api.php`
- **Logs:** Os logs da aplicação Laravel estão configurados no canal `daily` (um arquivo por dia). Você pode encontrá-los na pasta de armazenamento: `backend/storage/logs/` (Exemplo: `laravel-YYYY-MM-DD.log`).

### Frontend
- **Tecnologia:** Vue.js 2 (SPA), Vuex, Vue Router, Axios, Bootstrap-Vue, VeeValidate e VueMask.
- **Estrutura sugerida e implementada:**
  ```text
  src/
  ├── components/          # Componentes reutilizáveis genéricos e formulários
  │   ├── layouts/         # Layout base da aplicação
  │   ├── BaseInput.vue    # Campo reutilizável com label + erro
  │   ├── BaseForm.vue    # Formulário genérico
  │   ├── BaseTable.vue    # Tabela genérica
  │   ├── Pagination.vue   # Controle de páginas client-side
  │   ├── ConfirmModal.vue # Modal de confirmação (exclusões)
  │   └── FormPatient.vue, FormAddress.vue, etc.
  ├── views/               # Páginas roteadas da aplicação
  │   ├── Dashboard.vue
  │   ├── pacientes/       # Páginas de pacientes (Index.vue e Form.vue)
  │   └── enderecos/       # Páginas de endereços (Index.vue e Form.vue)
  ├── store/               # Gerenciamento de estado global
  ├── plugins/             # Configuração de plugins de terceiros (Axios, Bootstrap-Vue, VueMask, VeeValidate)
  ├── services/            # Serviços de integração de APIs (Axios)
  └── router/              # Configuração do Vue Router
  ```

### Requisitos de Interface Implementados

O sistema conta com validação de campos no frontend usando VeeValidate, integração com a API pública ViaCEP, utiliza a biblioteca otimizada de UI BootstrapVue e possui as seguintes melhorias de usabilidade (UX/UI):
- **Máscaras de Input:** CPF (`000.000.000-00`), CEP (`00000-000`), CNS (`000 0000 0000 0000`) e Telefone (`(00) 00000-0000`) aplicadas usando `v-mask`.
- **Feedback ao Usuário:** Modal de confirmação obrigatório antes de excluir qualquer registro e indicador de "Loading..." visual durante as requisições Axios.
- **Tabelas Otimizadas:**
  - Paginação client-side através de controle por parâmetros na query string.
  - Ordenação ativada ao clicar nos cabeçalhos das colunas da tabela.
  - Otimização com `Debounce` de 400ms no campo de pesquisa, evitando chamadas desnecessárias à API enquanto o usuário digita.
