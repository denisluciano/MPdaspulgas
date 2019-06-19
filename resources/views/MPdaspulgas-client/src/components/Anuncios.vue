<template>
  <v-container align-center>
    <v-container fluid>
        <v-layout align-center justify-space-between row wrap>
          <v-flex xs12 md6>
            <h3 class="headline mb-0">Anúncios ativos no momento</h3>
            <v-btn
            color="red" dark
            class="mt-4"
            @click="cria_anuncio"
          >
            Criar Anúncio
          </v-btn>
          </v-flex>

          <v-flex xs4 md4>

              <v-text-field
                color="#ea3b2e"
                v-model="search"
                append-icon="search"
                label="Pesquisar"
                single-line
                hide-details
              ></v-text-field>
            </v-flex>
          </v-layout>
          </v-container>
      <v-toolbar tabs flat color="transparent">
      <template>
        <v-tabs
          v-model="tabs"
          fixed-tabs
          color="transparent"
        >
          <v-tabs-slider color="#ea3b2e"></v-tabs-slider>
            <v-tab href="#mobile-tabs-5-1" class="red--text" >
              Vendas
            </v-tab>
            <v-tab href="#mobile-tabs-5-2" class="red--text" >
              Leilões
            </v-tab>
            <v-tab href="#mobile-tabs-5-3" class="red--text" >
              Empréstimos
            </v-tab>
            <v-tab href="#mobile-tabs-5-4" class="red--text" >
              Doações
            </v-tab>
        </v-tabs>
      </template>

    </v-toolbar>
    <br>
    <v-layout>
      <v-tabs-items v-model="tabs">
        <v-tab-item
          v-for="i in 4"
          :key="i"
          :value="'mobile-tabs-5-' + i"
        >
        <v-layout v-if="i == 1" row wrap>
          <v-flex v-for="anuncio in anuncios_filtro" :key="anuncio.id">
            <v-card width="355px" class="ma-2">
              <v-img
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              >
              </v-img>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> -
                  <span>R$ {{anuncio.valor_inicial}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="green" @click="compra(anuncio,1)">Comprar</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio,1)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>

          </v-flex>
        </v-layout>
        <v-layout v-if="i == 2" row wrap>
          <v-flex v-for="anuncio in leiloes_filtro" :key="anuncio.id">
            <v-card width="355px" class="ma-2">
              <v-img
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              >

              </v-img>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> -
                  <span>R$ {{anuncio.valor_inicial}} maior lance</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="green" @click="compra(anuncio,2)">Dar Lance</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio,2)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>

          </v-flex>
        </v-layout>
        <v-layout v-if="i == 3" row wrap>
          <v-flex v-for="anuncio in emprestimos_filtro" :key="anuncio.id">
            <v-card width="355px" class="ma-2">
              <v-img
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              >
              </v-img>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> -
                  <span>R$ {{anuncio.valor_inicial}}/Dia</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="green" @click="compra(anuncio,3)">Alugar</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio,3)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>

          </v-flex>
        </v-layout>
        <v-layout v-if="i == 4" row wrap>
          <v-flex v-for="anuncio in doacoes_filtro" :key="anuncio.id">
            <v-card width="355px" class="ma-2">
              <v-img
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              >
              </v-img>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> -
                  <span>{{anuncio.valor_inicial}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="green" @click="compra(anuncio,4)">Aceitar</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio,4)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>

          </v-flex>
        </v-layout>

      </v-tab-item>
    </v-tabs-items>
  </v-layout>
    <v-dialog v-model="dialog" max-width="650px" v-if="item_selecionado">
      <v-card>
        <v-toolbar dark>
          <v-toolbar-title>{{item_selecionado.titulo}}</v-toolbar-title>
        </v-toolbar>
        <v-img
                class="white--text"
                height="355px"
                :src="item_selecionado.foto"
              >
              </v-img>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout row wrap>
              <v-flex xs6>
                <v-text-field background-color='white' readonly outline hide-details required="" v-model="item_selecionado.valor_inicial" label="Valor do Anúncio"></v-text-field>
              </v-flex>
              <v-flex xs6>
                <v-text-field background-color='white' readonly outline hide-details required="" v-model="item_selecionado.telefone" label="Telefone para Contato"></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-textarea auto-grow background-color='white' readonly outline hide-details required="" v-model="item_selecionado.descricao" label="Descrição do Anúncio"></v-textarea>
              </v-flex>
            </v-layout>
          </v-container>
          <v-card-actions>
            <v-btn color="green darken-1" flat @click="compra(item_selecionado,tipo_selecionado)">{{comprar}}</v-btn>
            <v-btn color="red darken-1" flat @click="dialog = false">Denunciar</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
        </v-card-text>
      </v-card>
    </v-dialog>

    <v-dialog
      v-model="mensagem.dialog"
      max-width="400"
    >
      <v-card>
        <v-card-title class="headline green--text">{{mensagem.titulo}}</v-card-title>
        <v-card-text>{{mensagem.message}}</v-card-text>
        <v-layout row wrap v-if="mensagem.input">
        <v-flex xs6 v-if="mensagem.input">
          <v-text-field class='ml-3' background-color='#f7f2f2' outline hide-details required="" v-model="mensagem.lance" label="Seu lance"></v-text-field>
        </v-flex>
        <v-flex xs6 v-if="mensagem.input">
        <v-btn
            large
            color="green darken-1"
            flat="flat"
            @click="dar_lance"
          > DAR LANCE
          </v-btn>
        </v-flex>
        </v-layout>
        <v-card-actions>

          <v-spacer></v-spacer>
          <v-btn
            v-if="mensagem.input == false"
            color="green darken-1"
            flat="flat"
            @click="mensagem.dialog = false"
          > Ok
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="cadastrar_anuncio" max-width="800px">
      <v-card>
        <v-toolbar dark>
          <v-toolbar-title>Cadastrar novo Anúncio</v-toolbar-title>
        </v-toolbar>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout row wrap>
              <v-flex xs12>
                <v-text-field background-color='#f7f2f2' outline hide-details required="" v-model="cadastro.titulo" label="Título do Anúncio"></v-text-field>
              <br></v-flex>
              <v-flex xs6>
              <v-select
                :items="tipos"
                label="Tipo de anúncio"
                v-model="tipo_anuncio"
                background-color='#f7f2f2'
                outline
              ></v-select>
            </v-flex>
              <v-flex xs6>
                <v-text-field background-color='#f7f2f2' :disabled="disable" outline hide-details required="" v-model="cadastro.valor_inicial" :label="label_preco"></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-textarea auto-grow background-color='#f7f2f2' outline hide-details required="" v-model="cadastro.descricao" label="Descrição do Anúncio"></v-textarea>
              </v-flex>
            </v-layout>
          </v-container>
          <v-card-actions>
            <v-btn color="green darken-1" flat @click="cadastraAnuncio">Fazer Anúncio</v-btn>
            <v-btn color="red darken-1" flat @click="cadastrar_anuncio = false">Cancelar</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-container>
