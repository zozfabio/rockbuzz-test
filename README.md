# rockbuzz-test

## Instruções para rodar as aplicações
> É importante rodar apenas os serviços ``blog-app`` e ``admin-app`` na primeira vez, para importar os dados de testes manualmente,
> pois o container que roda os testes de integração está junto no ``docker-compose.yml``
### 1) Clonar o projeto
``$ git clone https://github.com/zozfabio/rockbuzz-test.git``<br/>
``$ cd rockbuzz-test``<br/>
### 2) Instalar as dependencias das aplicações
``rockbuzz-test$ composer --working-dir=rockbuzz-oauth2-server install``<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-post-api install``<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-blog install``<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-admin install``<br/>
### 3) Compilar e Rodar o blog-app
``rockbuzz-test$ docker-compose build``<br/>
``rockbuzz-test$ docker-compose up -d blog-app admin-app``<br/>
### 3) Gerando o schema e importando os dados de teste
no serviço oauth2:<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-oauth2-server update-schema``<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-oauth2-server insert-test-data``<br/>
no serviço da API de posts:<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-post-api update-schema``<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-post-api insert-test-data``<br/>
### 4) Acessando no navegador
Blog: ``http://localhost:8002``<br/>
Admin: ``http://localhost:8003``<br/>

## Instruções para rodas os testes automatizados
Basta Rodar o container que executa os testes:<br/>
``rockbuzz-test$ docker-compose run test``<br/>
