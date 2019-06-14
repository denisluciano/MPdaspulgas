<template>
    <div>
        <v-toolbar app>
        <v-toolbar-title class="headline text-uppercase">
            <!-- <span>Vuetify</span> -->
            <span @click="onHome" style="cursor:pointer;" class="font-weight-light">MP das pulgas</span>
        </v-toolbar-title>

        <v-spacer></v-spacer>
        <v-btn>logar</v-btn>
        <v-btn>cadastrar</v-btn>
        </v-toolbar>


        <v-content>


        <v-form>
            <v-divider></v-divider>
            <v-layout align-center justify-center column fill-height>
                <v-flex xs12 >
                    <v-btn round style="cursor:disable;" color="primary" dark>Dados pessoais</v-btn>

                </v-flex>

            </v-layout>

            <v-layout row wrap>
                <v-flex xs12 sm6 offset-sm3>

            <v-text-field
                v-model="nome"

                label="Nome sobrenome"
                required
            ></v-text-field>

            <v-text-field
                v-model="apelido"
                label="Apelido"
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
                v-model="telefone"

                label="Telefone principal"
                required
            ></v-text-field>

                </v-flex>
            </v-layout>

            <v-divider></v-divider>
            <v-layout align-center justify-center column fill-height>
                <v-flex xs12 >
                    <v-btn round style="cursor:disable;" color="primary" dark>Endereço principal</v-btn>

                </v-flex>

            </v-layout>

            <v-layout row wrap>
                <v-flex xs12 sm6 offset-sm3>

            <v-text-field
                v-model="cep"
                label="CEP"
                required
            ></v-text-field>

            <v-text-field
                v-model="estado"
                label="Estado"
                required
            ></v-text-field>
            <v-text-field
                v-model="cidade"
                label="Cidade"
                required
            ></v-text-field>
            <v-text-field
                v-model="bairro"
                label="Bairro"
                required
            ></v-text-field>
            <v-text-field
                v-model="rua"
                label="Rua"
                required
            ></v-text-field>
            <v-text-field
                v-model="numero"
                label="Número"
                required
            ></v-text-field>



            <v-btn
                color="success"
                @click="save()"
                :loading="loading"
            >
                Cadastrar
            </v-btn>


        </v-flex>
        </v-layout>
        </v-form>
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
