<template>
	<div class='container' id='car_makes'>
		<div class="title">
			<span>All Products</span>
		</div>
		<div class='car_make col-xs-12 col-sm-3' v-for='make in makes' :key="make.make">
			<router-link :to="{
				name:'Pruduct_list', 
				query:{ make: make.make }
				}" tag='a'>
				<div class="car_img" v-if='make.path!="default"' 
					:style="{ backgroundImage: 'url(' + make.path + ')' }"
				>
					<!-- <img :src="make.path" alt="123 " draggable='false'> -->
				</div>

				<div class="car_img" v-if=' make.path == "default"' :style="{ backgroundImage: 'url(/images/makes/default.png)' }">
					<!-- <img src="/images/makes/default.jpg" alt="2"> -->
				</div>

				<button class="btn btn-block viewOnline" v-if="make.make!='MONTECARLO'">
					{{ make.make.toUpperCase().replace("_"," " ) }}
				</button>

				<button class="btn btn-block viewOnline" v-if="make.make=='MONTECARLO'">
					MONTE CARLO
				</button>
				
			</router-link>
			
		</div>

		
		
		
	</div>
</template>
<script>
	export default {
		data (){
			return {
				makes : this.makes,
				loading:1,
				
			}
		},
		mounted(){
			this.$http.get('/api/makes').then(response => {
			    // get body data
			    this.makes = response.body;

			    this.loading = 0;
			    
			  }, response => {
			  	// error 
			     
			  });
		},
		methods:{
			m(){
				$(this).css('background-color','#FFE512;');
				
			}
		}
	}
</script>
<style scoped>

a, a:hover{
	text-decoration:none;
}
a:hover{
	font-weight: bold;
}
	#car_makes{
		
		margin-bottom: 40px;
	}
	.car_make{
		margin-top: 30px;
		
	}
	.car_make_name{
		color: black;
		font-size: 1.4em;
	}
	.car_img{
		height: 230px;
		background-position: center;
		background-size: contain;
		background-repeat: no-repeat;
		
	}
	.car_img img{
		height: 70px;
		width: 140px;
	}
	.blue{
		background-color: blue;
	}
	.viewOnline{
		background-color: black;
		color: white;
		font-size: 20px;
	}

	.title{
		margin-top: 10px;
		background-color: black;
		padding: 5px 20px;

	}
	.title span{
		font-size: 20px;
		color: white;
		font-weight: bold;
	}
</style>