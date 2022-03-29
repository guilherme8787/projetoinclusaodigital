@extends('layout/base')

@section('title', 'Faq')

@section('faq-ativo', 'active')

<div style="width: 100%; height: 430px; position: absolute; background: #fdf9e2; z-index: -1;">
</div>

@section('content')


<div class="container p-4" id="app1">

    

    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" id="tab1" v-on:click="tabGeneretor('faq1')" href="#" style="color: #f73358;font-weight: 500;">Tecnológico</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tab2" v-on:click="tabGeneretor('faq2')" href="#" style="color: #f73358;font-weight: 500;">Pedagógico</a>
        </li>
    </ul>

    <!-- <table class="table"> -->
      
    <table id="faq1" class="table table-borderless">
      <thead>
        <th style="width: 100%;">
            <input class="form-control me-2" type="search" id="buscafaq" v-on:keyup="buscaTabFaq1()" placeholder="Pesquisar" aria-label="Pesquisar">
        </th>
      </thead>
      <tbody>
        <tr v-for="faq1 in faq1s">
          <td>
            <div class="accordion" v-bind:id="'accordion' + faq1.id">
                <div class="accordion-item">
                  <h2 class="accordion-header" v-bind:id="'heading' + faq1.id">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" v-bind:data-bs-target="'#collapse' + faq1.id" aria-expanded="false" v-bind:aria-controls="'#collapse' + faq1.id" style="color: white; background-color: rgb(247, 51, 88);">
                      @{{ faq1.pergunta }}
                    </button>
                  </h2>
                  <div v-bind:id="'collapse' + faq1.id" class="accordion-collapse collapse" v-bind:aria-labelledby="'heading' + faq1.id" v-bind:data-bs-parent="'accordion' + faq1.id">
                    <div class="accordion-body" v-html="faq1.resposta">
                    </div>
                  </div>
                </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- </table> -->


    <table id="faq2" class="table table-borderless" style="display:none;">
      <thead>
        <th style="width: 100%;">
            <input class="form-control me-2" type="search" id="buscafaq2" v-on:keyup="buscaTabFaq2()" placeholder="Pesquisar" aria-label="Pesquisar">
        </th>
      </thead>
      <tbody>
        <tr v-for="faq2 in faq2s">
          <td>
            <div class="accordion" v-bind:id="'accordionFaq2' + faq2.id" v-for="faq2 in faq2s">
                <div class="accordion-item">
                  <h2 class="accordion-header" v-bind:id="'headingFaq2' + faq2.id">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" v-bind:data-bs-target="'#collapseFaq2' + faq2.id" aria-expanded="false" v-bind:aria-controls="'#collapseFaq2' + faq2.id" style="color: white; background-color: rgb(247, 51, 88);">
                      @{{ faq2.pergunta }}
                    </button>
                  </h2>
                  <div v-bind:id="'collapseFaq2' + faq2.id" class="accordion-collapse collapse" v-bind:aria-labelledby="'headingFaq2' + faq2.id" v-bind:data-bs-parent="'accordionFaq2' + faq2.id">
                    <div class="accordion-body" v-html="faq2.resposta">
                    </div>
                  </div>
                </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>

</div>

<br>
<br>
<br>
<br>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>

<script>

    const app = new Vue({
        el: '#app1',
        data: {
            faq1s: [],
            faq2s: [],
            loading: true,
            token: '{!! Helper::genKey() !!}',
        },
        created() {
            fetch('https://inclusaodigitalnasescolas.com.br/api/faq1?token='+this.token)
                .then(response => response.json())
                .then(json => {
                  this.faq1s = json;
                });
            fetch('https://inclusaodigitalnasescolas.com.br/api/faq2?token='+this.token)
                .then(response => response.json())
                .then(json => {
                  this.faq2s = json;
                });
        },
        methods: {
          tabGeneretor: function(tabVez){
            if(tabVez === 'faq1'){
              document.getElementById('faq1').style = "display: ;";
              document.getElementById('faq2').style = "display: none;";
              document.getElementById('tab1').className  = "nav-link active";
              document.getElementById('tab2').className  = "nav-link";
            }
            if(tabVez === 'faq2'){
              document.getElementById('faq1').style = "display: none;";
              document.getElementById('faq2').style = "display: ;";
              document.getElementById('tab1').className  = "nav-link";
              document.getElementById('tab2').className  = "nav-link active";
            }
          },
          buscaTabFaq1: function() {
            const input = document.getElementById('buscafaq');
            const trs = [...document.querySelectorAll('#faq1 tbody tr')];

            input.addEventListener('input', () => {
              const search = input.value.toLowerCase();
              trs.forEach(el => {
                const matches = el.textContent.toLowerCase().includes(search);
                el.style.display = matches ? '' : 'none';
              });
            });
          },
          buscaTabFaq2: function() {
            const input = document.getElementById('buscafaq2');
            const trs = [...document.querySelectorAll('#faq2 tbody tr')];

            input.addEventListener('input', () => {
              const search = input.value.toLowerCase();
              trs.forEach(el => {
                const matches = el.textContent.toLowerCase().includes(search);
                el.style.display = matches ? '' : 'none';
              });
            });
          },
        }
    });
</script>

@endsection