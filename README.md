# mapTest
Estou utilizando um nome fictício para não expor a empresa em questão.

## Instalação
Executar: 
```bash
docker-compose up
```

## Aplicação (Passo 1):
Ele subirá a aplicação na porta 8000. No meu caso, o endereço ficou:http://localhost:8000/
O endereço acima aparecerá o welcome do CodeIgniter, o endereço para a busca dos pontos encontra-se em http://localhost:8000/buscas

Podemos logar como:
- Login: admin
- Senha: admin

Aparecerá uma tela como abaixo:
![Formulário de Buscas](https://raw.githubusercontent.com/bacci/mapTest/master/myapp/assets/assets/img/buscar.png)

Ao buscar, o seguinte resultado é esperado:
![Resultado da Busca](https://raw.githubusercontent.com/bacci/mapTest/master/myapp/assets/assets/img/resultado.png)

Adicionei um debugger apenas para visualizar o retorno:
![Debug do Resultado da Busca](https://raw.githubusercontent.com/bacci/mapTest/master/myapp/assets/assets/img/debug.png)

## Importador (Passo 2):

Para executar o importador, devemos entrar na pasta myapp, e depois executar o seguinte comando (Necessário ter o php na máquina):
```bash
php index.php Buscas porArquivo 'ceps.csv'
```
![Programa Rodando](https://raw.githubusercontent.com/bacci/mapTest/master/myapp/assets/assets/img/programa_rodando.png)

Abaixo, você pode conferir o arquivo gerado:
![Arquivo Gerado](https://raw.githubusercontent.com/bacci/mapTest/master/myapp/assets/assets/img/arquivo_gerado.png)
