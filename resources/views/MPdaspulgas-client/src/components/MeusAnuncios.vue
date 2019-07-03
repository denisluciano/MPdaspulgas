<template>
  <v-container align-center>
    <v-container fluid>
    <v-layout align-center justify-space-between row wrap>
        <v-flex xs12 md6>
        <h3 class="headline mb-0">Seus Anúncios</h3>
        </v-flex>
        <v-flex xs2>
            <v-select
            class='mt-4'
            v-model="busca_tipo"
            :items="categoria"
            label="Categoria"
            ></v-select>
        </v-flex>
        <v-flex xs3>
            <v-text-field
            color="#ea3b2e"
            v-model="busca_search"
            append-icon="search"
            label="Palavras chave"
            single-line
            hide-details
            ></v-text-field>
        </v-flex>

      </v-layout>
    </v-container>
        <v-layout align-center justify-space-between row wrap>
          <v-flex v-for="anuncio in anuncios_filtro" :key="anuncio.id">
            <v-card width="355px" class="ma-2">
              <v-img
                v-if="anuncio.foto != null"
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              ></v-img><v-img
                v-else
                class="white--text"
                height="200px"
                src="https://i.imgur.com/TOEbilE.png"
              ></v-img><v-divider></v-divider>
              <v-divider></v-divider>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> -
                  <span>R$ {{anuncio.valor_inicial}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="red" @click="finaliza(anuncio,1)" :loading="msg.loading">Finalizar</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio,1)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
            <v-flex v-for="anuncio in leiloes_filtro" :key="anuncio.id">
            <v-card width="355px" class="ma-2">
              <v-img
                v-if="anuncio.foto != null"
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              ></v-img><v-img
                v-else
                class="white--text"
                height="200px"
                src="https://i.imgur.com/TOEbilE.png"
              ></v-img><v-divider></v-divider>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> -
                  <span>R$ {{anuncio.valor_lance_v}} maior lance de {{anuncio.nome_us_lance_v}} em {{anuncio.data_lance_v}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="red" @click="finaliza(anuncio,2)" :loading="msg.loading">Encerrar Leilão</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio,2)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
            <v-flex v-for="anuncio in emprestimos_filtro" :key="anuncio.id">
            <v-card width="355px" class="ma-2">
              <v-img
                v-if="anuncio.foto != null"
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              ></v-img><v-img
                v-else
                class="white--text"
                height="200px"
                src="https://i.imgur.com/TOEbilE.png"
              ></v-img><v-divider></v-divider>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> -
                  <span>R$ {{anuncio.valor_inicial}}/Dia</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="red" @click="finaliza(anuncio,3)" :loading="msg.loading">Finalizar</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio,3)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>

          </v-flex>
      
            <v-flex v-for="anuncio in doacoes_filtro" :key="anuncio.id">
            <v-card width="355px" class="ma-2">
              <v-img
                v-if="anuncio.foto != null"
                class="white--text"
                height="200px"
                :src="anuncio.foto"
              ></v-img><v-img
                v-else
                class="white--text"
                height="200px"
                src="https://i.imgur.com/TOEbilE.png"
              ></v-img><v-divider></v-divider>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo}}</span> -
                  <span>Grátis</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="red" @click="finaliza(anuncio,4)" :loading="msg.loading">Finalizar</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio,4)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>

    <v-dialog v-model="dialog" max-width="650px" v-if="item_selecionado">
      <v-card>
        <v-toolbar dark>
          <v-toolbar-title>{{item_selecionado.titulo}}</v-toolbar-title>
        </v-toolbar>
        <v-img
          v-if="item_selecionado.foto != null"
          class="white--text"
          height="355px"
          :src="item_selecionado.foto"
        ></v-img><v-img
          v-else
          class="white--text"
          height="355px"
          src="https://i.imgur.com/TOEbilE.png"
        ></v-img><v-divider></v-divider>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout row wrap>
              <v-flex xs6>
                <v-text-field background-color='white' v-if="item_selecionado.valor_inicial>0" readonly outline hide-details required="" v-model="item_selecionado.valor_inicial" label="Valor do Anúncio"></v-text-field>
                <v-text-field background-color='white' v-else readonly outline hide-details required="" v-model="gratis" label="Valor do Anúncio"></v-text-field>
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
            <v-btn color="red darken-1" flat @click="finaliza(item_selecionado,tipo_selecionado)" :loading="msg.loading">{{comprar}}</v-btn>
          <v-spacer></v-spacer>
        </v-card-actions>
        </v-card-text>
      </v-card>
    </v-dialog>
  
    <v-dialog
        v-model="msg.dialog"
        max-width="400"
      >
      <v-card>
        <v-card-title v-if="msg.error == false" class="headline green--text">{{msg.titulo}}</v-card-title>
        <v-card-title v-if="msg.error == true" class="headline red--text">{{msg.titulo}}</v-card-title>
        <v-card-text>{{msg.message}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="green darken-1"
            flat="flat"
            @click="initialize('denis')"
          > Ok
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </v-container>
</template>
<script>
  const axios = require('axios');
  export default {
    data: vm => ({
      msg:{
        loading: false,
        error: null,
        dialog: false,
        message: '',
        titulo: '',
      },
      lance:{
        vencendo: 20,
        id_leilao: null,
        id_usuario: sessionStorage.getItem('id'),
        valor: null
      },
      comprar: null,
      tipo_selecionado: null,
      cadastrar_anuncio: false,
      label_preco: 'Preço do Anúncio',
      tipo_anuncio: null,
      categoria_anuncio: null,
      disable: false,
      tipos: ['Venda', 'Leilão', 'Empréstimo', 'Doação'],
      categoria: ['Todas','Automoveis','Eletrodomesticos','Eletronicos','Livraria','Pecuaria','Serviços','Outros'],
      cadastro:{
        loading: false,
        tipo: null,
        titulo: null,
        foto: null,
        valor_inicial: null,
        descricao: null,
      },
      tabs: null,
      gratis: 'Grátis',
      dialog: false,
      item_selecionado: null,
      busca_search: '',
      busca_tipo: 'Todas',
      categoria_atual:[],
      tipos: ['Todos','1','2','3'],
      anuncios_filtro:[],
      emprestimos_filtro:[],
      doacoes_filtro:[],
      leiloes_filtro:[],
      anuncios:[
        {
        id: 1,
        titulo_categoria: 'Pecuaria',
        telefone: '(31) 99714-1569',
        titulo: 'Praia Linda',
        foto: 'https://cdn.vuetifyjs.com/images/cards/docks.jpg',
        valor_inicial: '4000',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        id: 2,
        titulo_categoria: 'Pecuaria',
        telefone: '(31) 99714-1569',
        titulo: 'Cavalo 5 anos',
        foto: 'http://www.porforadaspistas.com.br/wp-content/uploads/2016/11/frankel-e-um-cavalo-de-corrida_976399.jpg',
        valor_inicial: '200',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        id: 3,
        titulo_categoria: 'Pecuaria',
        telefone: '(31) 99714-1569',
        titulo: 'Carro novíssimo',
        valor_inicial: '40000',
        foto: 'https://www.luxurysociety.com/media/uploads/thumbnails/filer_public_thumbnails/cc/04/cc04f3d6-9769-4e90-85fc-b730c8c6f561/bugatti.png__1024x450_q85_crop_subsampling-2_upscale.png',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        id: 4,
        titulo_categoria: 'Pecuaria',
        telefone: '(31) 99714-1569',
        titulo: 'Porco de granja',
        valor_inicial: '500',
        foto: 'https://www.mundoecologia.com.br/wp-content/uploads/2019/04/Porco-3.jpg',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        id: 5,
        titulo_categoria: 'Outros',
        telefone: '(31) 99714-1569',
        titulo: 'Acompanhante de Luxo',
        foto: 'https://i.imgur.com/OpGRMhN.png',
        valor_inicial: '9800',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
      ],
      leiloes:[
        {
        id: 6,
        titulo_categoria: 'Eletrodomesticos',
        telefone: '(31) 99714-1569',
        titulo: 'Carro Semi-Novo',
        foto: 'https://files.nsctotal.com.br/s3fs-public/styles/paragraph_image/public/graphql-upload-files/acidente%20com%20morte%20Timb%C3%B3.jpg?yO_Hw81jNw24DKBiYLxRlBqfyPfQfEZ9&itok=24woTc6T',
        valor_inicial: '20',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
        {
        id: 7,
        titulo_categoria: 'Eletronicos',
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
        titulo_categoria: 'Pecuaria',
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
        titulo_categoria: 'Pecuaria',
        telefone: '(31) 99714-1569',
        titulo: 'Doa-se Galinha',
        foto: 'https://i.ytimg.com/vi/2BZSTbip92w/maxresdefault.jpg',
        valor_inicial: 'GRÁTIS',
        descricao: 'Excelente para a família, recomendável também para adultos cansados de suas vidas pacatas'
        },
      ],

    }),
    created() {
      this.initialize('deniss');
    },

    computed:{
      getId(){
        return sessionStorage.getItem('id');
      }
    },

      watch: {
      busca_search (val) {
        this.anuncios_filtro = this.anuncios.filter(a => a.titulo.toLowerCase().includes(val))
        this.leiloes_filtro = this.leiloes.filter(a => a.titulo.toLowerCase().includes(val))

      },
      busca_tipo (val) {
        if(this.busca_tipo != 'Todas'){
          this.anuncios_filtro = this.anuncios.filter(a => a.tipo_negoc.includes(val))
          this.leiloes_filtro = this.leiloes.filter(a => a.tipo_negoc.includes(val))
        }
        else{
          this.anuncios_filtro = this.anuncios
          this.leiloes_filtro = this.leiloes
        }
      }
    },

    methods: {
      initialize(tipo){
        this.msg.dialog = false;
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
          .get('http://localhost:8000/api/negociacaousuario/'+ this.getId)
          .then(response => {
            this.anuncios = response.data
            this.anuncios_filtro = this.anuncios;
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
      seleciona(item,tipo){
        this.comprar = 'Finalizar Anúncio'
        if(tipo == 1){
           this.tipo_selecionado = 1;
        }
        if(tipo == 2){
          this.comprar = 'Encerrara Leilão'
          this.tipo_selecionado = 2;
        }
        if(tipo == 3){
          this.tipo_selecionado = 3;
        }
        if(tipo == 4){
            this.tipo_selecionado = 4;
        }
        this.item_selecionado = item;
        this.dialog = true;
        
      },
      muda_categoria(tipo) {
        this.categoria_atual = tipo;
      },
      finaliza(item,x){
        this.msg.loading = true;
        if(x == 2){
          item.id_usuario = this.getId;
          item.id_leilao = item.id;
          axios
            .post('http://localhost:8000/api/finaliza/'+ this.item)
            .then(response => {
              this.msg.loading = false;
              this.msg.dialog = true;
              this.msg.error = false;
              this.msg.titulo ='Leilão Encerrado';
              this.msg.message = 'Entre em contato com o vencedor do leilão';
            })
            .catch(error => {
              this.msg.loading = false;
              this.msg.dialog = true;
              this.msg.error = true;
              this.msg.titulo ='ERRO!';
              this.msg.message = error;
              console.log(error);
            });
        }
        else{
          item.id_usuario = this.getId;
          axios
            .post('http://localhost:8000/api/finaliza/'+ this.item)
            .then(response => {
              this.msg.loading = false;
              this.msg.dialog = true;
              this.msg.error = false;
              this.msg.titulo ='Anúncio Finalizado';
              this.msg.message = 'Este anúncio não aparecerá mais como disponível para os usuários';
            })
            .catch(error => {
              this.msg.loading = false;
              this.msg.dialog = true;
              this.msg.error = true;
              this.msg.titulo ='ERRO!';
              this.msg.message = error;
              console.log(error);
            });
        }
     }
    }
  }

</script>
