<template>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <textarea class="form-control" readonly="" rows="10">{{messages.join('\n')}}</textarea>
                <hr>
                <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage" @keydown="actionUser">
                <span v-if="isActive">{{isActive.name}} набирает сообщение... </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {

        props:['room', 'user'],

        data(){
          return{
              messages:[],
              textMessage:'',
              isActive: false,
              typingTimer: false
          }
        },

        mounted() {

            // window.Echo.private('laravel_database_room.' + this.room.id)
            window.Echo.private('laravel_database_private-room.' + this.room.id)
                .listen('PrivateChat',({data}) =>{
                    console.log(data.body);
                this.messages.push(data.body);
                this.isActive = false;
                })
                .listenForWhisper('typing', (e) =>{
                    this.isActive = e;
                    if(this.typingTimer) clearTimeout(this.typingTimer);
                this.typingTimer = setTimeout(() =>{
                       this.isActive = false;
                    },2000);
            })

    },
        methods:{
            sendMessage()
            {
                axios.post('/messages', { body: this.textMessage, room_id: this.room.id });
                 // this.messages.push(this.textMessage);
                this.textMessage='';
            },
            actionUser()
            {
                window.Echo.private('laravel_database_private-room.' + this.room.id)
                    .whisper('typing', {
                        name:this.user.name
                    });
            }
        }
    }
</script>
