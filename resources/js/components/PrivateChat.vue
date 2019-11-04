<template>
  <v-layout row>
    <v-flex class="online-users" xs4 md3>
      <v-list  style="padding:0px;">
          <v-list-item
            v-for="friend in friends"
            @click="activeFriend=friend.id"
            :class="(friend.id==activeFriend)?'activemate':''"
            :key="friend.id"
          >
            <v-list-item-action>
              <v-icon  style="color:#3f4257;margin:0px 10px;" :color="(onlineFriends.find(user=>user.id===friend.id))?'green':'red'">account_circle</v-icon>
            </v-list-item-action>

            <v-list-item-content>
              <v-list-item-title>{{friend.name}}</v-list-item-title>
            </v-list-item-content>
          
          </v-list-item>
          
        </v-list>
    </v-flex>
    
    <v-flex id="privateMessageBox" class="messages mb-5" xs8 md9>
        <message-list  :user="user" :all-messages="allMessages"></message-list>

        <v-footer
                height="auto"
                fixed
                xs3
                style="background-color:white"
        >
            <v-layout class="footerdiv" >
              <div class="floating-div" style="padding-bottom:300px;">
            <picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji…" />

        </div>
                <v-flex class="ml-2 text-right" xs1>
                    <v-btn @click="toggleEmo" fab style="background-color:#3f4257; color:white" small color="pink">
                        <v-icon>insert_emoticon </v-icon>
                    </v-btn>
                </v-flex>
                

                <v-flex xs1 class="text-center">
                    <file-upload
                            :post-action="'/private-message/'+activeFriend"
                            ref='upload'
                            v-model="files"
                            @input-file="$refs.upload.active = true"
                            :headers="{'X-CSRF-TOKEN': token}"
                    >
                        <v-icon class="mt-3">attach_file</v-icon>
                    </file-upload>

                </v-flex>
                <v-flex xs6 style="padding: 0 35px;" >
                    <v-text-field
                            rows=2
                            v-model="message"
                            label="Enter Message"
                            single-line
                            @keyup.enter="sendMessage"
                    ></v-text-field>
                </v-flex>

              
                    <v-btn
                            @click="sendMessage"
                            style="background-color:#3f4257; color:white" small color="green">send</v-btn>

            </v-layout>


        </v-footer>


    </v-flex>

  </v-layout>
</template>

<script>
  import MessageList from './_message-list'
  import { Picker } from 'emoji-mart-vue'


  export default {
    props:['user'],
    components:{
      Picker,
      MessageList
    },
    
    data () {
      return {
        message:null,
        files:[],
        activeFriend:null,
        typingFriend:{},
        onlineFriends:[],
        allMessages:[],
        typingClock:null,
        emoStatus:false,
        users:[],
        token:document.head.querySelector('meta[name="csrf-token"]').content

      }
    },

    computed:{
      friends(){
        return this.users.filter((user)=>{
          return user.id !==this.user.id;
        })
      }
    },

    watch:{
      files:{
        deep:true,
        handler(){
          let success=this.files[0].success;
          if(success){
            this.fetchMessages();
          }
        }
      },
      activeFriend(val){
        this.fetchMessages();
      },
      '$refs.upload'(val){
        console.log(val);
      }
    },

    methods:{
      onTyping(){
        Echo.private('privatechat.'+this.activeFriend).whisper('typing',{
          user:this.user

        });
      },
      sendMessage(){

        //check if there message
        if(!this.message){
          return alert('Please enter message');
        }
        if(!this.activeFriend){
          return alert('Please select friend');
        }

          axios.post('/private-message/'+this.activeFriend, {message: this.message}).then(response => {
                    this.message=null;
                    this.allMessages.push(response.data.message)
                    setTimeout(this.scrollToEnd,100);
          });
      },
      fetchMessages() {
         if(!this.activeFriend){
          return alert('Please select friend');
        }
            axios.get('/private-message/'+this.activeFriend).then(response => {
                this.allMessages = response.data;
              setTimeout(this.scrollToEnd,100);

            });
        },
      fetchUsers() {
            axios.get('/peoples').then(response => {
                this.users = response.data;
                if(this.friends.length>0){
                  this.activeFriend=this.friends[0].id;
                }
            });
        },


      scrollToEnd(){
        document.getElementById('privateMessageBox').scrollTo(0,99999);
      },
      toggleEmo(){
        this.emoStatus= !this.emoStatus;
      },
      onInput(e){
        if(!e){
          return false;
        }
        if(!this.message){
          this.message=e.native;
        }else{
          this.message=this.message + e.native;
        }
        this.emoStatus=false;
      },

      onResponse(e){
        console.log('onrespnse file up',e);
      }

    
    },

    mounted(){
    },

    created(){
              this.fetchUsers();

              Echo.join('plchat')
              .here((users) => {
                   console.log('online',users);
                   this.onlineFriends=users;
              })
              .joining((user) => {
                  this.onlineFriends.push(user);
                  console.log('joining',user.name);
              })
              .leaving((user) => {
                  this.onlineFriends.splice(this.onlineFriends.indexOf(user),1);
                  console.log('leaving',user.name);
              });
             
              Echo.private('privatechat.'+this.user.id)
                .listen('PrivateMessageSent',(e)=>{
                  console.log('pmessage sent')
                  this.activeFriend=e.message.user_id;
                  this.allMessages.push(e.message)
                  setTimeout(this.scrollToEnd,100);

              })
              .listenForWhisper('typing', (e) => {

                  if(e.user.id==this.activeFriend){

                      this.typingFriend=e.user;
                      
                    if(this.typingClock) clearTimeout();

                      this.typingClock=setTimeout(()=>{
                                            this.typingFriend={};
                                        },9000);
                  }


                 
            });

    }
    
  }
</script>

<style scoped>

.online-users,.messages{
  overflow-y:scroll;
  height:70vh;
  background-color: #fff;
}
.messages{
  padding-bottom: 25px;
}
.footerdiv{
  display: flex;
  height: 113px;
  align-items: center;
  justify-content: center;
}
.activemate{
background-color: #a3a3a34a;
}

</style>
