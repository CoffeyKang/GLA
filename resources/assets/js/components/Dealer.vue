<template>
    <div class='container loginPage' @keyup.enter="loginDealer()">
        <div v-if="!loginStatus||customerLogin">

        
            <div class="col-sm-8 col-sm-offset-2 text-center" id='loginDev'>
                <div class="text-center container-fluid" id='loginForm'>
                    <div class='title'>Dealer Login</div>
                    <div class="col-sm-8 col-sm-offset-2 form-group">
                        <input type="text" placeholder="Account" class="form-control" v-model='account'>
                    </div>
                    <div class="col-sm-8 col-sm-offset-2 form-group">
                        <input type="password" placeholder="Password" class="form-control" v-model='password'>
                    </div>
                    <div class="col-sm-8 col-sm-offset-2 form-group">
                        <button class="btn btn-primary col-sm-12" id='loginBtn' @click="loginDealer()">Login</button>
                    </div>
                    <div class="col-sm-8 col-sm-offset-2 form-group remeber">
                        <div>
                            <span class='forgetPassword'>If you require or have forgotten your dealer login information, please contact us at 905-850-3433.</span>
                        </div>
                    </div>
                </div>
                
            </div>
            
            
        </div>

        <div v-if="loginStatus && !customerLogin">
            <div class='containe adminMain adminPage' >
            <div class="userNav">
                <div class="list-group">
                    <router-link to='/Dealer/HomePage' tag='a' class="list-group-item">My Account </router-link>
                    <router-link to='/Dealer/HistoryOrder' tag='a' class="list-group-item">Order History<span v-if="orderHistory" class='num'> ({{orderHistory.length}})</span></router-link>
                    <!-- <router-link to='/Dealer/PendingOrder' tag='a' class="list-group-item">Pending Order<span v-if="orderHistory" class='num'> ({{pending.length}})</span></router-link> -->
                    <router-link to='/Dealer/DealerInquiry' tag='a' class="list-group-item">Submit Inquiry</router-link>
                    <a @click="priceSheet()" class='list-group-item' style='cursor:pointer'>Download Price Sheet 
                        <br><small>AS of {{yesterDay}}</small></a>
                    <router-link to='/Dealer/ChangePassword' tag='a' class="list-group-item">Change Password </router-link>
                </div>
            </div>
            <div class="userContent">
                <router-view></router-view>  
            </div>
        </div>
        </div>
        
    </div>
</template>


<script>
export default {
    data(){
        return {
            account:'',
            password:'',
            storage:window.localStorage,
            customerLogin:false,
            orderHistory:[],
            pending:[],
        }
    },
    mounted(){
        
        let user = JSON.parse(this.storage.getItem('user'));
        if (user) {
            if (user.level!=2) {
            
                this.$message({
                    showClose: true,
                    message: 'Dealer Area.',
                    type: 'error',
                    duration:5000
                });

                this.customerLogin = true;
                
                
            }else{
                this.dealerOrderHistory();
            }
        }else{
            
        }
        
    },


    computed:{
        loginStatus(){
            return this.$store.state.loginStatus;
        },
        yesterDay(){
           var date = new Date();
            date.setDate(date.getDate()-1);
            return  date.getFullYear() + '-'  + (date.getMonth()+1) + '-' + date.getDate() ;
        }
    },
    methods:{
        loginDealer(){
            
            this.$http.post('/api/loginDealer', {account: this.account, password:this.password}).then(
                (response)=>{
                    
                let user = response.data.dealer;

                let userInfo = response.data.dealerInfo;

                user.level = 2;

                this.storage.setItem('user',JSON.stringify(user));

                this.storage.setItem('userInfo',JSON.stringify(userInfo));

                var timeStamp = new Date();
                this.storage.setItem('timeStamp',timeStamp.getTime());
                
                let userData = JSON.parse(this.storage.getItem('user'));
                
                this.$store.commit('changeLoginStatus',true);

                this.$store.commit('usdPrice',false);


                if (this.storage.getItem('user')) {
                        this.user = JSON.parse(this.storage.getItem('user'));
                        let cust_id = this.user.id;

                        this.$http.get('/api/getShortlist_dealer/'+cust_id).then((response)=>{
                            let oldShortlist = response.data.oldShortlist;
                            
                            oldShortlist.forEach(element => {
                                let item = element.item;
                                let quantity = element.qty;
                                if (window.localStorage.getItem(item)) {
                                    // var qty = parseInt(window.localStorage.getItem(item)) + quantity;
                                    // window.localStorage.setItem(item,qty);
                                }else{
                                    window.localStorage.setItem(item,quantity);
                                    
                                    var newNumber = this.carts_number+1;
                                    
                                    this.$store.commit('carts_number',newNumber);

                                }


                            });

                        });

                        this.$http.get('/api/deleteShortlist/'+cust_id).then((response=>{
                            if (response.data.deleteOldShortlist=='deletedOld') {
                            }else{

                            }
                        }));
                    }else{
                    }
                

                
                    
                this.$router.push({path:'/'});
                    
                    
                }).catch(function(response){
                    // Your account or password was entered incorrectly.
                    if(response.status === 401) {
                        this.$message({
                            showClose: true,
                            message: 'Your account or password was entered incorrectly.',
                            type: 'error',
                            duration:5000
                        });
                    
                    }
                
                });

        },

        priceSheet(){
            var PPlan = JSON.parse(this.storage.getItem('userInfo'));
            if (PPlan) {
                var price = PPlan.pricecode;
            }
            if (price==1) {
                price=1;
            }else{}

            window.open('https://is.goldenleafautomotive.com/Excel/'+price+ '/InventoryExcelPrice.xls');
        }
        
    }
}
</script>


<style scoped>
    small{
        color: red;
    }

    .title{
        font-size: 28px;
        font-weight: bold;
        line-height: 40px;
        padding-bottom:30px;
    }
    #loginDev, #registerDev{
        margin-bottom:50px;
        margin-top: 50px;
        display: flex;
        align-items: center;
    }
    

     
    p{
        padding:0 50px;
        min-height:85px;
        padding-bottom: 15px;
    }

    .remeber{
        display: flex;
        justify-content: space-between;
    }
    
    @media screen and (min-width:768px){
        

        #loginDev, #registerDev{
            min-height:400px;
        }

        #registerForm{
            min-height: 260px;
        }

        .adminMain{
            padding: 0;
            display: flex;
            justify-content: space-between;
        }
        .adminPage{
        margin: 30px 0;
        }
        .adminPage{
            display: flex;
        }
        .userNav{
            width: 20%;
            font-size: 20px;
        }
        .userContent{
            width: 75%;
        }
        .userNav{
            background-color: black;
            border-radius: 10px;
            display: flex;
            flex-direction: column;
            padding: 30px 0;
            
        }
        
        .list-group,.list-group-item{
            color: white;
            background-color: black;
            border-color: black;
        }
        .inRow{
            display: flex;
            justify-content: space-between;
        }
        .num{
            font-weight: bold;
            color: red;
        }
    }

    @media screen and (max-width:768px){
        #loginDev{
            border-bottom: 1px solid black;
        }

        .loginPage{
            min-height: 750px;
        }

    }
    
</style>

