
<template>

    <div>
        <v-toolbar app>
        <v-toolbar-title class="headline text-uppercase">
            <span @click="onHome" style="cursor:pointer;" class="font-weight-light">Dinni Compras</span>
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn
            flat
            to="/produtos/novo"
        >
            <span class="mr-2">Novo produto</span>
        </v-btn>
        </v-toolbar>


            <v-layout align-center justify-center column fill-height>
                <v-flex xs12 >
                    <v-btn round style="cursor:disable;" color="primary" dark>Dados pessoais</v-btn>

                </v-flex>

            </v-layout>




                <v-form ref="form" lazy-validation >

                    <v-layout row wrap>
                <v-flex xs12 sm6 offset-sm3>


                    <v-text-field
                    v-model="nome_ed"
                    :counter="10"
                    label="Nome"
                    required
                    ></v-text-field>

                    <v-text-field
                    v-model="descricao_ed"
                    :counter="10"
                    label="Descrição"
                    required
                    ></v-text-field>

                    <v-text-field
                    v-model="unidade_ed"
                    :counter="10"
                    label="Unidade"
                    required
                    ></v-text-field>

                    <v-text-field
                    v-model="quantidade_ed"
                    :counter="10"
                    label="Quantidade"
                    required
                    ></v-text-field>

                    <v-text-field
                    v-model="preco_ed"
                    :counter="10"
                    label="Preço"
                    required
                    ></v-text-field>



              <v-autocomplete
                ref="cliente"
                v-model="cliente"
                :rules="[() => !!cliente || 'This field is required']"
                :items="clientes"
                label="Cliente"
                item-text="nome"
                item-value="id"
                placeholder="Selecione..."
                required
            ></v-autocomplete>


            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn flat color="primary" @click="dialog = false; save();">Submit</v-btn>
            </v-card-actions>

            </v-flex>
            </v-layout>



            </v-form>
    </div>

</template>

<script>
  import axios from 'axios'

  export default {
      name:"Produto",
    data () {
      return {
        items: [],
        dialog: false,
        dialog_edit: false,
        clientes: [],
        cliente: null,
        produto: null,
        id_ed:'',
        nome_ed: '',
        descricao_ed: '',
        unidade_ed: '',
        quantidade_ed:'',
        preco_ed: '',
        dialog_delete: false,
        id_delete:'',
        nome_delete: '',
      }
    },
    computed: {
      form () {
        return {
          cliente: this.cliente
        }
      }
    },
    methods: {
        onInit () {
            axios.get("http://127.0.0.1:8000/api/produtos").then((res) => {
                this.items = res.data
            }).catch((error) => {
                console.log(error)
            })

            // Requisição é feita aqui para obter todos clientes para quando for
            // selecionar o cliente o usuário não precisar esperar
            axios.get("http://127.0.0.1:8000/api/clientes").then((res) => {
                this.clientes = res.data
            }).catch((error) => {
                console.log(error)
            })

        },
        onHome () {
          this.$router.push('/')
        },
        save () {
            axios.post('http://localhost:8000/api/compras', {
                cliente_id: this.cliente,
                produto_id: this.produto
            })
            .then((response)=>{
                console.log(response)
            })
            .catch((err) => {
                console.log('Aconteceu '+ err)
            })
            //console.log("hirihc");
        },
        edit () {

            console.log(this.nome_ed +
                this.descricao_ed + this.unidade_ed + this.quantidade_ed + this.preco_ed)

            axios.put('http://localhost:8000/api/produtos/'+this.id_ed,{
                nome : this.nome_ed,
                descricao: this.descricao_ed,
                unidade: this.unidade_ed,
                quantidade: this.quantidade_ed,
                preco: this.preco_ed
            }).then((res) => {
                console.log(res)
            }).catch((err) => {
                console.log(err)
            })
        },
        remove () {
            axios.delete('http://localhost:8000/api/produtos/'+this.id_delete)
            .catch((err) => {
                console.log(err)
            })
        }
    },
    mounted () {
        this.onInit()
    }
  }
</script>

