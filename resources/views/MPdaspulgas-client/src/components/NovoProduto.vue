<template>
    <div>
        <v-toolbar app>
        <v-toolbar-title class="headline text-uppercase">
            <!-- <span>Vuetify</span> -->
            <span @click="onHome" style="cursor:pointer;" class="font-weight-light">Dinni Compras</span>
        </v-toolbar-title>
        <v-spacer></v-spacer>

        </v-toolbar>

        <v-content>

        <v-layout row wrap>
            <v-flex xs12 sm6 offset-sm3>
            <v-form

            >
            <v-text-field
                v-model="nome"

                label="Nome"
                required
            ></v-text-field>

            <v-text-field
                v-model="descricao"

                label="Descrição"
                required
            ></v-text-field>

            <v-text-field
                v-model="unidade"

                label="Unidade"
                required
            ></v-text-field>

            <v-text-field
                v-model="quantidade"
                label="Quantidade"
                required
            ></v-text-field>

            <v-text-field
                v-model="preco"
                label="Preço"
                required
            ></v-text-field>

            <v-btn
                color="success"
                @click="save"
                :loading="loading"
            >
                Cadastrar
            </v-btn>
            </v-form>
        </v-flex>
        </v-layout>
        <!--<HelloWorld/>-->
        <!--FORMULARIO DE CADASTRO DE USUARIOS -->
        <!--/FORMULARIO DE CADASTRO DE USUARIOS -->
        </v-content>
    </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'NovoProduto',
  data: () => ({
    nome: '',
    descricao:'',
    unidade: '',
    quantidade:'',
    preco:'',
    carregar: false
  }),
  methods: {
    save () {
      this.carregar = true

      // Send a POST request
      axios.post('http://localhost:8000/api/produtos', {
        nome: this.nome,
        descricao: this.descricao,
        unidade: this.unidade,
        quantidade: this.quantidade,
        preco: this.preco
      })
      .then((response)=>{
        console.log(response)
      })
      .catch((err) => {
        console.log('Aconteceu '+ err)
      }).finally(() => {
        this.carregar = false
      })
    },
    onHome () {
        this.$router.push('/')
    }
  },
  computed: {
    loading () {
      return this.carregar
    }
  }
}
</script>
