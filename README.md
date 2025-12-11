# root-at-writeups

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
