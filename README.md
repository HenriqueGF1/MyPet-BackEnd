![nome da imagem](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![nome da imagem](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![nome da imagem](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![nome da imagem](https://img.shields.io/badge/JWT-000000?style=for-the-badge&logo=JSON%20web%20tokens&logoColor=white)

# MeuPet

O sistema MyPet é uma plataforma online projetada para ajudar os usuários a encontrar animais para adoção. Com o MyPet, a adoção de animais de estimação se torna mais acessível e conveniente para os usuários, ao mesmo tempo, em que ajuda a encontrar lares amorosos para animais necessitados.

O Projeto
Esse projeto e somente a parte do Back-End para ter o projeto completo baixe também a parte do Front-End

[MyPet-FrontEnd](https://github.com/HenriqueGF1/MyPet-FrontEnd)

Passo a Passo para a instalação do projeto.

1. Clone seu projeto
2. Vá para o aplicativo de pasta usando o comando  `cd`  no seu cmd ou terminal
3. Execute  `composer install`  no seu cmd ou terminal
4. Copie o arquivo  `.env.example`  para  `.env`  na pasta raiz. Você pode digitar  `copy .env.example .env`  se estiver
   usando o comando Prompt Windows ou  `cp .env.example .env`  se estiver usando o terminal, Ubuntu
5. Abra o arquivo  `.env`  e altere o nome do banco de dados 

> [Script para o Banco de Dados do Projeto](/Banco%20de%20Dados/Script.sql)

(`DB_DATABASE`) ('mypet'), o nome de
   usuário (`DB_USERNAME`) e a senha (`DB_PASSWORD`) correspondem à sua configuração.  
   Por padrão, o nome de usuário é  `root`  e você pode deixar o campo da senha em branco.  (Isto é para Xampp) , Por
   padrão, o nome de usuário é  `root`  e a senha também é  `root`.

6. Execute  `php artisan key:generate`
7. Execute  `php artisan storage:link`
8. Execute `php artisan jwt:secret`, para a chave do JWT
9. Execute  `php artisan serve`
10. Vá ate o navegador e digite `http://127.0.0.1:8000/`
11. [MyPet Api no PostMan](https://documenter.getpostman.com/view/11959429/2s9Yyy7dc6)

## Tecnologias Utilizadas

<h2>Laravel 10</h2>

Laravel é um framework PHP livre e de código aberto utilizado no desenvolvimento de sistemas web, seguindo o padrão arquitetural MVC (Model-View-Controller). Ele oferece uma sintaxe expressiva e elegante que visa tornar o desenvolvimento web uma tarefa agradável, sem sacrificar a funcionalidade.

[Documentação](https://laravel.com/docs/10.x)

<h2>JWT (JSON Web Tokens)</h2>
JWT é um padrão aberto (RFC 7519) que define uma maneira compacta e autocontida para transmitir informações de forma segura entre partes como um objeto JSON. Os tokens JWT são usados para autenticação e troca segura de informações entre sistemas.

[Documentação](https://jwt-auth.readthedocs.io/en/develop/laravel-installation/)

<h2>Pt-br-validator</h2>
pt-br-validator é um pacote para validação de dados em Português Brasileiro no Laravel. Ele fornece regras de validação específicas para o contexto brasileiro, facilitando a validação de campos como CPF, CNPJ, telefones, CEP, entre outros.

[Documentação](https://github.com/LaravelLegends/pt-br-validator)

<h2>Laravel-pt-BR-localization</h2>
O laravel-pt-BR-localization é um pacote de localização para o Laravel, que fornece traduções em Português Brasileiro para as mensagens de validação padrão do Laravel. Ele permite que os desenvolvedores tenham mensagens de erro de validação em português, o que pode facilitar a compreensão para os usuários finais.

[Documentação](https://github.com/lucascudo/laravel-pt-BR-localization)

<h2>MySQL</h2>
MySQL é um sistema de gerenciamento de banco de dados relacional de código aberto e uma das tecnologias de banco de dados mais populares do mundo. Ele é amplamente utilizado em uma variedade de aplicativos, desde pequenos sites até grandes sistemas corporativos, devido à sua confiabilidade, escalabilidade e facilidade de uso.

[Documentação](https://www.mysql.com/)

<h1>Api</h1>

Para facilitar a navegação entre os endpoints e compreender as funcionalidades oferecidas pelo sistema.

[MyPet Api no PostMan](https://documenter.getpostman.com/view/11959429/2s9Yyy7dc6)
