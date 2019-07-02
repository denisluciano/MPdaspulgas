<template>
  <v-container align-center>
    <v-container fluid>
    <v-layout align-center justify-space-between row wrap>
        <v-flex xs12 md6>
        <h3 class="headline mb-0">Histórico de Negociações</h3>
        </v-flex>
        <v-flex xs2>
            <v-select
            class='mt-4'
            v-model="busca_categoria"
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
          <v-flex v-for="anuncio in anuncios_filtro" :key="anuncio.id" xs12>
            <v-card class="ma-2">
              <v-divider></v-divider>
              <v-layout row wrap>
                <v-flex xs3 pa-2>
                    <v-img
                        v-if="anuncio.foto != null"
                        class="white--text"
                        height="100px"
                        width="200px"
                        :src="anuncio.foto"
                      ></v-img><v-img
                        v-else
                        class="white--text"
                        height="100px"
                        width="200px"
                        src="https://i.imgur.com/TOEbilE.png"
                      ></v-img>
                </v-flex>
                  <v-flex xs8>
                    <h2>{{anuncio.titulo_negoc}} - R$ {{anuncio.preco_fim}} - {{anuncio.descricao_negoc}} - {{anuncio.tipo_negoc}} - {{anuncio.data_negoc}}  </h2>
                </v-flex>

              </v-layout>
            </v-card>
          </v-flex>
          <v-flex v-for="anuncio in emprestimos_filtro" :key="anuncio.id" xs12>
            <v-card class="ma-2">
              <v-divider></v-divider>
              <v-layout row wrap>
                <v-flex xs2 pa-2>
                    <v-img
                        v-if="anuncio.foto != null"
                        class="white--text"
                        height="100px"
                        width="200px"
                        :src="anuncio.foto"
                      ></v-img><v-img
                        v-else
                        class="white--text"
                        height="100px"
                        width="200px"
                        src="https://i.imgur.com/TOEbilE.png"
                      ></v-img>
                </v-flex>
                  <v-flex xs8>
                    <h2>{{anuncio.titulo_negoc}} - R$ {{anuncio.preco_fim}} - {{anuncio.descricao_negoc}} - {{anuncio.tipo_negoc}} - {{anuncio.data_negoc}}  </h2>
                </v-flex>

              </v-layout>
            </v-card>
          </v-flex>
          <v-flex v-for="anuncio in doacoes_filtro" :key="anuncio.id" xs12>
            <v-card class="ma-2">
              <v-divider></v-divider>
              <v-layout row wrap>
                <v-flex xs2 pa-2>
                    <v-img
                        v-if="anuncio.foto != null"
                        class="white--text"
                        height="100px"
                        width="200px"
                        :src="anuncio.foto"
                      ></v-img><v-img
                        v-else
                        class="white--text"
                        height="100px"
                        width="200px"
                        src="https://i.imgur.com/TOEbilE.png"
                      ></v-img>
                </v-flex>
                  <v-flex xs8>
                    <h2>{{anuncio.titulo_negoc}} - R$ {{anuncio.preco_fim}} - {{anuncio.descricao_negoc}} - {{anuncio.tipo_negoc}} - {{anuncio.data_negoc}}  </h2>
                </v-flex>

              </v-layout>
            </v-card>
          </v-flex>
          <v-flex v-for="anuncio in leiloes_filtro" :key="anuncio.id" xs12>
            <v-card class="ma-2">
              <v-divider></v-divider>
              <v-layout row wrap>
                <v-flex xs3 pa-2>
                    <v-img
                        v-if="anuncio.foto != null"
                        class="white--text"
                        height="100px"
                        width="200px"
                        :src="anuncio.foto"
                      ></v-img><v-img
                        v-else
                        class="white--text"
                        height="100px"
                        width="200px"
                        src="https://i.imgur.com/TOEbilE.png"
                      ></v-img>
                </v-flex>
                  <v-flex xs7>
                    <h2>{{anuncio.titulo_negoc}} - R$ {{anuncio.preco_fim}} - {{anuncio.descricao_negoc}} - {{anuncio.tipo_negoc}} - {{anuncio.data_negoc}}  </h2>
                </v-flex>

              </v-layout>
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
                <v-text-field background-color='white' v-elsereadonly outline hide-details required="" v-model="gratis" label="Valor do Anúncio"></v-text-field>
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
      mensagem:{
        loading: false,
        dialog: false,
        message: '',
        titulo: '',
        input: false,
        lance: null
      },
      msg:{
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
      busca_categoria: 'Todas',
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
      this.initialize('denis');
    },

    computed:{
      getId(){
        return sessionStorage.getItem('id');
      }
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
      busca_search (val) {
        this.anuncios_filtro = this.anuncios.filter(a => a.titulo.toLowerCase().includes(val))

        this.leiloes_filtro = this.leiloes.filter(a => a.titulo.toLowerCase().includes(val))

        this.emprestimos_filtro = this.emprestimos.filter(a => a.titulo.toLowerCase().includes(val))

        this.doacoes_filtro = this.doacoes.filter(a => a.titulo.toLowerCase().includes(val))
      },
      busca_categoria (val) {
        if(this.busca_categoria != 'Todas'){
          this.anuncios_filtro = this.anuncios.filter(a => a.titulo_categoria.includes(val))
          this.leiloes_filtro = this.leiloes.filter(a => a.titulo_categoria.includes(val))
          this.emprestimos_filtro = this.emprestimos.filter(a => a.titulo_categoria.includes(val))
          this.doacoes_filtro = this.doacoes.filter(a => a.titulo_categoria.includes(val))
        }
        else{
          this.anuncios_filtro = this.anuncios
          this.leiloes_filtro = this.leiloes
          this.emprestimos_filtro = this.emprestimos
          this.doacoes_filtro = this.doacoes
        }
      }
    },

    methods: {
      initialize(tipo){
        this.msg.dialog = false;
        this.mensagem.dialog = false;
        this.categoria_atual = 1; 
        console.log(this.getId)
        if(tipo == 'denis'){
        axios
          .get('http://localhost:8000/api/compralusuario/'+ this.getId)
          .then(response => {
            this.leiloes = response.data
            this.leiloes_filtro = this.leiloes;
          })
          .catch(error => {
            console.log(error);
          });

        axios
          .get('http://localhost:8000/api/compranusuario/'+ this.getId)
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
      compra(item,tipo){
        console.log(item.id)
        if(tipo == 2){ //É LEILÃO
          this.mensagem.dialog = true;
          this.mensagem.input = true;
          this.mensagem.titulo =item.titulo;
          this.lance.vencendo = item.valor_lance_v;
          this.lance.id_leilao = item.id;
          this.mensagem.message = 'Lance vencendo: R$' + item.valor_lance_v + ' de '+ item.nome_us_lance_v + ' em ' + item.data_lance_v;
        }
        else{

        item.id_usuario =  sessionStorage.getItem('id');
        item.do_negoc = item.id;
        item.preco_fim = item.valor_lance_v;

        axios
          .post(sessionStorage.getItem('url') + '/api/compran', item)
          .then(response => {
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
          })
          .catch(error => {
            console.log(error);
          });
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
          this.item_selecionado.valor_inicial = item.valor_lance_v;
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
        this.mensagem.loading = true;
        this.lance.valor = this.mensagem.lance;
        this.lance.id_usuario =  sessionStorage.getItem('id')

        if(this.mensagem.lance > this.lance.vencendo){
          axios
            .post('http://localhost:8000/api/lance', this.lance)
            .then(response => {
              this.mensagem.loading = false;
              this.mensagem.dialog = false
              this.msg.dialog = true;
              this.msg.error = false;
              this.msg.titulo ='Lance registrado!';
              this.msg.message = 'Seu lance de R$' + this.lance.valor + ' agora está vencendo este leilão!';

            })
            .catch(error => {
              this.mensagem.loading = false;
              this.mensagem.dialog = false
              this.msg.dialog = true;
              this.msg.error = true;
              this.msg.titulo ='ERROR';
              this.msg.message = error;
            });
        }
        else{
          this.mensagem.loading = false;
          this.mensagem.dialog = false
          this.msg.dialog = true;
          this.msg.error = true;
          this.msg.titulo ='Lance inválido';
          this.msg.message = 'Seu lance deve ser superior ao lance vencedor de R$' + this.lance.vencendo;
        }
      },
      cadastraAnuncio(){
        this.cadastro.loading = true;
        if(this.tipo_anuncio == 'Leilão'){

          this.cadastro.titulo_ca = this.categoria_anuncio
          this.cadastro.id_usuario =  sessionStorage.getItem('id')

          axios
          .post('http://localhost:8000/api/leilao', this.cadastro)
          .then(response => {
            this.cadastro.loading = false;
            this.msg.dialog = true;
            this.msg.error = false;
            this.msg.titulo ='Anúncio registrado!';
            this.msg.message = 'Seu anúncio "' + this.cadastro.tipo + '" foi cadastrado com Sucesso!';

          })
          .catch(error => {
            console.log(error);
            this.cadastro.loading = false;
            this.msg.dialog = true;
            this.msg.error = true;
            this.msg.titulo ='ERROR';
            this.msg.message = error;

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
           this.cadastro.titulo_ca = this.categoria_anuncio
          this.cadastro.id_usuario =  sessionStorage.getItem('id')

          axios
          .post('http://localhost:8000/api/negociacao', this.cadastro)
          .then(response => {
            this.cadastro.loading = false;
            this.msg.dialog = true;
            this.msg.error = false;
            this.msg.titulo ='Anúncio registrado!';
            this.msg.message = 'Seu anúncio "' + this.cadastro.tipo + '" foi cadastrado com Sucesso!';

          })
          .catch(error => {
            console.log(error);
            this.cadastro.loading = false;
            this.msg.dialog = true;
            this.msg.error = true;
            this.msg.titulo ='ERROR';
            this.msg.message = error;

          });

        }

      }
    }
  }

</script>
