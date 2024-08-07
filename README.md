# Desenvolvimento PHP - Gerenciamento de Eventos

Event Manager é um sistema de gerenciamento de eventos desenvolvido em PHP vanilla, utilizando o modelo MVC e banco de dados MySQL.

## Funcionalidades

- Criação, edição e exclusão de eventos.
- Visualização de eventos em um calendário interativo.

## Tecnologias Utilizadas

- PHP (Vanilla)
- MySQL
- HTML/CSS/JavaScript
- Bootstrap
- FullCalendar

## Pré-requisitos

- PHP 7.3+
- MySQL 5.7+
- Docker (opcional)

## Instalação

### Configuração em Servidor Local Apache

1. Clone o repositório:
    ```sh
    git clone https://github.com/marcelomileris/skedway.git
    ```

2. Navegue até o diretório do projeto:
    ```sh
    cd skedway
    ```

3. Configure o banco de dados no arquivo `config.php`.

4. Importe o arquivo SQL `script.sql` no seu banco de dados MySQL.

5. Configure o servidor Apache para apontar para o diretório do projeto.

6. Acesse o sistema via navegador:
    ```sh
    http://localhost/event-manager
    ```

### Utilizando Docker Compose

1. Clone o repositório:
    ```sh
    git clone https://github.com/marcelomileris/skedway.git
    ```

2. Navegue até o diretório do projeto:
    ```sh
    cd skedway
    ```

3. Execute o Docker Compose:
    ```sh
    docker-compose up -d
    ```

4. Acesse o sistema via navegador:
    ```sh
    http://localhost
    ```

## Uso

Você também pode acessar uma versão online do sistema através do endereço [https://skedway.marcelom.dev](https://skedway.marcelom.dev).

## Capturas de Tela

### Tela Principal
![Tela Principal](images/dashboard.jpg)

### Tela de Eventos (Novo)
![Tela de Eventos](images/new.jpg)

### Tela de Eventos (Edição)
![Tela de Eventos](images/edit.jpg)
