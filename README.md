# [root-at-writeups](https://afomon.antrob.eu/) 

Este projeto foi desenvolvido no âmbito das disciplinas de **Programação Web 2** e **Projeto Integrado 3**. O objetivo principal é a criação de uma aplicação web robusta, com foco especial na segurança da informação e boas práticas de desenvolvimento backend.

## Competências e Tecnologias
Este trabalho permitiu aprofundar conhecimentos em:

* **Frontend:** HTML5, CSS3 (Design Responsivo).
* **Backend:** PHP (Integração com MySQL).
* **Controlo de Versões:** Git e GitHub.
* **DevOps Básico:** Deployment automatizado via GitHub Actions (FTP).

## Segurança Defensiva e Boas Práticas
Um dos pilares deste projeto foi a implementação de medidas de segurança para proteção de dados sensíveis e integridade do sistema:

* **Prevenção de Exposição de Dados Sensíveis:**
    * Eliminação de credenciais *hardcoded* (passwords escritas diretamente no código).
    * Implementação de ficheiro de configuração isolado (`db_config.php`) para gestão de credenciais de acesso à base de dados.
* **Segurança no Repositório (Git):**
    * Configuração rigorosa do ficheiro `.gitignore` para impedir que chaves de acesso e ficheiros de configuração sensíveis sejam enviados para repositórios públicos (GitHub).
* **Conexão Segura (PDO):**
    * Utilização de **PDO** (PHP Data Objects) para conexões à base de dados, garantindo tratamento de erros seguro (try/catch) sem expor detalhes da infraestrutura ao utilizador final.

## Implementação Técnica de Segurança

Para além da infraestrutura, o código-fonte inclui mecanismos de defesa ativos contra as vulnerabilidades web mais comuns (OWASP Top 10):

### Prevenção de SQL Injection (SQLi)
Todas as interações com a base de dados são estritamente realizadas através de **Prepared Statements**.
* **Implementação:** Ao separar a estrutura da query SQL dos dados fornecidos pelo utilizador, o motor da base de dados trata o *input* estritamente como dados literais e não como código executável.
* **Impacto:** Esta prática neutraliza eficazmente tentativas de injeção de comandos SQL maliciosos (ex: `' OR '1'='1`) nos formulários de login, registo e pesquisa.

### Mitigação de Cross-Site Scripting (XSS)
O projeto aplica uma política rigorosa de "Output Encoding" em todas as áreas onde conteúdo gerado pelo utilizador é exibido.
* **Implementação:** Antes de qualquer dado ser renderizado no navegador (sejam comentários, nomes de utilizador ou títulos de posts), é processado pela função `htmlspecialchars()`.
* **Impacto:** Caracteres especiais que poderiam ser interpretados como HTML ou JavaScript (como `<script>`) são convertidos em entidades inofensivas, impedindo a execução de scripts maliciosos no cliente (*Stored XSS*).

### Criptografia e Armazenamento de Credenciais
A segurança das palavras-passe segue os padrões modernos de criptografia, garantindo que credenciais nunca são armazenadas em texto limpo (*plain-text*).
* **Hashing:** No ato do registo, as palavras-passe são processadas pela função `password_hash()`, que aplica um algoritmo de hash forte (Bcrypt) e gera um *salt* aleatório automaticamente.
* **Validação:** A autenticação utiliza `password_verify()`, prevenindo ataques de *timing* e garantindo que a comparação é feita de forma segura contra o hash armazenado.

### Controlo de Acesso e Gestão de Sessões
A autorização é gerida através de sessões seguras (`$_SESSION`), com verificações explícitas de privilégios.
* **Controlo de Rotas:** Scripts sensíveis, como a criação de novos artigos, possuem validações no início da execução. O acesso não autorizado é imediatamente bloqueado, prevenindo *Forced Browsing*.
* **Isolamento de Funcionalidades:** Ações interativas como comentar ou dar "like" são restritas ao backend, rejeitando pedidos que não provenham de sessões autenticadas válidas.