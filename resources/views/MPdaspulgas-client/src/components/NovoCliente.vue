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
                v-model="sobrenome"

                label="Sobrenome"
                required
            ></v-text-field>

            <v-text-field
                v-model="cpf"

                label="CPF"
                required
            ></v-text-field>

            <v-text-field
                v-model="email"
                label="E-mail"
                required
            ></v-text-field>

            <v-text-field
                v-model="datanasc"
                label="Data de nascimento"
                required
            ></v-text-field>

            <v-btn
                color="success"
                @click="save()"
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
import moment from 'moment'

export default {
  name: 'NovoCliente',
  data: () => ({
    nome: '',
    sobrenome:'',
    cpf: '',
    email:'',
    datanasc:'',
    carregar: false,
    datanascConv: ''
  }),
  methods: {
    save () {
      this.carregar = true

      // Send a POST request
      axios.post('http://localhost:8000/api/clientes', {
        nome: this.nome,
        sobrenome: this.sobrenome,
        cpf: this.cpf,
        email: this.email,
        data_nascimento: this.formatDataToSent(this.datanasc)
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
    },
    formatDataToSent (date) {
        return moment(date, 'DD/MM/YYYY').format('YYYY-MM-DD');
    }
  },
  computed: {
    loading () {
      return this.carregar
    }
  }
}
</script>
