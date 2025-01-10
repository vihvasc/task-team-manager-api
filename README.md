# Task Team Manager API

### **Descrição**
Task Team Manager API é uma API RESTful desenvolvida com **Laravel** para gerenciar tarefas de uma equipe. A aplicação permite criar, listar, atualizar e excluir tarefas, seguindo boas práticas de desenvolvimento, incluindo testes automatizados e documentação com Swagger.

---

## **Como Clonar e Inicializar a Aplicação**

### **Passo 1: Clonar o Repositório**
No terminal, execute:
```bash
git clone https://github.com/vihvasc/task-team-manager-api.git
```

Acesse o diretório do projeto clonado:
```bash
cd task-team-manager-api
```

---

### **Passo 2: Instalar Dependências**
Instale as dependências do Laravel utilizando o Composer:
```bash
composer install
```

---

### **Passo 3: Configurar o Arquivo `.env`**
Crie um arquivo `.env` e adicione as seguintes linhas com as configurações do banco de dados:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

---

### **Passo 4: Gerar a Chave da Aplicação**
Gere a chave única para a aplicação:
```bash
php artisan key:generate
```

---

### **Passo 5: Executar Migrações**
Execute as migrações para criar as tabelas no banco de dados configurado:
```bash
php artisan migrate
```

---

### **Passo 6: Rodar o Servidor**
Inicie o servidor embutido do Laravel:
```bash
php artisan serve
```

A aplicação estará disponível em:
```
http://localhost:8000
```

---

## **Arquitetura Utilizada**

O projeto utiliza a arquitetura **MVC (Model-View-Controller)**, padrão no Laravel.

### **Componentes**:
1. **Model**:
   - Define a lógica de negócios e manipulação de dados.
   - Modelo utilizado: `Task`.

2. **Controller**:
   - Gerencia a lógica da aplicação e processa requisições.
   - Controlador utilizado: `TaskController`.

3. **Routes**:
   - Roteamento das requisições HTTP para os métodos do controlador.
   - Arquivo: `routes/api.php`.

4. **Banco de Dados**:
   - Tabela `tasks` gerenciada por migrações do Laravel, persistida no MySQL.

---

## **Approach Utilizado**

O projeto segue um **Resource-Oriented Approach**, implementando uma API RESTful baseada em recursos.

### **Características**:
- **Endereços limpos e semânticos**: cada recurso (tarefas) é acessível por uma URL clara.
- **Métodos HTTP bem definidos**:
  - `GET` para leitura.
  - `POST` para criação.
  - `PUT` para atualização.
  - `DELETE` para exclusão.
- **Documentação automática**: Integrada com Swagger para facilitar a visualização e teste.

---

## **Endpoints Implementados**

### **Tarefas**
1. **Listar todas as tarefas**  
   - **Método**: `GET`  
   - **URL**: `/api/tasks`  

2. **Criar uma nova tarefa**  
   - **Método**: `POST`  
   - **URL**: `/api/tasks`  
   - **Parâmetros esperados no corpo da requisição (JSON)**:
     ```json
     {
         "title": "string",
         "description": "string",
         "due_date": "date",
         "status": "string",
         "user_id": "integer"
     }
     ```

3. **Exibir uma tarefa específica**  
   - **Método**: `GET`  
   - **URL**: `/api/tasks/{id}`  

4. **Atualizar uma tarefa existente**  
   - **Método**: `PUT`  
   - **URL**: `/api/tasks/{id}`  

5. **Excluir uma tarefa existente**  
   - **Método**: `DELETE`  
   - **URL**: `/api/tasks/{id}`  

---

## **Como Acessar o Swagger**

### **Passos**:
1. **Inicie o servidor Laravel**:
   ```bash
   php artisan serve
   ```
   O servidor estará disponível em `http://localhost:8000`.

2. **Acesse o Swagger UI no navegador**:
   ```
   http://localhost:8000/api/documentation
   ```

3. **Explore os Endpoints**:
   - Visualize os detalhes.
   - Teste diretamente no Swagger clicando em **"Try it out"**.

---

## **Como Testar Utilizando Postman**

1. **Configurar o Postman**:
   - Crie uma nova coleção chamada **Task Team Manager API**.
   - Adicione os endpoints à coleção.

2. **Configuração de um Endpoint**:
   - **Exemplo para Criar uma Tarefa (`POST /tasks`)**:
     - Método: `POST`
     - URL: `http://localhost:8000/api/tasks`
     - Corpo da requisição (JSON):
       ```json
       {
           "title": "Minha primeira tarefa",
           "description": "Descrição de teste",
           "due_date": "2025-01-15",
           "status": "pending",
           "user_id": null
       }
       ```

3. **Envie Requisições**:
   - Teste cada endpoint e verifique as respostas retornadas.

---

## **Como Testar Utilizando o Terminal**

### **Configuração do Ambiente de Testes**
1. Configure o banco de dados de testes em `.env.testing`:
   ```env
   DB_CONNECTION=mysql
   DB_DATABASE=task_manager_testing
   DB_USERNAME=root
   DB_PASSWORD=
   ```

2. Execute as migrações no ambiente de testes:
   ```bash
   php artisan migrate --env=testing
   ```

---

### **Executando os Testes**

1. No terminal, execute o comando:
   ```bash
   php artisan test --filter=TaskApiTest
   ```

2. O Laravel executará os testes descritos em `tests/Feature/TaskApiTest.php`, cobrindo:
   - Criação de tarefas.
   - Listagem de tarefas.
   - Atualização de tarefas.
   - Exclusão de tarefas.

---

## **Estrutura de Diretórios Importantes**

```plaintext
project-root/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── TaskController.php  # Controlador principal
│   ├── Models/
│   │   ├── Task.php                # Modelo principal
├── config/
│   ├── l5-swagger.php              # Configurações do Swagger
├── database/
│   ├── migrations/
│   │   ├── {timestamp}_create_tasks_table.php  # Migração da tabela tasks
├── routes/
│   ├── api.php                     # Rotas da API
├── storage/
│   ├── api-docs/
│   │   ├── api-docs.json           # Arquivo gerado pelo Swagger
├── tests/
│   ├── Feature/
│   │   ├── TaskApiTest.php         # Testes automatizados
```

---

## **Recursos**

- **Framework**: [Laravel](https://laravel.com/)
- **Documentação**: [Swagger (L5-Swagger)](https://github.com/DarkaOnLine/L5-Swagger)
- **Testes**: PHPUnit, integrado no Laravel.