# Sistema de Gerenciamento de Barbearia

Este projeto é um sistema de gerenciamento de barbearia que permite agendar cortes, gerenciar barbeiros e visualizar horários disponíveis. Ele é construído em PHP e utiliza um banco de dados para armazenar as informações.

## Estrutura do Projeto

- **admin/**: Contém arquivos relacionados à administração do sistema.

  - **auth/**: Autenticação de usuários.
    - `autentica.php`: Página de login.
    - `logout.php`: Página de logout.
  - **barbeiro/**: Gerenciamento de barbeiros.
    - `editar_barbeiro.php`: Editar informações de um barbeiro.
    - `inserir_barbeiro.php`: Inserir um novo barbeiro.
    - `remover_barbeiro.php`: Remover um barbeiro.
    - `visualizar_barbeiro.php`: Visualizar informações de um barbeiro.
  - **forms/**: Formulários para gerenciamento de barbeiros.
    - `formulario_barbeiro.php`: Formulário para inserir barbeiro.
    - `formulario_editar_barbeiro.php`: Formulário para editar barbeiro.
  - `gerenciar_barbearia.php`: Página principal de gerenciamento da barbearia.
  - [`index.php`](command:_github.copilot.openRelativePath?%5B%7B%22scheme%22%3A%22file%22%2C%22authority%22%3A%22%22%2C%22path%22%3A%22%2Fc%3A%2Fxampp%2Fhtdocs%2Fbarbearia%2Findex.php%22%2C%22query%22%3A%22%22%2C%22fragment%22%3A%22%22%7D%5D "c:\\xampp\htdocs\barbearia\index.php"): Página inicial da administração.

- **agendamento/**: Contém arquivos relacionados ao agendamento de cortes.

  - `agendar_corte.php`: Página para agendar um corte.
  - `buscar_horarios.php`: Buscar horários disponíveis.
  - `cancelar_agendamento.php`: Cancelar um agendamento.
  - `selecionar_barbearia.php`: Selecionar uma barbearia.
  - `visualiza_agendado.php`: Visualizar agendamentos.

- **config/**: Configurações do sistema.

  - `Database.php`: Classe para conexão com o banco de dados.

- **imgs/**: Diretório para armazenar imagens.

- [`index.php`](command:_github.copilot.openRelativePath?%5B%7B%22scheme%22%3A%22file%22%2C%22authority%22%3A%22%22%2C%22path%22%3A%22%2Fc%3A%2Fxampp%2Fhtdocs%2Fbarbearia%2Findex.php%22%2C%22query%22%3A%22%22%2C%22fragment%22%3A%22%22%7D%5D "c:\\xampp\htdocs\barbearia\index.php"): Página inicial do sistema.
- [`splash_screen.php`](command:_github.copilot.openRelativePath?%5B%7B%22scheme%22%3A%22file%22%2C%22authority%22%3A%22%22%2C%22path%22%3A%22%2Fc%3A%2Fxampp%2Fhtdocs%2Fbarbearia%2Fsplash_screen.php%22%2C%22query%22%3A%22%22%2C%22fragment%22%3A%22%22%7D%5D "c:\\xampp\htdocs\barbearia\splash_screen.php"): Tela de splash.

## Como Usar

### Requisitos

- Ter um servidor web instalado (recomendo o Xampp)
- Banco de dados MySQL

### Instalação

1. Clone o repositório para o seu servidor web:

   ```sh
   git clone https://github.com/bernardomerlo/barbearia.git
   ```

2. Configure o banco de dados:

   - Crie um banco de dados MySQL.
   - Importe o arquivo `database.sql` para criar as tabelas necessárias.

3. Configure a conexão com o banco de dados:

   - Edite o arquivo [`config/Database.php`](command:_github.copilot.openRelativePath?%5B%7B%22scheme%22%3A%22file%22%2C%22authority%22%3A%22%22%2C%22path%22%3A%22%2Fc%3A%2Fxampp%2Fhtdocs%2Fbarbearia%2Fconfig%2FDatabase.php%22%2C%22query%22%3A%22%22%2C%22fragment%22%3A%22%22%7D%5D "c:\\xampp\htdocs\barbearia\config\Database.php") com as informações do seu banco de dados.

4. Inicie o servidor web e acesse o projeto pelo navegador:
   ```sh
   localhost/barbearia
   ```

### Funcionalidades

- **Agendamento de Cortes**: Permite que os clientes agendem cortes com os barbeiros disponíveis.
- **Gerenciamento de Barbeiros**: Permite adicionar, editar, visualizar e remover barbeiros.
- **Autenticação de Usuários**: Sistema de login e logout para administradores.

### Exemplos de Uso

- Para agendar um corte, acesse [`localhost/barbearia`](command:_github.copilot.openRelativePath?%5B%7B%22scheme%22%3A%22file%22%2C%22authority%22%3A%22%22%2C%22path%22%3A%22%2Fc%3A%2Fxampp%2Fhtdocs%2Fbarbearia%2Fagendamento%2Fagendar_corte.php%22%2C%22query%22%3A%22%22%2C%22fragment%22%3A%22%22%7D%5D "c:\\xampp\htdocs\barbearia\index.php").
- Para gerenciar quais cortes voce já tem agendado e seus barbeiros (caso voce seja admnistrador), acesse [`admin/gerenciar_barbearia.php`](command:_github.copilot.openRelativePath?%5B%7B%22scheme%22%3A%22file%22%2C%22authority%22%3A%22%22%2C%22path%22%3A%22%2Fc%3A%2Fxampp%2Fhtdocs%2Fbarbearia%2Fadmin%2Fgerenciar_barbearia.php%22%2C%22query%22%3A%22%22%2C%22fragment%22%3A%22%22%7D%5D "c:\\xampp\htdocs\barbearia\admin\gerenciar_barbearia.php").
