<template>
	<div class='container'>
        <div class='searchBar'>
            <app-search ></app-search>
        </div>
        
        <div class="btnBar mobile_no">
            <span class='mobile_no'><button class="btn btn-primary" @click='previousPage()'>Previous Page</button></span>
            <span class='mobile_no'>
                <!-- <el-input v-model='num' id='numInput' style='width:60px;'></el-input> -->
                 <el-select v-model="num" placeholder="Change Page" style='width:100px;'>
						<el-option
							v-for="p in total"
							:key="p"
							:label="displayLabel(p,cover)"
							:value="p">
						</el-option>
					</el-select> / <el-input :value='total-cover' style='width:100px; ' readonly="readonly"></el-input>
            </span>
            <span class='mobile_no'><button class="btn btn-primary" @click='nextPage()'>Next Page</button></span>
        </div>

        <div class="btnBar mobile_show btnBar_mobile" >
            <br>
            <span><button class="btn btn-primary" @click='previousPage()'>Previous</button></span>
            <span>
                <!-- <el-input v-model='num' id='numInput' style='width:60px;'></el-input> -->
                 <el-select v-model="num" placeholder="Change Page" style='width:100px;'>
						<el-option
							v-for="p in total"
							:key="p"
							:label="displayLabel(p,cover)"
							:value="p">
						</el-option>
					</el-select> 
                    
            </span>
            <span><button class="btn btn-primary" @click='nextPage()'>Next</button></span>
        </div>

        <div class="viewOnline">
            <img :src="page" alt="" style='width:100%' @click='nextPage()'>
        </div>

        <div class='searchBar mobile_no'>
            <app-search ></app-search>
        </div>
        <div class="btnBar mobile_no">
            <span class='mobile_no'><button class="btn btn-primary" @click='previousPage()'>Previous Page</button></span>
            <span class='mobile_no'>
                <!-- <el-input v-model='num' id='numInput' style='width:60px;'></el-input>
                 -->
                 <el-select v-model="num" placeholder="Change Page" style='width:100px;'>
						<el-option
							v-for="p in total"
							:key="p"
							:label="displayLabel(p,cover)"
							:value="p">
						</el-option>
					</el-select>
                 / <el-input :value='total-cover' style='width:100px; ' readonly="readonly"></el-input>
            </span>
            <span class='mobile_no'><button class="btn btn-primary" @click='nextPage()'>Next Page</button></span>
        </div>

        <div class="btnBar mobile_show btnBar_mobile" >
            <br>
            <span><button class="btn btn-primary" @click='previousPage()'>Previous</button></span>
            <span>
                <!-- <el-input v-model='num' id='numInput' style='width:60px;'></el-input> -->
                 <el-select v-model="num" placeholder="Change Page" style='width:100px;'>
						<el-option
							v-for="p in total"
							:key="p"
							:label="displayLabel(p,cover)"
							:value="p">
						</el-option>
					</el-select> 
                    
            </span>
            <span><button class="btn btn-primary" @click='nextPage()'>Next</button></span>
        </div>
    </div>
</template>

<script>
    import SearchBar from './SearchBar.vue';
	export default{
        data(){
            return {
                num:1,
                make:'',
                total :1,
                pic_array : [],
                cover:0,
            }
        },
        computed:{
            page(){
                if (this.num>this.total ) {
                    this.num =1;
                }else{

                }

                if (isNaN(this.num) ) {
                    this.num =1;
                    $('#numInput').val(1);
                }else{

                }

                var n = this.pic_array[this.num-1];
                // var pageNum = '/images/catalog/'+this.make+'/2018 GLA '+this.make+'Catalog_Page_'+n+'.jpg';
                return n;
            },
        
        },
        components:{
          appSearch:SearchBar
        },
        watch: {
            
        },
        methods:{
            nextPage(){
                if (this.num<this.total) {
                    this.num++;
                }else{
                    this.$message({
                        message:'This is the last page',
                        type:'warning'
                    })
                }
            },
            displayLabel(p,c){
                if (p==1) {
                    return "Cover";
                }else{}
                if (p-c <=0) {
                    return "Index";
                }else{
                    return p-c;
                }

            },
            previousPage(){
                if (this.num>1) {
                    this.num--;
                }else{
                    this.$message({
                        message:'This is the first page',
                        type:'warning'
                    })
                }
            },

           
        },
       
        mounted(){
            this.make = window.localStorage.getItem('pdf_make');
            this.$http.get('/api/getFileNumbers/'+this.make).then((response)=>{
                this.total = response.data.pageNum;
                this.pic_array = response.data.pic_array;
                this.cover = response.data.cover;
            });
        },
        
		
	}
</script>

<style scoped>
	.searchBar{
        background-color: black;
        padding: 10px 0;
    }

    .btnBar{
        margin: 10px;
        display: flex;
        justify-content: center;
        
    }

    .btnBar span{
        margin: 0 10px;
    }

    .viewOnline{
        height: 1475px;
        background-color: white;
        
    }

    .mobile_show{
        display: none;
    }

    @media screen and (max-width: 768px) {
        .viewOnline{
            height: 500px;
            background-color: white;
            
        }
        .mobile_no{
            display: none;
        }
        .mobile_show{
            display: inline;
        }
        .btnBar_mobile{
            display: flex;
            justify-content: space-between;
        }
    }
    

</style>