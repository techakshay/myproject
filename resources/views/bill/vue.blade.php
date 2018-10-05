<link rel="stylesheet" href="{{ asset("node_modules/v-autocomplete/dist/v-autocomplete.css") }}" />
<div id="app">
    <h1>Finds</h1>
    <div v-for="find in finds">

        {{-- <input v-model="find.value">--}}

        <select name="project_id" v-model="find.value" class="form-control selectize" required>
            <option value="">Select</option>
            <option value="1">Select</option>
            {{--@foreach($items as $item)
                <option value=" {{$item->bills}}">{{$item->bills}}</option>
            @endforeach--}}
        </select>
        <div class="form-group" >


            <label for="title" class=" control-label">Amount</label>


            <input id="amount" type="number" v-model="find.value2" class="form-control" name="amount" value="">
        </div>

    </div>
    <button @click="addFind">
        New Find
    </button>
    {{--<pre> @{{ $data | json }} </pre>--}}
</div>
<script src="https://unpkg.com/vue"></script>
<script src="{{ asset("node_modules/v-autocomplete/dist/v-autocomplete.js") }}"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            finds: []
        },
        methods: {
            addFind: function () {
                this.finds.push({ value: '' });
            }
        }
    });
    /*Vue.use(VAutocomplete.default)*/
</script>
{{--<template>
    <v-autocomplete :items="items" v-model="item" :get-label="getLabel" :component-item='template' @update-items="updateItems">
    </v-autocomplete>
</template>

<script>
    import ItemTemplate from './ItemTemplate.vue'
    export default {
        data () {
            return {
                item: {id: 9, name: 'Lion', description: 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.'},
                items: [],
                template: ItemTemplate
            }
        },
        methods: {
            getLabel (item) {
                return item.name
            },
            updateItems (text) {
                yourGetItemsMethod(text).then( (response) => {
                    this.items = response
                })
            }
        }
    }
</script>--}}

<!-- Include after Vue -->
{{--<link rel="stylesheet" href="{{ asset("node_modules/v-autocomplete/dist/v-autocomplete.css") }}"></link>
<script src="{{ asset("node_modules/v-autocomplete/dist/v-autocomplete.js") }}"></script>
<script>
    Vue.use(VAutocomplete.default)
</script>--}}