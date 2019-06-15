create type lista_telefones as varray(5) of varchar(15);
/
create type endereco as object(estado char(2), bairro char(30), numero integer, cidade char(30), cep char(8));
/
create type lista_enderecos as TABLE of endereco;
/
create type categoria as object (titulo char(30), prazo_max integer, tipo char(30));
/
create type usuario as object (email char (30), senha char(20), cpf char (11), nome char(100), apelido char(10), enderecos lista_enderecos, telefones lista_telefones);
/
create type anuncio as object (titulo char (30),descricao char (200),data_ date, valor_inicial float,e_de ref usuario, possui_c ref categoria, disponivel number(1,0)) not final;
/
create type negociacao under anuncio (tipo integer, tempo_devolucao integer);
/
create type leilao under anuncio (data_abertura date, data_fim date);
/
create type compra as object (e_de ref usuario, do_anuncio ref anuncio, data_ date, precofim float);
/
create type lance as object (e_de ref usuario, do_leilao ref leilao, data_ date, valor float);
/
create table categorias of categoria;
/
create table usuarios of usuario nested table enderecos store as endereco_usuario;
/
create table anuncios of anuncio;
/
create table negociacoes of negociacao;
/
create table leiloes of leilao;
/
create table compras of compra;
/
create table lances of lance;
/


/* categorias*/
/* create type categoria as object (titulo char(30), prazo_max integer, tipo char(30));*/

insert into categorias values ('Limpeza', 30, 'Serviço');
/
insert into categorias values ('Mecanica', 30, 'Produto');
/
insert into categorias values ('Jardinagem', 30, 'Produto');
/
insert into categorias values ('Pecuaria',30, 'Produto');

/* usuarios */
/* create type usuario as object (email char (30), cpf char (11), nome char(100), apelido char(10), enderecos lista_enderecos, telefones lista_telefones); */

insert into usuarios values ('astolfo@gmail.com','senha','11922548213','Astolfo Filho','Astolfinho', lista_enderecos(endereco('mg','centro',22,'vicosa','39021910')),lista_telefones('3891-2233','3901-2211'));
/
insert into usuarios values ('maju@ufv.br','insirasenha','19329412039','Maria Julia','Maju', lista_enderecos(endereco('mg','centro',33,'vicosa','39012341'),lista_telefones('3912-3321')));

/* negociacoes */
/* create type anuncio as object (titulo char (30),descricao char (200),data_ date, valor_inicial float,e_de ref usuario, possui_c ref categoria, disponivel number(1,0)) not final; */
/* create type negociacao under anuncio (tipo integer, tempo_devolucao integer); */
/* categorias: 0-venda simples, 1- troca, 2-doacao, 3- emprestimo*/
/
insert into negociacoes values('Girassol','Mudas de Girassol para jardim',date '2019-06-14' ,30, (select ref(u) from usuarios u where u.email='astolfo@gmail.com'),(select ref(c) from categorias c where c.tipo='Limpeza'),1,0,0);
/
insert into negociacoes values ('Motor','Motor para Uno quadrado',date '2019-05-14',30,(select ref(u) from usuarios u where u.email = 'maju@ufv.br'),(select ref (c) from  categorias c where tipo = 'Mecanica'),0,1,0);
/
insert into negociacoes values ('Faxina','Faxina em apartamento', date '2019-05-14',30,(select ref(u) from usuarios u where u.email = 'maju@ufv.br'),(select ref(c) from categorias c where tipo = 'Limpeza'),0,0,0);

/* leiloes */
/* create type anuncio as object (titulo char (30),descricao char (200),data_ date, valor_inicial float,e_de ref usuario, possui_c ref categoria, disponivel number(1,0)) not final; */
/* create type leilao under anuncio (data_abertura date, data_fim date); */
/
insert into leiloes values ('Boizao','Boi de 1T',date '2019-06-14', 10000, (select ref(u) from usuarios u where u.email = 'astolfo@gmail.com'),(select ref(c) from categorias c where c.tipo = 'Pecuaria'),1,date '2019-06-20',date '2019-06-30');

/* compras */
/* create type compra as object (e_de ref usuario, do_anuncio ref anuncio, data_ date, precofim float); */

/
insert into compras values ((select ref(u) from usuarios u where u.email = 'astolfo@gmail.com'), (select ref(an) from anuncios an where an.titulo = 'Faxina'), date '2019-05-15', 30);


/* lances */
/* create type lance as object (e_de ref usuario, do_leilao ref leilao, data_ date, valor float); */

insert into lances values ((select ref(u) from usuarios u where u.email = 'maju@ufv.br'),(select ref(le) from leiloes le where le.titulo ='Boizao'),date '2019-06-15', 11000 );
