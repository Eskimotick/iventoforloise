#Instalando o iVento S2

##Vai para pasta laravel:
    $ cd laravel
    
##Instala as dependências do laravel:
    $ composer install
    
##Gera o .env a partir do .env.example:
    $ cp .env.example
    
##Gera a chave do laravel:
    $ php artisan key:generate
    
##Altera o .env:
    muda os parâmetros do bd para os relativos a sua maquina
    
##Instala o banco de dados:
    $ php artisan migrate --seed
    
##Volta para a pasta base:
    $ cd ..

##Vai para a pasta angular:
    $ cd angular
    
##Instala as dependências do angular:
    $ npm install
