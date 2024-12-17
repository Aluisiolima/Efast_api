
---

# Efats Menu API

Este repositório é dedicado ao desenvolvimento da API do **Efats Menu**, um cardápio digital eficiente e intuitivo.

---

## 🚀 **Regras de Colaboração**

1. **Leia a Documentação Antes de Iniciar**  
   Familiarize-se com as informações deste documento antes de contribuir.

2. **Commit na `main` é Proibido**  
   - Nunca faça commits diretamente na branch `main`.  
   - É **boa prática** criar sua própria branch seguindo o padrão:  
     ```
     <seu-nome>.dev
     ```
     Exemplo: `joao-silva.dev`

3. **Realize Pull Requests (PRs)**  
   - Após finalizar suas alterações, faça um Pull Request para a branch `main`.  
   - Aguarde a revisão e aprovação de outros colaboradores antes de realizar o merge.

4. **Padronização de Código**  
   - Mantenha o código limpo e organizado.  
   - Utilize **nomes claros e descritivos** para variáveis, funções e arquivos.

5. **Testes**  
   - Garanta que o código seja testado antes de abrir um Pull Request.  
   - Se possível, inclua testes unitários para as suas alterações.

---

## 🛠 **Setup do Projeto**

### **Pré-requisitos**
- Php (versão mínima: 7.x)
- Gerenciador de pacotes `composer`
- Banco de dados MySQL

### **Passos para Inicialização**
1. Clone o repositório:  
   ```bash
   git clone https://github.com/Aluisiolima/Efast_api.git
   ```
2. Acesse a pasta do projeto:  
   ```bash
   cd Efats_api
   ```
3. Instale as dependências:  
   ```bash
   composer update
   ```
4. Configure as variáveis de ambiente:  
   - Crie um arquivo `.env` na raiz do projeto.  
   - Preencha com as seguintes informações (exemplo):  
     ```env
     PORT=3000
     DB_HOST=localhost
     DB_USER=root
     DB_PASS=senha
     DB_NAME=efats_db
     ```

## 📚 **Estrutura do Projeto**

```
efats-menu-api/
│
├── index.php         # Raiz do projeto 
├── controllers/      # Controlador de Services
├── services/         # Logicas de serviços
├── routes/           # Definições de endpoints
├── models/           # Modelos de banco de dados
├── core/             # Coracao do projeto 
├── http/             # Responsavel pela interacao http da aplicacao
├── utils/            # Arquivos util ex: class de validates
└── .env              # Exemplo do arquivo de variáveis de ambiente
```

---

## 📝 **Endpoints**

### **Exemplo de Estrutura**  
| Método | Rota              | Descrição                   | Autenticação |
|--------|-------------------|-----------------------------|--------------|
| GET    | `/produtos`       | Lista todos os produtos     | Não          |
| POST   | `/produtos`       | Adiciona um novo produto    | Sim          |
| PUT    | `/produtos/:id`   | Atualiza um produto         | Sim          |
| DELETE | `/produtos/:id`   | Remove um produto específico| Sim          |

---

## 👨‍💻 **Boas Práticas de Desenvolvimento**
- Utilize **nomes semânticos** e claros.
- Crie commits pequenos e descritivos.
- Faça revisões de código (`Code Review`) antes de aprovar um PR.

---

## 🧩 **Próximos Passos**
1. Definição completa dos endpoints.
2. Escolha do banco de dados.
3. Implementação de autenticação.

---
