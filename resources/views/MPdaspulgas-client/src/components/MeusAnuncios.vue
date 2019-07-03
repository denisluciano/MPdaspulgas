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
            :items="tipos"
            label="Tipo"
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
                <v-btn flat color="red" @click="finaliza(anuncio,1)">Finalizar</v-btn>
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
                <v-btn flat color="red" @click="finaliza(anuncio,2)">Encerrar Leilão</v-btn>
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
                <v-btn flat color="red" @click="finaliza(anuncio,3)">Finalizar</v-btn>
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
                <v-btn flat color="red" @click="finaliza(anuncio,4)">Finalizar</v-btn>
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
        titulo: 'Ciclista com defeito',
        foto: 'data:image/jpeg;base64,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',
        valor_inicial: '20',
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
          .get('http://localhost:8000/api/leilaousuario/'+ this.getId)
          .then(response => {
            if(response.data != 'error'){
                this.leiloes = response.data
            this.leiloes_filtro = this.leiloes;
            this.ordena(this.leiloes_filtro)
            }
          })
          .catch(error => {
            console.log(error);
          });

        axios
          .get('http://localhost:8000/api/negociacaousuario/'+ this.getId)
          .then(response => {
              if(response.data != 'error'){
            this.anuncios = response.data
            this.anuncios_filtro = this.anuncios;
            this.ordena(this.anuncios_filtro)}
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
      ordena(items) {
        /*
        items.sort(function (a, b) {
          if (a.saldo > b.saldo) {
            return -1;
          }
          if (a.saldo < b.saldo) {
            return 1;
          }
          // a must be equal to b
          return 0;
        })
        */
      },
      finaliza(item,x){
        this.msg.loading = true;
        if(x == 2){
          item.id_usuario = this.getId;
          item.id_leilao = item.id;
          axios
            .post('http://localhost:8000/api/encerrarleilao',item)
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
            .post('http://localhost:8000/api/finalizarcompra',item)
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
