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
    <v-layout v-if="i == 1" row wrap>
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
            <v-btn flat color="green" @click="">Comprar</v-btn>
            <v-btn flat color="orange" @click="">Ver mais</v-btn>
            </v-card-actions>
        </v-card>
        </v-flex>
    </v-layout>
  </v-container>
</template>
<script>
  const axios = require('axios');
  export default {
    data: vm => ({
      msg:{
        error: null,
        dialog: false,
        message: '',
        titulo: '',
      },
      busca_search: '',
      busca_categoria: 'Todas',
      categoria_atual:[],
      anuncios: null,
      anuncios_filtro:[],
      emprestimos_filtro:[],
      doacoes_filtro:[],
      leiloes_filtro:[],
      tipos: ['Venda', 'Leilão', 'Empréstimo', 'Doação'],
      categoria: ['Todas','Automoveis','Eletrodomesticos','Eletronicos','Livraria','Pecuaria','Serviços','Outros'],
    }),
    created() {
      this.initialize('denis');
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
      busca_search (val) {
        this.anuncios_filtro = this.anuncios.filter(a => a.titulo.toLowerCase().includes(val))

        this.leiloes_filtro = this.leiloes.filter(a => a.titulo.toLowerCase().includes(val))

        this.emprestimos_filtro = this.emprestimos.filter(a => a.titulo.toLowerCase().includes(val))

        this.doacoes_filtro = this.doacoes.filter(a => a.titulo.toLowerCase().includes(val))
      },
      busca_categoria (val) {
        if(this.busca_categoria != 'Todas'){
          this.anuncios_filtro = this.anuncios.filter(a => a.categoria.includes(val))
          this.leiloes_filtro = this.leiloes.filter(a => a.categoria.includes(val))
          this.emprestimos_filtro = this.emprestimos.filter(a => a.categoria.includes(val))
          this.doacoes_filtro = this.doacoes.filter(a => a.categoria.includes(val))
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
        if(tipo == 'denis'){
        axios
          .get('http://localhost:8000/api/negociacao1')
          .then(response => {
            this.anuncios = response.data
            this.anuncios_filtro = this.anuncios;
          })
          .catch(error => {
            console.log(error);
          });
        }
    }
}
  }
</script>
