
<template>

    <div>
        <v-toolbar app>
            <v-toolbar-title class="headline text-uppercase">
                <span @click="onHome" style="cursor:pointer;" class="font-weight-light">Dinni Compras</span>
            </v-toolbar-title>
            <v-spacer></v-spacer>
            <v-btn
                flat
                to="/clientes/novo"
            >
                <span class="mr-2">Novo cliente</span>
            </v-btn>
        </v-toolbar>

        <!-- dialog para editar cliente -->
        <v-dialog v-model="dialog_edit" max-width="500px">
          <v-card>
            <v-card-text>
                <v-form
                    ref="form"
                    lazy-validation
                >
                    <v-text-field
                    v-model="nome_ed"
                    :counter="10"
                    label="Nome"
                    required
                    ></v-text-field>

                    <v-text-field
                    v-model="sobrenome_ed"
                    :counter="10"
                    label="Sobrenome"
                    required
                    ></v-text-field>

                    <v-text-field
                    v-model="cpf_ed"
                    :counter="10"
                    label="CPF"
                    required
                    ></v-text-field>

                    <v-text-field
                    v-model="email_ed"
                    :counter="10"
                    label="E-mail"
                    required
                    ></v-text-field>

                    <v-text-field
                    v-model="data_nascimento_ed"
                    :counter="10"
                    label="Data nascimento"
                    required
                    ></v-text-field>

                </v-form>

              <small class="grey--text">* This doesn't actually save.</small>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn flat color="primary" @click="dialog_edit = false; edit();">Submit</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>

        <!--  -->

        <!-- dialog para excluir um cliente -->
        <v-dialog v-model="dialog_delete" max-width="500px">
          <v-card>
            <v-card-text>
                <h1>Tem certeza que deseja excluir o cliente <u>{{nome_delete}}</u>?</h1>
                <small class="grey--text">* Ação irreversível.</small>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn flat color="primary" @click="dialog_delete = false; remove();">Submit</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <!--  -->

    <v-layout row wrap >
        <v-flex xs12 >
            <v-card>
                <v-list three-line>
                    <template v-for="(item, index) in items">
                        <v-list-tile
                        :key="index"
                        >
                            <v-flex xs10>
                                <v-list-tile-content>
                                    <v-list-tile-title>Nome: {{item.nome+' '+item.sobrenome}}</v-list-tile-title>
                                    <v-list-tile-sub-title>E-mail: {{item.email}}</v-list-tile-sub-title>
                                    <v-list-tile-sub-title>Data de nascimento: {{formatDate(item.data_nascimento)}}</v-list-tile-sub-title>
                                    <v-list-tile-sub-title>CPF: {{item.cpf}}</v-list-tile-sub-title>
                                </v-list-tile-content>
                                <v-divider></v-divider>
                            </v-flex>
                            <v-flex xs1 >
                                <v-btn
                                @click="dialog_edit = !dialog_edit;
                                id_ed = item.id;
                                nome_ed = item.nome;
                                sobrenome_ed = item.sobrenome;
                                cpf_ed = item.cpf;
                                email_ed = item.email
                                data_nascimento_ed = item.data_nascimento"
                                color="warning">Editar</v-btn>
                            </v-flex>
                            <v-flex xs1>
                                <v-btn
                                @click="dialog_delete = !dialog_delete;
                                id_delete = item.id;
                                nome_delete = item.nome;"
                                color="error">Excluir</v-btn>
                            </v-flex>
                        </v-list-tile>
                    </template>
                </v-list>
            </v-card>
        </v-flex>
    </v-layout>
    </div>

</template>

<script>
  import axios from 'axios'
  import moment from 'moment'

  export default {
      name:"Cliente",
    data () {
      return {
        items: [],
        dialog_edit: false,
        id_ed:'',
        nome_ed: '',
        sobrenome_ed: '',
        cpf_ed: '',
        email_ed: '',
        data_nascimento_ed: '',
        dialog_delete: false,
        id_delete:'',
        nome_delete: ''

      }
    },
    methods: {
        onInit () {
            axios.get("http://127.0.0.1:8000/api/clientes").then((res) => {
                this.items = res.data
            }).catch((error) => {
                console.log(error)
            })
        },
        onHome () {
          this.$router.push('/')
        },
        edit () {

            axios.put('http://localhost:8000/api/clientes/'+this.id_ed,{
                nome : this.nome_ed,
                sobrenome: this.sobrenome_ed,
                cpf: this.cpf_ed,
                email: this.email_ed,
                data_nascimento: this.data_nascimento_ed
            }).then((res) => {
                console.log(res)
            }).catch((err) => {
                console.log(err)
            })
        },
        remove () {
            axios.delete('http://localhost:8000/api/clientes/'+this.id_delete)
            .catch((err) => {
                console.log(err)
            })
        },
        formatDate(date){
            return moment(date, 'YYYY-MM-DD').format('DD/MM/YYYY');
        }
    },
    mounted () {
        this.onInit()
    }
  }
</script>