</template>
<script>
  const axios = require('axios');
  export default {
    data: vm => ({
      mensagem:{
        dialog: false,
        message: '',
        titulo: '',
        input: false,
        lance: null
      },
      lance:{
        vencendo: 20,
        do_leilao: null,
        id_usuario: null,
        lance: null
      },
      comprar: null,
      tipo_selecionado: null,
      cadastrar_anuncio: false,
      label_preco: 'Preço do Anúncio',
      tipo_anuncio: null,
      disable: false,
      tipos: ['Venda', 'Leilão', 'Empréstimo', 'Doação'],
      cadastro:{
        tipo: null,
        titulo: null,
        foto: null,
        valor_inicial: null,
        descricao: null,
      },
      tabs: null,
      dialog: false,
      item_selecionado: null,
      search: '',
      categoria_atual:[],
      anuncios_filtro:[],
      emprestimos_filtro:[],
      doacoes_filtro:[],
      leiloes_filtro:[],
      anuncios:[
        {
        id: 1,
        telefone: '(31) 99714-1569',
        titulo: 'Praia Linda',
        foto: 'https://cdn.vuetifyjs.com/images/cards/docks.jpg',
        valor_inicial: '4000',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        id: 2,
        telefone: '(31) 99714-1569',
        titulo: 'Cavalo 5 anos',
        foto: 'http://www.porforadaspistas.com.br/wp-content/uploads/2016/11/frankel-e-um-cavalo-de-corrida_976399.jpg',
        valor_inicial: '200',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        id: 3,
        telefone: '(31) 99714-1569',
        titulo: 'Carro novíssimo',
        valor_inicial: '40000',
        foto: 'https://www.luxurysociety.com/media/uploads/thumbnails/filer_public_thumbnails/cc/04/cc04f3d6-9769-4e90-85fc-b730c8c6f561/bugatti.png__1024x450_q85_crop_subsampling-2_upscale.png',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        id: 4,
        telefone: '(31) 99714-1569',
        titulo: 'Porco de granja',
        valor_inicial: '500',
        foto: 'https://www.mundoecologia.com.br/wp-content/uploads/2019/04/Porco-3.jpg',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        id: 5,
        telefone: '(31) 99714-1569',
        titulo: 'Lixeira infantil',
        foto: 'https://www.casadaeducacao.com.br/octopus/design/images/34/products/o/lixeiracoletaseletivafresooo.jpg',
        valor_inicial: '2',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
      ],
      leiloes:[
        {
        id: 6,
        telefone: '(31) 99714-1569',
        titulo: 'Carro Semi-Novo',
        foto: 'https://files.nsctotal.com.br/s3fs-public/styles/paragraph_image/public/graphql-upload-files/acidente%20com%20morte%20Timb%C3%B3.jpg?yO_Hw81jNw24DKBiYLxRlBqfyPfQfEZ9&itok=24woTc6T',
        valor_inicial: '20',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        id: 7,
        telefone: '(31) 99714-1569',
        titulo: 'Bicicleta com defeito',
        foto: 'https://vozdabahia.com.br/wp-content/uploads/2019/05/Ciclista-morre-atropelado-696x522.jpeg',
        valor_inicial: '20',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
      ],
      emprestimos:[
        {
        id: 8,
        telefone: '(31) 99714-1569',
        titulo: 'Violão',
        foto: 'http://iniciantesdoviolao.com.br/wp-content/uploads/2014/04/Design-sem-nomebb.png',
        valor_inicial: '20',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
      ],
      doacoes:[
        {
        id: 9,
        telefone: '(31) 99714-1569',
        titulo: 'Doa-se Galinha',
        foto: 'https://i.ytimg.com/vi/2BZSTbip92w/maxresdefault.jpg',
        valor_inicial: 'GRÁTIS',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
      ],

    }),
    created() {
      this.initialize('denise');
    },

    computed:{

    },

    watch: {
      tipo_anuncio(val){
        if(val == 'Leilão'){
          this.disable = false;
          this.label_preco = 'Lance mínimo inicial'
        }
        if(val == 'Venda'){
          this.disable = false;
          this.label_preco = 'Valor do produto'
        }
        if(val == 'Empréstimo'){
          this.disable = false;
          this.label_preco = 'Valor da Diária'
        }
        if(val == 'Doação'){
          this.cadastro.valor_inicial = 0.00;
          this.disable = true;
          this.label_preco = 'Grátis'
        }
      },
      search (val) {

        this.anuncios_filtro = this.anuncios.filter(a => a.titulo.toLowerCase().includes(val))

        this.leiloes_filtro = this.leiloes.filter(a => a.titulo.toLowerCase().includes(val))

        this.emprestimos_filtro = this.emprestimos.filter(a => a.titulo.toLowerCase().includes(val))

        this.doacoes_filtro = this.doacoes.filter(a => a.titulo.toLowerCase().includes(val))
      }
    },

    methods: {
      initialize(tipo){
        this.categoria_atual = 1;
        if(tipo == 'denis'){
        axios
          .get('http://localhost:8000/api/leilao')
          .then(response => {
            this.leiloes = response.data
            this.leiloes_filtro = this.leiloes;
          })
          .catch(error => {
            console.log(error);
          });

        axios
          .get('http://localhost:8000/api/negociacao1')
          .then(response => {
            this.anuncios = response.data
            this.anuncios_filtro = this.anuncios;
          })
          .catch(error => {
            console.log(error);
          });

        axios
          .get('http://localhost:8000/api/negociacao2')
          .then(response => {
            this.emprestimos = response.data
            this.emprestimos_filtro = this.emprestimos;
          })
          .catch(error => {
            console.log(error);
          });

        axios
          .get('http://localhost:8000/api/negociacao3')
          .then(response => {
            this.doacoes = response.data
            this.doacoes_filtro = this.doacoes;
          })
          .catch(error => {
            console.log(error);
          });
        }
        else {
          this.leiloes_filtro = this.leiloes;
          this.doacoes_filtro = this.doacoes;
          this.emprestimos_filtro = this.emprestimos;
          this.anuncios_filtro = this.anuncios;
        }
      },
      cria_anuncio(){
        this.cadastrar_anuncio = true;
      },
      compra(item,tipo){
        if(tipo == 2){ //É LEILÃO
          this.mensagem.dialog = true;
          this.mensagem.input = true;
          this.mensagem.titulo =item.titulo;
          this.lance.vencendo = item.valor_inicial;
          this.lance.do_leilao = item.id;
          this.mensagem.message = 'Lance vencendo: R$' + item.valor_inicial ;
        }
        else{

        item.id_usuario = 1;
        item.do_negoc = item.id;
        item.preco_fim = item.valor_inicial;
/*
        axios
          .post(sessionStorage.getItem('url') + '/api/??????????', item)
          .then(response => { */

            this.mensagem.dialog = true;
            this.mensagem.input = false;
            this.mensagem.titulo ='Operação bem sucedida';
            if(tipo == 1){
              this.mensagem.message = 'Parabéns! Você acaba de comprar "' + item.titulo + '", entre em contato com o vendedor para finalizar sua transação.';
            }

            if(tipo == 3){
              this.mensagem.message = 'Parabéns! Você acaba de alugar "' + item.titulo + '", entre em contato com o vendedor para finalizar sua transação.';
            }
            if(tipo == 4){
              this.mensagem.message = 'Parabéns! Você acaba de aceitar "' + item.titulo + '", entre em contato com o vendedor para finalizar sua transação.';
            }
/*
          })
          .catch(error => {
            console.log(error);
          });
        */
        }
      },
      seleciona(item,tipo){
        if(tipo == 1){
          this.comprar = 'Comprar';
          this.tipo_selecionado = 1;
        }
        if(tipo == 2){
          this.comprar = 'Dar lance';
          this.tipo_selecionado = 2;
        }
        if(tipo == 3){
          this.comprar = 'Alugar';
          this.tipo_selecionado = 3;
        }
        if(tipo == 4){
          this.comprar =  'Aceitar';
          this.tipo_selecionado = 4;
        }
        this.dialog = true;
        this.item_selecionado = item;
        console.log(this.item_selecionado)
      },
      muda_categoria(tipo) {
        this.categoria_atual = tipo;
      },
      dar_lance(){
        this.mensagem.dialog = false
        this.lance.lance = this.mensagem.lance;
        this.lance.id_usuario = 1
        console.log(this.lance)

        if(this.lance.lance > this.lance.vencendo){
          axios
<<<<<<< HEAD
            .post('http://localhost:8000/api/lance', this.lance)
=======
            .post('http://localhost:8000/api/leilao', this.lance)
>>>>>>> 77a137ec7d97b4ecb0b6913b85f41684508d4836
            .then(response => {
              console.log(response)
            })
            .catch(error => {
              console.log(error);
            });
        }
      },
      cadastraAnuncio(){

        if(this.tipo_anuncio == 'Leilão'){

          this.cadastro.categoria = 'Livraria'
          this.cadastro.id_usuario = 1

          axios
          .post('http://localhost:8000/api/leilao', this.cadastro)
          .then(response => {
            console.log(response)
          })
          .catch(error => {
            console.log(error);
          });

        }

        else{
          this.cadastro.tempo_devolucao = 0
          if(this.tipo_anuncio == 'Venda') this.cadastro.tipo = 1
          if(this.tipo_anuncio == 'Doação') this.cadastro.tipo = 3
          if(this.tipo_anuncio == 'Empréstimo'){
            this.cadastro.tipo = 2;
            this.cadastro.tempo_devolucao = 15;
          }
          this.cadastro.titulo_ca = 'Lazer'
          this.cadastro.id_usuario = 1

          axios
          .post('http://localhost:8000/api/negociacao', this.cadastro)
          .then(response => {
            console.log(response)
          })
          .catch(error => {
            console.log(error);
          });

        }

      }
    }
  }

</script>
