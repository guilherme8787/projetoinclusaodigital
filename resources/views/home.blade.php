@extends('layout/base')

@section('title', 'Home')

@section('home-ativo', 'active')

<div style="width: 100%; height: 430px; position: absolute; background: #fdf9e2; z-index: -1;">
</div>
@section('content')

<div id="app1">
    <div class="loading" v-if="loading">
      <span style="width:80%;"><span class="progress"></span></span>
    </div>
    <div style="width: 500px; height: 500px;" v-if="loading">
    </div>
    <div class="mb-4" style="max-width: 830px; margin: 0 auto;" v-for="paginas in pagina" v-html="paginas.content">
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

<script>
    const app = new Vue({
        el: '#app1',
        data: {
            pagina: [],
            loading: true,
            token: '{!! Helper::genKey() !!}',
        },
        created() {
            fetch('https://inclusaodigitalnasescolas.com.br/api/pagina?pagina=home&token='+this.token)
                .then(response => response.json())
                .then(json => {
                  this.pagina = json;
                  this.loading = false;
                });
        },
        methods: {
        }
    });
</script>

@endsection
