<template>
  <v-container align-center>
    <v-container fluid>
        <v-layout align-center justify-space-between row wrap>
          <v-flex xs12 md6>
            <h3 class="headline mb-0">Anúncios ativos no momento</h3>
          </v-flex>
          
          <v-flex xs12 md6>
              <v-text-field
                color="#00a65a"
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
          <v-tabs-slider color="#de5d3c"></v-tabs-slider>
            <v-tab href="#mobile-tabs-5-1" class="red--text" @click="muda_categoria(1)">
              Anúncios
            </v-tab>
            <v-tab href="#mobile-tabs-5-2" class="red--text" @click="muda_categoria(2)">
              Leilões
            </v-tab>
            <v-tab href="#mobile-tabs-5-3" class="red--text" @click="muda_categoria(3)">
              Empréstimos
            </v-tab>
            <v-tab href="#mobile-tabs-5-4" class="red--text" @click="muda_categoria(4)">
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
          <v-flex v-for="anuncio in anuncios_filtro" :key="anuncio.titulo">
            <v-card width="400px" class="ma-2">
              <v-img
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              >
              </v-img>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> - 
                  <span>{{anuncio.preço}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="green">Comprar</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>
            
          </v-flex>
        </v-layout>
        <v-layout v-if="i == 2" row wrap>
          <v-flex v-for="anuncio in leiloes_filtro" :key="anuncio.titulo">
            <v-card width="400px" class="ma-2">
              <v-img
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              >
                
              </v-img>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> - 
                  <span>{{anuncio.preço}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="green">Comprar</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>
            
          </v-flex>
        </v-layout>
        <v-layout v-if="i == 3" row wrap>
          <v-flex v-for="anuncio in emprestimos_filtro" :key="anuncio.titulo">
            <v-card width="400px" class="ma-2">
              <v-img
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              >
                
              </v-img>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> - 
                  <span>{{anuncio.preço}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="green">Comprar</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>
            
          </v-flex>
        </v-layout>
        <v-layout v-if="i == 4" row wrap>
          <v-flex v-for="anuncio in doacoes_filtro" :key="anuncio.titulo">
            <v-card width="400px" class="ma-2">
              <v-img
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              >
                
              </v-img>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> - 
                  <span>{{anuncio.preço}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="green">Comprar</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio)">Ver mais</v-btn>
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
                height="400px"
                :src="item_selecionado.foto"
              >
              </v-img>
        <v-card-text>
          
          <v-container grid-list-md>
            <v-layout row wrap>
              <v-flex xs6>
                <v-text-field background-color='white' readonly outline hide-details required="" v-model="item_selecionado.preço" label="Preço do Anúncio"></v-text-field>
              </v-flex>
              <v-flex xs6>
                <v-text-field background-color='white' readonly outline hide-details required="" v-model="item_selecionado.telefone" label="Telefone para Contato"></v-text-field>
              </v-flex>
              <v-flex xs12>
                <v-textarea auto-grow background-color='white' readonly outline hide-details required="" v-model="item_selecionado.descricao" label="Descrição do Anúncio"></v-textarea auto-grow>
              </v-flex>
            </v-layout>
          </v-container>
          <v-card-actions>
            <v-btn color="green darken-1" flat @click="dialog = false">Comprar</v-btn>
            <v-btn color="red darken-1" flat @click="dialog = false">Denunciar</v-btn>
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
        telefone: '(31) 99714-1569',
        titulo: 'Praia Linda',
        foto: 'https://cdn.vuetifyjs.com/images/cards/docks.jpg',
        preço: 'R$4000',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        telefone: '(31) 99714-1569',
        titulo: 'Cavalo 5 anos',
        foto: 'http://www.porforadaspistas.com.br/wp-content/uploads/2016/11/frankel-e-um-cavalo-de-corrida_976399.jpg',
        preço: 'R$200',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        telefone: '(31) 99714-1569',
        titulo: 'Carro novíssimo',
        preço: 'R$40000',
        foto: 'https://www.luxurysociety.com/media/uploads/thumbnails/filer_public_thumbnails/cc/04/cc04f3d6-9769-4e90-85fc-b730c8c6f561/bugatti.png__1024x450_q85_crop_subsampling-2_upscale.png',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        telefone: '(31) 99714-1569',
        titulo: 'Porco de granja',
        preço: 'R$500',
        foto: 'https://www.mundoecologia.com.br/wp-content/uploads/2019/04/Porco-3.jpg',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        telefone: '(31) 99714-1569',
        titulo: 'Lixeira infantil',
        foto: 'https://www.casadaeducacao.com.br/octopus/design/images/34/products/o/lixeiracoletaseletivafresooo.jpg',
        preço: 'R$2',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
      ],
      leiloes:[
        {
        telefone: '(31) 99714-1569',
        titulo: 'Carro Semi-Novo',
        foto: 'https://files.nsctotal.com.br/s3fs-public/styles/paragraph_image/public/graphql-upload-files/acidente%20com%20morte%20Timb%C3%B3.jpg?yO_Hw81jNw24DKBiYLxRlBqfyPfQfEZ9&itok=24woTc6T',
        preço: 'R$20 Lance Inicial',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        telefone: '(31) 99714-1569',
        titulo: 'Bicicleta com defeito',
        foto: 'https://vozdabahia.com.br/wp-content/uploads/2019/05/Ciclista-morre-atropelado-696x522.jpeg',
        preço: 'R$20 Lance Inicial',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
      ],
      emprestimos:[
        {
        telefone: '(31) 99714-1569',
        titulo: 'Violão',
        foto: 'http://iniciantesdoviolao.com.br/wp-content/uploads/2014/04/Design-sem-nomebb.png',
        preço: 'R$20/Dia',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
      ],
      doacoes:[
        {
        telefone: '(31) 99714-1569',
        titulo: 'Doa-se Galinha',
        foto: 'https://i.ytimg.com/vi/2BZSTbip92w/maxresdefault.jpg',
        preço: 'GRÁTIS',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
      ],
      
    }),
    created() {
      this.categoria_atual = 1;
       this.anuncios_filtro = this.anuncios;
      
        this.leiloes_filtro = this.leiloes;
      
        this.emprestimos_filtro = this.emprestimos;
      
        this.doacoes_filtro = this.doacoes;
    },

    computed:{

    },

    watch: {
      search (val) {

        this.anuncios_filtro = this.anuncios.filter(a => a.titulo.toLowerCase().includes(val))
      
        this.leiloes_filtro = this.leiloes.filter(a => a.titulo.toLowerCase().includes(val))
      
        this.emprestimos_filtro = this.emprestimos.filter(a => a.titulo.toLowerCase().includes(val))
      
        this.doacoes_filtro = this.doacoes.filter(a => a.titulo.toLowerCase().includes(val))
      }
    },

    methods: {
      seleciona(item){
        this.dialog = true;
        this.item_selecionado = item;
        console.log(this.item_selecionado)
      },
      muda_categoria(tipo) {
        this.categoria_atual = tipo;
      },
    }
  }

</script>