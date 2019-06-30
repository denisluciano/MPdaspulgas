<template>
  <v-container class="login" fluid fill-height>
    <v-layout align-center justify-space-around>
      <v-flex xs11 sm7 md5 lg4 xl3 >
        <v-card class="elevation-12">
          <v-toolbar extended dark color="#de5d3c">
            <v-img src="https://i.imgur.com/O2kLb3y.png" max-width="450" min-width="300" class="mt-5" aspect-ratio="4.5" contain></v-img>
          </v-toolbar>

          <v-card-text >
            <v-form v-if="registrando == false">
              <v-text-field
                color="#de5d3c"
                v-model="user.email"
                prepend-icon="person"
                name="login"
                label="E-mail"
                placeholder="Insira seu e-mail aqui"
                type="text"
                :rules="emailRules"></v-text-field>
              <v-text-field
                color="#de5d3c"
                v-model="user.password"
                prepend-icon="lock"
                name="Senha"
                label="Senha"
                placeholder="Insira sua senha aqui"
                id="password"
                min="5"
                :append-icon="senha_visivel ? 'visibility' : 'visibility_off'"
                @click:append = "() => (senha_visivel = !senha_visivel)"
                :type="senha_visivel ? 'text' : 'password'"
                :rules="passwordRules"
                required
                @keyup.enter="submit()"
                ></v-text-field>
            </v-form>
            <v-form v-if="registrando == true">
              <v-layout row wrap>
              <v-flex xs12>
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.nome"
                prepend-icon="assignment_ind"
                name="login"
                label="Insira seu nome completo"
                placeholder="Insira seu nome completo"
                type="text"
                ></v-text-field>
              </v-flex>
              <v-flex xs6>
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.apelido"
                prepend-icon="person"
                name="login"
                label="Insira seu apelido"
                placeholder="Insira seu apelido"
                type="text"
                ></v-text-field>
              </v-flex>
              <v-flex xs6>
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.cpf"
                mask="###.###.###-##"
                prepend-icon="fingerprint"
                name="login"
                label="Insira seu CPF"
                placeholder="Insira seu CPF"
                type="text"
                ></v-text-field>
              </v-flex>
              <v-flex xs12>
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.email"
                prepend-icon="alternate_email"
                name="login"
                label="Insira seu e-mail"
                placeholder="Insira seu e-mail"
                type="text"
                ></v-text-field>
              </v-flex>
              <v-flex xs12>
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.password"
                prepend-icon="lock"
                name="Senha"
                label="Insira sua senha"
                placeholder="Insira sua senha"
                id="password"
                min="5"
                :append-icon="senha_visivel ? 'visibility' : 'visibility_off'"
                @click:append = "() => (senha_visivel = !senha_visivel)"
                :type="senha_visivel ? 'text' : 'password'"
                @keyup.enter="submit()"
              ></v-text-field>
              </v-flex>
              <v-flex xs5>
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.endereco.rua"
                class="pr-2"
                name="rua"
                label="Rua"
                placeholder="Rua"
                type="text"
                ></v-text-field>
              </v-flex>
              <v-flex xs5>
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.endereco.bairro"
                class="pr-2"
                name="bairro"
                label="Bairro"
                placeholder="Bairro"
                type="text"
                ></v-text-field>
              </v-flex>
              <v-flex xs2>
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.endereco.numero"
                class="pr-2"
                name="numero"
                label="Número"
                placeholder="Número"
                type="text"
                ></v-text-field>
              </v-flex>
              <v-flex xs4>
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.endereco.cep"
                class="pr-2"
                name="cep"
                label="CEP"
                placeholder="CEP"
                type="text"
                ></v-text-field>
              </v-flex>
              <v-flex xs4>
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.endereco.estado"
                class="pr-2"
                name="estado"
                label="Estado"
                placeholder="Estado"
                type="text"
                ></v-text-field>
              </v-flex>
              <v-flex xs4>
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.endereco.cidade"
                class="pr-2"
                name="cidade"
                label="Cidade"
                placeholder="Cidade"
                type="text"
                ></v-text-field>
              </v-flex>
              <v-flex xs10 v-for="bas in user_cadastro.qnt_telefones" :key="bas">
              <v-text-field
                color="#de5d3c"
                v-model="user_cadastro.telefones[bas-1]"
                prepend-icon="phone"
                mask="(##) #####-####"
                name="login"
                label="Insira seus telefones"
                placeholder="Insira seus telefones"
                type="text"
                ></v-text-field>
              </v-flex>
              <v-flex xs1 class="pt-2">
                <v-btn flat icon color="green" @click="add_phone">
                  <v-icon>add</v-icon>
                </v-btn>
              </v-flex>
              </v-layout>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="#de5d3c" v-if="registrando == false" dark @click="register(true)">Registrar-se</v-btn>
            <v-btn color="#de5d3c" v-if="registrando == false" dark @click="submit()" :loading="carregando">Fazer Login</v-btn>
            <v-btn color="#de5d3c" v-if="registrando == true" dark @click="register(false)">Voltar</v-btn>
            <v-btn color="#de5d3c" v-if="registrando == true" dark @click="cadastra" :loading="carregando">Fazer Registro</v-btn>
          </v-card-actions>
        </v-card>
      </v-flex>
    </v-layout>
    <v-dialog
      v-model="message_box"
      max-width="400"
    >
      <v-card>
        <v-card-title class="headline red--text" >ERROR</v-card-title>
        <v-card-text>{{mensagem}}</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            flat="flat"
            @click="message_box = false;"
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
      data () {
        return {
          mensagem: '',
          message_box: false,
          logado: false,
          carregando: false,
          registrando: false,
          user: {
            email: '',
            password: '',
          },
          user_cadastro: {
            nome: '',
            apelido: '',
            email: '',
            cpf: '',
            qnt_telefones: 1,
            telefones:[],
            endereco: {
              rua: '',
              bairro: '',
              estado: '',
              numero: '',
              cidade: '',
              cep: '',
            },
            password: '',
          },
          senha_visivel: false,
          password: '',
          passwordRules: [
            (v) => !!v || 'Senha é obrigatória',
          ],
          email: '',
          emailRules: [
            (v) => !!v || 'E-mail é obrigatório',
            (v) => /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail inválido'
          ],
        }
      },
      methods: {
        submit () {
          this.carregando = true;
          axios.post(sessionStorage.getItem('url')+'/api/autentica', this.user )
          .then(response => {
            console.log(response.data)
            if(response.data.ok == true){
              sessionStorage.setItem('nome', response.data.usuario.original[0].nome)
              sessionStorage.setItem('id', response.data.usuario.original[0].id)
              sessionStorage.setItem('email', response.data.usuario.original[0].email)
              sessionStorage.setItem('apelido', response.data.usuario.original[0].apelido)
              sessionStorage.setItem('cpf', response.data.usuario.original[0].cpf)
              this.$router.push('/Anuncios');
            }
            else{
              this.message_box = true;
              this.carregando = false;
              this.mensagem = "E-mail ou senha incorreta"
            }
          })
          .catch(error => {
            this.message_box = true;
            this.mensagem = error;
            this.carregando = false;
            if(this.mensagem == 'Error: Request failed with status code 400')
              this.mensagem = "E-mail ou senha incorreta"
            console.log(this.mensagem);
          });
      },
      cadastra () {
          console.log(this.user_cadastro)
          this.carregando = true;
          axios.post(sessionStorage.getItem('url')+'/api/usuario', this.user_cadastro )
          .then(response => {
            console.log(response.data)
            sessionStorage.setItem('nome', response.data.usuario.original[0].nome)
            sessionStorage.setItem('id', response.data.usuario.original[0].id)
            sessionStorage.setItem('email', response.data.usuario.original[0].email)
            sessionStorage.setItem('apelido', response.data.usuario.original[0].apelido)
            sessionStorage.setItem('cpf', response.data.usuario.original[0].cpf)
            this.$router.push('/Anuncios');
          })
          .catch(error => {
            this.message_box = true;
            this.mensagem = error;
            this.carregando = false;
            if(this.mensagem == 'Error: Request failed with status code 400')
              this.mensagem = "E-mail ou senha incorreta"
            console.log(this.mensagem);
          });
      },
      add_phone(){
        this.user_cadastro.qnt_telefones = this.user_cadastro.qnt_telefones + 1;
        console.log(this.user_cadastro.telefones)
      },
      register(x){
        if(x == true)
          this.registrando = true;
        else{
          this.registrando = false;
        }
      },
      clear () {
        this.$refs.form.reset()
      }
      }
    }
 </script>
 <style>
    .login {
      background-image: url("../assets/floresta.jpg");
      background-size: cover;
      overflow:hidden;
    }

    .fundoLogo {
      background-size: contain;
      overflow:hidden;
      margin: auto;
    }

    .logo {
      background-image: url("../assets/logoVerde.png");
      background-size: contain;
      overflow:hidden;
      margin: auto;
      max-width: 90%;
      padding: auto;
      align-self: center;
    }

    .loginOverlay {
    background:rgba(33,150,243,0.3);
    }

    .photoCredit{
    position: absolute;
    bottom: 15px;
    right: 15px;
    }
</style>
