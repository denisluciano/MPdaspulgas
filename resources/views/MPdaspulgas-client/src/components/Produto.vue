
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

        <!-- dialog para registrar uma compra -->
        <v-dialog v-model="dialog" max-width="500px">
          <v-card>
            <v-card-text>
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

              <small class="grey--text">* This doesn't actually save.</small>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn flat color="primary" @click="dialog = false; save();">Submit</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
        <!--  -->

        <!-- dialog para editar um produto -->
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

        <!-- dialog para deletar um produto -->
        <v-dialog v-model="dialog_delete" max-width="500px">
          <v-card>
            <v-card-text>
                <h1>Tem certeza que deseja excluir o produto <u>{{nome_delete}}</u>?</h1>
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

            <v-list two-line>
            <template v-for="(item, index) in items">
                <v-list-tile
                :key="index"
                >
                    <v-flex xs9>
                        <v-list-tile-content>
                            <v-list-tile-title>Nome Produto: {{item.nome}}</v-list-tile-title>
                            <v-list-tile-sub-title>Descriçao: {{item.descricao}}</v-list-tile-sub-title>
                            <v-list-tile-sub-title>Preço: {{item.preco}}</v-list-tile-sub-title>
                        </v-list-tile-content>
                        <v-divider></v-divider>
                    </v-flex>
                    <v-flex xs1>
                        <v-btn @click="dialog = !dialog; produto = item.id" color="success">Comprar</v-btn>
                    </v-flex>
                    <v-flex xs1 align-end>
                        <v-btn
                        @click="dialog_edit = !dialog_edit;
                        id_ed = item.id;
                        nome_ed = item.nome;
                        descricao_ed = item.descricao;
                        unidade_ed = item.unidade;
                        quantidade_ed = item.quantidade
                        preco_ed = item.preco "
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

