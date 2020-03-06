    <template>
    
    <div class="row" id="ads">
        <div>
            <div v-for="room in rooms" :key="room.id"class="card rounded h-50 w-50">
                <router-link :to="{name: 'book', params: { id: room.id }}" class="noDecor">
                    <div class="card-image">
                        <img class="img-fluid" :src="getImage(room.image)">
                    </div>
                
                    <div class="card-body text-center d-flex flex-column customCss">
                        <span class="card-header-tabs text-center pl-2 pr-2 noDecor">{{ room.name }} </span>
                        <span class="card-header-tabs text-center mt-2 pl-2 pr-2 smallText"> {{ room.description[locale] }} </span>
                        <span class="card-header-tabs text-center mt-2 pl-2 pr-2 smallText pb-3"> {{ room.location }}</span>
                        <span class="card-header-tabs text-center mt-2 pl-2 pr-2 smallText grayColor">

                        </span>
                    </div>
                </router-link>
            </div>
        </div>
    </div>  

</template>

<script>

    import { locale } from '../routes.js'

    export default{
        
        data() {

            return {
                rooms: [],
                locale: locale
            }
        },

        created() {
            this.axios
                .get('/api/rooms')
                .then(response => {
                    this.rooms = response.data.data;
                    console.log(locale);
                });
        },

        methods: {
            getImage(image){
                return "/storage/"+image;
            },
        },

    }

</script>