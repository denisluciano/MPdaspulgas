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
            <v-card width="355px" class="ma-2" v-if="anuncio.disponivel_negoc == 1">
              <v-img
                v-if="anuncio.foto_negoc != null"
                class="white--text"
                height="200px"
                :src="anuncio.foto_negoc"
              ></v-img><v-img
                v-else
                class="white--text"
                height="200px"
                src="https://i.imgur.com/TOEbilE.png"
              ></v-img><v-divider></v-divider>
              <v-divider></v-divider>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo_negoc}}</span> -
                  <span>R$ {{anuncio.valor_negoc}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="red" @click="finaliza(anuncio,1)">Finalizar</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio,1)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>

          <v-flex v-for="anuncio in leiloes_filtro" :key="anuncio.id_leilao">
            <v-card width="355px" class="ma-2" v-if="anuncio.disponivel_leilao == 1">
              <v-img
                v-if="anuncio.foto_leilao != null"
                class="white--text"
                height="200px"
                :src="anuncio.foto_leilao"
              ></v-img><v-img
                v-else
                class="white--text"
                height="200px"
                src="https://i.imgur.com/TOEbilE.png"
              ></v-img><v-divider></v-divider>
              <v-card-title>
                <div>
                    <span>{{anuncio.titulo_leilao}}</span>
                  <span v-if="anuncio.valor_maior_lance > 0">R$ {{anuncio.valor_maior_lance}} maior lance de {{anuncio.nome_u_maior_lance}} em {{formatDate(anuncio.data_fim_leilao)}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
                <v-btn flat color="red" @click="finaliza(anuncio,2)">Encerrar Leilão</v-btn>
                <v-btn flat color="orange" @click="seleciona(anuncio,2)">Ver mais</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
        <v-layout align-center justify-space-between row wrap>
          <v-flex xs12 md6>
          <h3 class="headline mb-0 ma-4">Seus Anúncios encerrados</h3>
          </v-flex>
        </v-layout>
        <v-layout align-center justify-space-between row wrap v-for="anuncio in anuncios_filtro" :key="anuncio.id">
          <v-flex  v-if="anuncio.disponivel_negoc == 0">
            <v-card width="355px" class="ma-2">
              <v-img
                v-if="anuncio.foto_negoc != null"
                class="white--text"
                height="200px"
                :src="anuncio.foto_negoc"
              ></v-img><v-img
                v-else
                class="white--text"
                height="200px"
                src="https://i.imgur.com/TOEbilE.png"
              ></v-img><v-divider></v-divider>
              <v-divider></v-divider>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo_negoc}}</span> -
                  <span>R$ {{anuncio.valor_negoc}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
              </v-card-actions>
            </v-card>
          </v-flex>

          <v-flex v-for="anuncio in leiloes_filtro" :key="anuncio.id">
            <v-card width="355px" class="ma-2" v-if="anuncio.disponivel_leilao == 0">
              <v-img
                v-if="anuncio.foto_leilao != null"
                class="white--text"
                height="200px"
                :src="anuncio.foto_leilao"
              ></v-img><v-img
                v-else
                class="white--text"
                height="200px"
                src="https://i.imgur.com/TOEbilE.png"
              ></v-img><v-divider></v-divider>
              <v-card-title>
                <div>
                  <span>{{anuncio.titulo_leilao}}</span>
                  <span v-if="anuncio.valor_maior_lance > 0">R$ {{anuncio.valor_maior_lance}} maior lance de {{anuncio.nome_u_maior_lance}} em {{formatDate(anuncio.data_fim_leilao)}}</span>
                </div>
              </v-card-title>
              <v-card-actions>
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
      tipos: ['Todos','Venda', 'Leilão', 'Empréstimo', 'Doação'],
      categoria: ['Todos','Automoveis','Eletrodomesticos','Eletronicos','Livraria','Pecuaria','Serviços','Outros'],
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
      busca_tipo: 'Todos',
      categoria_atual:[],
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


    }),
    created() {
      this.initialize('denis');
    },

    computed:{
      getId(){
        return sessionStorage.getItem('id');
      }
    },

      watch: {
      busca_search (val) {
        this.anuncios_filtro = this.anuncios.filter(a => a.titulo.toLowerCase().includes(val))
        this.leiloes_filtro = this.leiloes.filter(a => a.titulo_leilao.toLowerCase().includes(val))

      },
      busca_tipo (val) {
        if(this.busca_tipo != 'Todos'){
            if(this.busca_tipo == 'Venda'){
                this.anuncios_filtro = this.anuncios.filter(a => a.tipo_negoc.includes(1))
            }
            else if(this.busca_tipo == 'Empréstimo'){
                this.anuncios_filtro = this.anuncios.filter(a => a.tipo_negoc.includes(2))
            }
            else if(this.busca_tipo == 'Doação'){
                this.anuncios_filtro = this.anuncios.filter(a => a.tipo_negoc.includes(3))
            }
            else {
                this.anuncios_filtro = this.leiloes_filtro;
            }
        }
        else{
          this.anuncios_filtro = this.anuncios
          this.leiloes_filtro = this.leiloes
        }
      }
    },

    methods: {
        formatDate(data){
          return data[8] + data[9] + '/' + data[5] + data[6] + '/' + data[0] + data[1] + data[2] + data[3];
      },
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
        this.item_selecionado = item;
        this.comprar = 'Finalizar Anúncio'
        if(tipo == 1){
           this.tipo_selecionado = 1;
        }
        if(tipo == 2){
          this.item_selecionado.id = item.id_leilao
          this.item_selecionado.titulo = item.titulo_leilao
          this.item_selecionado.foto = item.foto_leilao
          this.item_selecionado.valor_inicial = item.valor_maior_lance
          this.item_selecionado.descricao = item.descricao_leilao
          this.comprar = 'Encerrara Leilão'
          this.tipo_selecionado = 2;
        }
        else{
          this.item_selecionado.id = item.id_negoc
          this.item_selecionado.titulo = item.titulo_negoc
          this.item_selecionado.foto = item.foto_negoc
          this.item_selecionado.valor_inicial = item.valor_negoc
          this.item_selecionado.descricao = item.descricao_negoc
        }
        if(tipo == 3){
          this.tipo_selecionado = 3;
        }
        if(tipo == 4){
            this.tipo_selecionado = 4;
        }
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
          console.log(item)

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
