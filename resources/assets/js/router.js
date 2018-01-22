import Home from './components/body/Home.vue'
import Contact from './components/body/Contact.vue'
import Special from './components/body/Special.vue'
import Catalog from './components/body/Catalog.vue'
import Products from './components/body/Products.vue'
import Ccbd from './components/body/Ccbd.vue'
import Product_list from './components/body/Product_list.vue'
import ItemDetails from './components/body/ItemDetails.vue'
import SearchResualt from './components/body/SearchResualt.vue'
import PageNotFound from './components/body/PageNotFound.vue'


export const routes =[
	{path:'/',component:Home,name:'home'},
	{path:'/contact',component:Contact},
	{path:'/special',component:Special},
	{path:'/Catalog',component:Catalog},
	{path:'/allProducts',component:Products},
	{path:'/classicBody',component:Ccbd},
	{path:'/Product_list',component:Product_list, name:'Pruduct_list'},
	{path:'/SearchResualt',component:SearchResualt, name:'SearchResualt'},
	{path:'/Item/:id',component:ItemDetails, name:'ItemDetails'},
	{ path: "*", component: PageNotFound },

];