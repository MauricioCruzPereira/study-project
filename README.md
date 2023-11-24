
# Projeto API em Laravel e PHP

Neste projeto, foi utilizado o Laravel Framework e o PHP para desenvolver uma API que utiliza a autenticação JWT (JSON Web Token). O projeto possui integração com banco de dados e testes unitários.


## Tecnologias Utilizadas

* PHP
* Laravel
* Sanctum
* Docker
    * Mariadb
    * Nginx
## Instalação

Clone o repositório do projeto em seu ambiente local:

1. **Clone o Repositório:**
   ```bash
   git clone https://github.com/MauricioCruzPereira/study-project.git
   ```

2. **Acesse o Diretório do Projeto:**
   ```bash
   cd study-project
   ```

3. **Configuração do Docker:**
   Certifique-se de ter o Docker instalado e em execução. Utilizamos o Docker para facilitar a configuração do ambiente.

4. **Construa e Execute os Contêineres Docker:**
   ```bash
   docker-compose up -d
   ```

5. **Instale as Dependências do Composer:**
   ```bash
   composer install
   ```

6. **Configure o Ambiente:**
   Renomeie o arquivo `.env.example` para `.env` e configure as variáveis de ambiente conforme necessário.
  ```bash 
    cp .env.example .env
  ```

7. **Gere a Chave de Aplicação:**
   ```bash
    php artisan key:generate
   ```

8. **Execute as Migrações e Sementes:**
   ```bash
    php artisan migrate
   ```

9. *Caso ao rodar o comando de teste ou de migrate apresentar um erro de conectividade de bando de dados, siga os passoa a baixo:*
  * Linux:/etc/hosts
  * Windows: C:\Windows\System32\drivers\etc\hosts
  * Nesse arquivo adicionar a seguinte linha: 
  ```bash
    127.0.0.1	db
  ```

## Endpoints API

Os endpoints estão disponíveis na pasta `collections` na raiz do projeto. Consulte esses arquivos para obter informações sobre os endpoints e como interagir com a API.

## Rodando os testes

Para rodar os testes, rode o seguinte comando

**Execute os Testes:**
```bash
php artisan test
```


## Github Actions

**.github/workflows**

* Esse arquivo é utilizado para rodar sempre que realizar uma ação de pull request ou merge na main. Configurei o arquivo "laravel-test.yml" para rodar os tests sempre que subir algo, fazendo assim que otimize o tempo e caso mude de mais o código, venha a testar todos os endpoints para ver se o esperado manteve ou houve alteração.