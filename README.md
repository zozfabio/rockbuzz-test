# rockbuzz-test

## Instruções para rodar as aplicações
> É importante rodar apenas o ``blog-app`` da primeira vez, para importar os dados de testes manualmente,
> pois o container que roda os testes de integração está junto no ``docker-compose.yml``
### 1) Clonar o projeto
``$ git clone https://github.com/zozfabio/rockbuzz-test.git``<br/>
``$ cd rockbuzz-test``<br/>
### 2) Instalar as dependencias das aplicações
``rockbuzz-test$ composer --working-dir=rockbuzz-oauth2-server install``<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-post-api install``<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-blog install``<br/>
### 3) Compilar e Rodar o blog-app
``rockbuzz-test$ docker-compose build``<br/>
``rockbuzz-test$ docker-compose up -d blog-app``<br/>
### 3) Gerando o schema e importando os dados de teste
``rockbuzz-test$ composer --working-dir=rockbuzz-oauth2-server update-schema``<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-oauth2-server insert-test-data``<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-post-api update-schema``<br/>
``rockbuzz-test$ composer --working-dir=rockbuzz-post-api insert-test-data``<br/>
### 4) Acessando o blog-app no navegador
Agora é só abrir o navegar na página ``http://localhost:8002``<br/>

## Instruções para rodas os testes automatizados
Basta Rodar o container que executa os testes:
``rockbuzz-test$ docker-compose run test``<br/>
