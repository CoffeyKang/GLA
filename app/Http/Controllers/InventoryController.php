<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventory;
use Illuminate\Pagination\Paginator;
use App\Inventory_img;
use App\FeatureProduct;
class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inventory::all()->take(2);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * display products_list
     * @param  make $data [description]
     * @return [type]       [description]
     */
    public function product_list($make,$mycurrentPage){
        
        Paginator::currentPageResolver(function () use ($mycurrentPage) {
            return $mycurrentPage;
        });
        $product_list = Inventory::
        join('inventory_img','inventory.item','inventory_img.item')->
        where('make',$make)->paginate(20) ;

        foreach ($product_list as $item) {
            if (file_exists(public_path().$item->img_path)) {
                
            }else{
                $item->img_path = "/images/default_sm.jpg";
            }
            
        }
        
        return $product_list;
    }

    /**
     * get a single item with img path
     * @param  [type] $item [description]
     * @return [type]       [description]
     */
    public function singleItem($item){
        $singleItem = Inventory::where('item',$item)->first();
        $singleItem->img_path = Inventory_img::where('item',$item)->first()->img_path;
        
        if (file_exists(public_path().$singleItem->img_path)) {
                
            }else{
                $singleItem->img_path = "/images/default_bg.jpg";
        }

        $single = $singleItem->toArray();
        return $singleItem;
    }

    public function related($item){
        
        $make = Inventory::where('item',$item)->first()->make;
        $related = Inventory::where('item','!=',$item)->where('make',$make)->inRandomOrder()->take(4)->get();
        
        foreach ($related as $r) {
            $r->img_path = Inventory_img::where('item',$r->item)->first()->img_path;
        }

        foreach ($related as $item) {
            $item->checkImgExists();
        }

        return $related;
    }

    /**
     * get feature products
     * @param  [type] $item [description]
     * @return [type]       [description]
     */
    public function featureProducts(){
        $features = FeatureProduct::inRandomOrder()->take(4)->get();
        $resualt = [];
        foreach ($features as $f) {
            array_push($resualt, $f->itemDetails()->first());
        }

        foreach ($resualt as $item) {
            $item->img_path = $item->itemImg()->first()->img_path;
            $item->checkImgExists();
        }   

        

        

        return $resualt;
    }


    public function popularProducts(){
        $popuar = Inventory_img::orderBy('viewed','aesc')->take(4)->get();

        $resault = collect();
        foreach ($popuar as $p) {
            $item_details = $p->itemDtails()->get();
            $resault = $resault->merge($item_details);
        }
        foreach ($resault as $r) {
            $item = $r->itemImg()->first();

            if ($item&&file_exists(public_path().$item->img_path)) {
                $r->img_path = $item->img_path;
            }else{
                $r->img_path = "/images/default_bg.jpg";
            }

        }
        return $resault;
    }

    public function searchResualt(Request $request){
        $item = $request->item?$request->item:'item';
        $make = $request->make?$request->make:'make';
        $year = $request->year?$request->year:'year';
        $desc = $request->desc?$request->desc:'desc';
        $page = $request->page?$request->page:1;
        
        if ($item != 'item') {
            $oneItem = Inventory::where('item',$item)->first();
            if ($oneItem) {
                $oneItem = $oneItem->itemFullInfo();
                return "itemFound";
            }else{
                
                $mycurrentPage = $page;
                Paginator::currentPageResolver(function () use ($mycurrentPage) {
                    return $mycurrentPage;
                });

                $items = Inventory::where('item','!=','fei');
                /** make */
                if ($make!='make') {
                    $items = $items->where('make',$make);
                }else{

                }

                /** year */
                if ($year!='year' && is_numeric($year) ) {
                    
                    $items = $items->where('year_from','<=',$year)->where('year_end','>=',$year);
                        // ->join('inventory_img','inventory.item','inventory_img.item')->paginate(20); 
                    
                }else{
                    
                }

                /** desc */
                if ($desc!='desc') {
                    $items = $items->where('descrip','LIKE',"%".$desc."%");
                }else{
                    
                }

                $items=$items->paginate(20);
                
                return $items;
                 
            }
            
        }else{
            $mycurrentPage = $page;
            Paginator::currentPageResolver(function () use ($mycurrentPage) {
                return $mycurrentPage;
            });

            $items = Inventory::orderBy('item','asc');
            /** make */
            if ($make!='make') {
                
                $items = $items->where('make',$make);
                    // ->join('inventory_img','inventory.item','inventory_img.item')->paginate(20);

            }else{

            }

            /** year */
            if ($year!='year' && is_numeric($year) ) {
                
                $items = $items->where('year_from','<=',$year)->where('year_end','>=',$year);
                    // ->join('inventory_img','inventory.item','inventory_img.item')->paginate(20); 
                
            }else{
                
            }

            /** desc */
            if ($desc!='disc') {
                $items = $items->where('descrip','LIKE',"%".$desc."%");
            }else{
                
            }

            $items=$items->paginate(20);

            
            return $items;
            
        }
    }
}
