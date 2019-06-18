<template>
  <v-container class="login" fluid fill-height>
    <v-layout align-center justify-space-around>
      <v-flex xs11 sm7 md5 lg4 xl3 >
        <v-card class="elevation-12">
          <v-toolbar extended dark color="#de5d3c">
            <v-img src="https://i.imgur.com/tkdu3cV.png" max-width="450" min-width="300" class="mt-5" aspect-ratio="4.5" contain></v-img>
          </v-toolbar>
          
          <v-card-text >
            <v-form>
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
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="#de5d3c" dark @click="submit()" :loading="carregando">Login</v-btn>
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
          user: {
            nome: 'Usuario 8',
            token: '45asdasd5as15646',
            email: '',
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
          this.carregando = true;/*
          axios.post(sessionStorage.getItem('url')+'/api/login', this.user )
          .then(response => { */
            sessionStorage.setItem('urt', this.user.token)
            sessionStorage.setItem('nome', this.user.nome)
            sessionStorage.setItem('email', this.user.email)
            this.$router.push('/App');
        /*  })
          .catch(error => {
            this.message_box = true;
            this.mensagem = error;
            this.carregando = false;
            if(this.mensagem == 'Error: Request failed with status code 400')
              this.mensagem = "E-mail ou senha incorreta"
            console.log(this.mensagem);
          }); */
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