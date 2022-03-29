@extends('layout/base')

@section('title', 'Busca e Curadoria')

@section('bucus-ativo', 'active')

<div style="width: 100%; height: 430px; position: absolute; background: #fff8e2; z-index: -1;">
</div>

@section('content')

<div class="container p-4" id="app1">

    <div class="row">
        <div class="col-sm-12 col-md-4 col-lg-4 col-xs-4">
          <a class="btn" style="width: 100%; margin-bottom: 5px; color: white; border-radius: 0; background-color: #f73358;">Ciclo</a>
          <div class="mb-3" style="height: 100px;overflow-y: scroll;">
              <div class="form-check" v-for="ciclo in ciclos">
                <input v-on:click="queryMount('ciclo', ciclo.ciclo)" class="form-check-input" type="checkbox">
                <label class="form-check-label" for="disabledFieldsetCheck">
                  @{{ ciclo.ciclo }}
                </label>
              </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xs-4">
          <a class="btn" style="width: 100%; margin-bottom: 5px; color: white; border-radius: 0; background-color: #4ea79b;">Categoria</a>
          <div class="mb-3" style="height: 100px;overflow-y: scroll;">
            <div class="form-check" v-for="categoria in categorias">
              <input v-on:click="queryMount('categoria', categoria.categoria)" class="form-check-input" type="checkbox">
              <label class="form-check-label" for="disabledFieldsetCheck">
                @{{ categoria.categoria }}
              </label>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-4 col-lg-4 col-xs-4">
          <a class="btn" style="width: 100%; margin-bottom: 5px; color: white; border-radius: 0; background-color: #14B0F5;">Disciplina</a>
          <div class="mb-3" style="height: 100px;overflow-y: scroll;">
            <div class="form-check" v-for="disciplina in disciplinas">
              <input v-on:click="queryMount('disciplina', disciplina.disciplina)" class="form-check-input" type="checkbox">
              <label class="form-check-label" for="disabledFieldsetCheck">
                @{{ disciplina.disciplina }}
              </label>
            </div>
          </div>
        </div>
    </div>

    <div class="form__group field">
        <input v-on:change="buscaConteudo()" type="input" v-model="searchField" class="form__field" placeholder="Pesquise por palavras chave" name="name" id='name' required />
        <label for="name" class="form__label">Buscar</label>
    </div>

    <br>
    <br>
    <br>
    <div class="loading" v-if="loading">
      <span style="width:80%;"><span class="progress"></span></span>
    </div>
    <br>
    <div class="row">
      <div class="col-sm-12 col-md-4 col-lg-4 col-xs-4" v-for="conteudo in conteudos">

          <div class="card" style="margin-top: 30px; border: 0;">
              <img src="https://inclusaodigitalnasescolas.com.br/storage/img/nothuhmbpng.png" v-on:load="getCoverLink('img'+conteudo.id, conteudo.link)" v-bind:id="'img'+conteudo.id" class="card-img-top img-fluid" style="width: 400px; height: 200px; object-fit: cover;">
              <div class="card-body text-center">
                  <div style="margin-bottom: 10px;">
                      <span class="badge bg-success" v-bind:title="conteudo.categoria">@{{ textoBonito(conteudo.categoria) }}</span>
                      <span class="badge bg-danger" v-bind:title="conteudo.ciclo">@{{ textoBonito(conteudo.ciclo) }}</span>
                      <span class="badge bg-warning text-dark" v-bind:title="conteudo.disciplina">@{{ textoBonito(conteudo.disciplina) }}</span>
                      <span class="badge bg-info text-dark" v-bind:title="conteudo.tipo">@{{ textoBonito(conteudo.tipo) }}</span>
                  </div>
                  <h5 class="card-title">@{{ conteudo.titulo }}</h5>
                  <p class="card-text">@{{ conteudo.descricao.substring(0,80) + '...' }}</p>
                  <div v-html="getLink(conteudo.link)" style="margin-bottom: 8px;">

                  </div>
              </div>
          </div>

      </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

<script>
    const app = new Vue({
        el: '#app1',
        data: {
            disciplinas: [],
            ciclos: [],
            categorias: [],
            conteudos: [],
            loading: true,
            token: '{!! Helper::genKey() !!}',
            queryString: '',
            searchField: '',
        },
        created() {
            fetch('https://inclusaodigitalnasescolas.com.br/api/categoria?token='+this.token)
                .then(response => response.json())
                .then(json => {
                  this.categorias = json;
                });
            fetch('https://inclusaodigitalnasescolas.com.br/api/disciplina?token='+this.token)
                .then(response => response.json())
                .then(json => {
                  this.disciplinas = json;
                });
            fetch('https://inclusaodigitalnasescolas.com.br/api/ciclo?token='+this.token)
                .then(response => response.json())
                .then(json => {
                  this.ciclos = json;
                });
            fetch('https://inclusaodigitalnasescolas.com.br/api/conteudos?token='+this.token)
                .then(response => response.json())
                .then(json => {
                  this.conteudos = json;
                  this.loading = false;
                });
        },
        methods: {
            maiusculo: function (a) {
                return a.toUpperCase();
            },
            textoBonito: function (a) {
              if(a != null){
                if(a.length > 25){
                  return a.substring(0,25)+'...';
                } else {
                  return a;
                }
              }
            },
            queryMount: function (field, value) {
              var queryString = '&'+field+'='+value;
              if(this.queryString != '' && this.queryString.includes(queryString)){
                this.queryString = this.queryString.replace(queryString, '');
              } else {
                this.queryString += '&'+field+'='+value;
              }
              this.buscaConteudo();
            },
            buscaConteudo: function () {
                this.loading = true;
                fetch('https://inclusaodigitalnasescolas.com.br/api/conteudos?token='+this.token+'&descricao='+this.searchField+this.queryString)
                  .then(response => response.json())
                  .then(json => {
                    this.conteudos = json;
                    this.loading = false;
                  })
            },
            geraId: function (idName) {
              return idName + Math.floor(Math.random() * 65536);
            },
            getCoverLink: function (id, url) {
              imgStorage = localStorage.getItem(id);
              if(imgStorage == null){
                fetch('https://inclusaodigitalnasescolas.com.br/api/link-preview?url='+url+'&token='+this.token)
                    .then(response => response.json())
                    .then(json => {
                      if(json.img == null || typeof(json.img.length) == "undefined"){
                        imgResponse = 'https://inclusaodigitalnasescolas.com.br/storage/img/nothuhmbpng.png';
                      } else {
                        imgResponse = json.img;
                      }
                      localStorage.setItem(id, imgResponse);
                      // document.getElementById(id).src = imgResponse;
                    })
              } else {
                document.getElementById(id).src = imgStorage;
              }
            },
            getLink: function(links){
              html = '';
              arr = links.split(';')
              arr.forEach(function(a){
                if(a.trim() != ''){
                  if(a.includes("play.google")){
                    html += `<a href="`+a+`" target="_BLANK"><img width="32" src="img/play.png" /></a>&nbsp;&nbsp;`;
                  } else if(a.includes("youtube.com")){
                    html += `<a href="`+a+`" target="_BLANK"><img width="32" src="img/video.png" /></a>&nbsp;&nbsp;`;
                  } else {
                    html += `<a href="`+a+`" target="_BLANK"><img width="32" src="img/website.png" /></a>&nbsp;&nbsp;`;
                  }
                }
              })
              return html;
            }
        }
    });
</script>

<br>
<br>
<br>
@endsection