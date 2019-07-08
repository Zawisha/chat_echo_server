<template>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <textarea class="form-control" readonly="" rows="10">{{messages.join('\n')}}</textarea>
                <hr>
                <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
          return{
              messages:[],
              textMessage:''
          }
        },
        mounted() {
            window.Echo.channel('laravel_database_chat')
                .listen('Message',({message}) =>{
                this.messages.push(message)
                });
    },
        methods:{
            sendMessage()
            {
                axios.post('/messages', { body: this.textMessage });
                this.textMessage='';
            }
        }
    }
</script>
