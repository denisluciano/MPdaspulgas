# Mercado Público das Pulgas

## Descrição
Trabalho da disciplina de Banco de dados 2 UFV, que consiste desenvolver sistema usando banco de dados SGBD-OR

## Requisitos para desenvolvimento
- PHP >= 7.1.3 (Pode ser instalado através do XAMMP)
- Composer para gerenciar as dependencias do projeto (https://getcomposer.org/)
- Oracle Database 19c (https://www.oracle.com/technetwork/database/enterprise-edition/downloads/index.html)
- OCI8 Extension (Pela configuração defealt do XAMMP nos não temos conectividade PHP oracle, para isso usamos essa extensão OCI8 {link video: https://www.youtube.com/watch?v=KJme5JMxKeo} ou apenas seguir esse tutorial{
    Passo 0: Ter instalado o Oracle Database. Detalhe, na hora de instalar não usar pasta que tenha espaço no nome nem nas pastas raizes e inclusive na de instalação, pois vai dar erro
    Passo 1: Instala o XAMMP
    Passo 2: Baixa Instant Client(Version 12.1.0.2.0) https://www.oracle.com/technetwork/topics/winsoft-085727.html
    Passo 3: Extrai e copia para pasta C:
    Passo 4: Copia diretorio da pasta e adiciona nas variaveis(path do windows a pasta)
    Passo 5: Vai na pasta do XAMMP e abre php\php.ini e busca no arquivo "oracle" e add seguinte extension "extension=php_oci8_12c.dll" (sem as ") na linha abaixo que tem "Use with Oracle Database 12c Instant Client" e salva
    Passo 6: Para testar cria uma pasta test no htdocs do xammp e cria um arquivo .php com seguinte código
    
    https://www.dropbox.com/s/3je768fj6fig0xe/scriptdemo.php?dl=0

    Onde deve se substituir  username pelo seu e password pra qual foi definido. De padrão username é system. Pra saber service_name você abre SQL Plus pelo menu iniciar windows e loga e digitaa comando "show parameter service_name" e então o value retornado é o service_name.

    E em seguida abre xammp e deixa apache rodando e abre no navegador localhost/test/test.php

    Se der sucesso essa etapa está pronta
})

## Tecnologias ultilizada
- Framework Laravel(BackEnd)
- Framework VueJs(FrontEnd)
- Framework Vuetify(Podermos usar sistema de grid e vários componentes prontos para FrontEnd)
- Package npm Axios(Comunicar FrontEnd com BackEnd)
- Package composer barryvdh/laravel-cors(Resolver problema de CORS)
- Package npm vue-router(Para trabalharmos com rota no FrontEnd)
- Package npm moment(Para trabalharmos com hora)
- Oracle Database 19c(------- Depois de um tempo de desenvolvimento colocamos nosso banco no servidor da Amazon RDS, então não precisa do oracle database na maquina, mas precisa de fazer as outras configurações, como as do "laravel-oci8" e que os dados pra colocar no .env vão ser obtidos pela amazon)
- Biblioteca yajra/laravel-oci8 (Como Laravel não tem suporte nativo para oracle, com essa biblioteca conseguimos suplir essa necessidade link: https://github.com/yajra/laravel-oci8) (Para quem for instalar  do zero essa biblioteca no laravel, tem um tutorial nesse link aqui: https://www.youtube.com/watch?v=i9C2thlgOg8 ele explica direitinho e ainda mostra uma ferramenta para Ver tabelas do Oracle Database. Unico passo confuso é de onde olha o DB_PORT, que é na pasta que você fez dowload do oracle e não na instalação(meu caso oracle19c\network\admin\TNSNAMES.ORA))

## Desenvolvido por :
- David Aleixo
- Denis Luciano
- Henrique Penna
- Mayke

## License
