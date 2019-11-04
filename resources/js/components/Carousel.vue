<template>
 <div class="father">
    <div class="caro">
        <div class="we">
            <h1>hello , We are <span>Worgens</span> social network we provide the best experience for our users</h1>
        </div>
        <div class="opa"></div>
         <a href="" @click.prevent="addActiver" class="right"><i class="fas fa-chevron-right"></i></a>
         <a href="" @click.prevent="addActivel"  class="left"><i class="fas fa-chevron-left"></i></a>
        <img :class="{posi:posi,slideoutleft:liout1,slideinleft:lin1,slideoutright:riout1,slideinright:rin1}"  :src="pics[0]" alt="">
        <img :class="{slideinleft:lin2,slideoutleft:liout2,slideoutright:riout2,slideinright:rin2}"  :src="pics[1]" alt="">
        <img :class="{slideinleft:lin3,slideoutleft:liout3,slideoutright:riout3,slideinright:rin3}"  :src="pics[2]" alt="">
    </div>
       <ul>
            <li @click="one()" :class="{active:active1}"></li>
            <li @click="two()" :class="{active:active2}"></li>
            <li @click="three()" :class="{active:active3}"></li>
       </ul>
 </div>
</template>
<style scoped>
.active{
    background-color: #ff5e3a;
}

  .caro{
        height: 500px;
        display: flex;
        align-items: center;
    }
    .opa{
     background-color: black;
    height: 500px;
    width: 100%;
    position: absolute;
    z-index: 9;
    opacity: 0.6;
    }
    .posi{
        position: absolute;
    }
    .slideinleft{
     animation: slideInLeft 1s;
     position: absolute;
    }
    .slideoutleft{
     animation: slideOutLeft 1s;
    }
.slideinright{
     animation: slideInRight 1s;
     position: absolute;
    }
 .slideoutright{
     animation: slideOutRight 1s;
    }
    .caro img{
        height: 500px;
        width: 100%;
    }
    .caro .we{
    z-index: 999;
    position: relative;
     left: 29vh;
     bottom: 3pc;
    }
    .caro .we h1{
    width: 500px;
    color: #ffffff;
    line-height: 50px;
    font-weight: bold;
    font-style: italic;
    font-size: 35px;
        
    }
    .caro .we span{
        color:#ff5e3a;
    }
    .caro .left{
        position:absolute;
        left: 0;
        margin-left: 80px;
        z-index: 9999;
    }
    .caro .right{
        position:absolute;
        right: 0;
        margin-right: 80px;
        z-index: 9999;
    }
    .caro a i{
        font-size: 50px;
        color: #ff5e3a;
    }
    ul{
        position: relative;
        bottom: 50px;
        justify-content: center;
        display: flex;
        list-style: none;
        padding-left: 0px;
        z-index: 10;
    }
    ul li{
        margin-left: 15px;
        margin-right: 15px;
        border: 2px solid #ff5e3a;
        width: 20px;
        border-radius: 50%;
        height: 20px;
        cursor: pointer;
    }
    ul li:hover{
        background-color: #ff5e3a;
        transition: all 0.5s ease-in-out;
    }
    .lipic{
        background-color: #ff5e3a;
    }
    @keyframes slideInLeft{
         0%{
             transform: translateX(-100%);
         }
         100%{
             transform: translateX(0);
              position: absolute;
         }
    }
 @keyframes slideOutLeft{
         0%{
             transform: translateX(0);
             position: absolute;
         }
         100%{
             transform: translateX(100%);
              position: absolute;
         }
    }
      @keyframes slideInRight{
         0%{
             transform: translateX(100%);
         }
         100%{
             transform: translateX(0);
              position: absolute;
         }
    }
 @keyframes slideOutRight{
         0%{
             transform: translateX(0);
             position: absolute;
         }
         100%{
             transform: translateX(-100%);
              position: absolute;
         }
    }
    @media (max-width:991px) {
    .caro .left{
        margin-left:10px ;
    }
    .caro .right{
        margin-right:10px ;
    }
}
 @media (max-width:765px) {
    .caro .we{
     left: 14vh;
    bottom: 6pc;
    }
    .caro .we h1{
    width: 423px;
    font-size: 25px;
    }
}
</style>
<script>
    export default {
        data() {
            return{
                pics:['/img/pic1.jpg','/img/pic2.png','/img/pic3.jpg'],
                index:0,
                posi:true,
                lin1:false,
                lin2:false,
                lin3:false,
                liout1:false,
                liout2:false,
                liout3:false,
                rin1:false,
                rin2:false,
                rin3:false,
                riout1:false,
                riout2:false,
                riout3:false,
                active1:true,
                active2:false,
                active3:false,
            }
        },
        methods: {
          addActiver(){
              this.posi = false;
                this.rin1 = false;
                this.rin2 = false;
                this.rin3 = false;
                this.riout1 = false;
                this.riout2 = false;
                this.riout3 = false;
            if(this.index === 0){
           
                 this.index++;
              this.active1 = false;
             this.active2 = true;
             this.active3 = false;
                this.lin1 = false;
                this.lin2 = true;
                this.lin3 = false;
                this.liout1 = true;
                this.liout2 = false;
                this.liout3 = false;
                
         
            }else if(this.index === 1){
                this.index++;
            this.active1 = false;
             this.active2 = false;
             this.active3 = true;
                this.lin1 = false;
                this.lin2 = false;
                this.lin3 = true;
                this.liout2 = true;
                this.liout3 = false;
                
      
            }else if(this.index === 2){
                this.index = 0;
                this.active1 = true;
             this.active2 = false;
             this.active3 = false;
                this.lin1 = true;
                this.lin2 = false;
                this.lin3 = false;
                this.liout1 = false;
                this.liout2 = true;
                this.liout3 = true;
            }
         },
           addActivel(){
                this.posi = false;
               this.lin1 = false;
                this.lin2 = false;
                this.lin3 = false;
                this.liout1 = false;
                this.liout2 = false;
                this.liout3 = false;
             if(this.index === 0){
                 this.index = 2;
            this.active1 = false;
             this.active2 = false;
             this.active3 = true;
                this.rin1 = false;
                this.rin2 = false;
                this.rin3 = true;
                this.riout1 = true;
                this.riout2 = false;
                this.riout3 = false;
                
               
    
            }else if(this.index === 1){
                this.index--;
                this.active1 = true;
                this.active2 = false;
                this.active3 = false;
                this.rin1 = true;
                this.rin2 = false;
                this.rin3 = false;
                this.riout1 = false;
                this.riout2 = true;
                this.riout3 = false;
                 
            }else if(this.index === 2){
                this.index--;
             this.active1 = false;
             this.active2 = true;
             this.active3 = false;
                this.rin1 = false;
                this.rin2 = true;
                this.rin3 = false;
                this.riout1 = false;
                this.riout2 = false;
                this.riout3 = true;
            }
             },
        
         one(){
            
          if(this.index === 2){
               this.addActiver();
            }if(this.index === 1){
              this.addActivel();
            }
            
         },
         two(){
         
              if(this.index === 0){
                    this.addActiver();
            }if(this.index === 2){
                this.addActivel();
            }
         },
         three(){
         
                if(this.index === 0){
                    this.addActivel();
            }if(this.index === 1){
                this.addActiver();
            }
            
         }
        },
        mounted() {
            console.log('Component mounted.')
          
        },
        created(){ 
         let loop = setInterval(() =>{
          this.addActiver();
          },7000)
        },
        beforeDestroy(){
            clearInterval(this.loop);
        }
    }
</script>
