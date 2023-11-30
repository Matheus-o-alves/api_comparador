# API Comparador

Este é um repositório que contém uma API desenvolvida em PHP com o framework Laravel, proporcionando serviços de comparação e simulação de empréstimos.

## Execução da API

### Pré-Requisitos

- PHP instalado (recomendado PHP >= 7.4)
- Composer instalado

### Passos

1. **Clonar o Repositório:**

    ```bash
    git clone https://github.com/Matheus-o-alves/api_comparador.git
    ```

2. **Acessar o Diretório do Projeto:**

    ```bash
    cd api_comparador
    ```

3. **Instalar as Dependências do Laravel:**

    ```bash
    composer install
    ```

4. **Configurar o Arquivo `.env`:**

    Copie o arquivo `.env.example` e renomeie para `.env`. Em seguida, configure as variáveis de ambiente, como as configurações do banco de dados.

5. **Gerar a Chave da Aplicação do Laravel:**

    ```bash
    php artisan key:generate
    ```

6. **Executar o Servidor Local do PHP:**

    ```bash
    php artisan serve
    ```

    A API estará disponível em `http://localhost:8000`.

## Alterações Realizadas

### SimuladorController.php

`     O arquivo SimuladorController.php foi modificado para incluir métodos que realizam simulações de empréstimos, filtram instituições, convênios e número de parcelas, manipulando os dados conforme os parâmetros fornecidos.
    
    
 ### api.php

     No arquivo api.php, foram adicionados cabeçalhos para permitir o acesso CORS, habilitando solicitações de diferentes origens.



    
