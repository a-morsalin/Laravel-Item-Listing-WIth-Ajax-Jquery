<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ListController extends Controller
{
	public function index(){
		$items = Item::all();
		return view('list', compact('items'));
	}    

	public function create(Request $request){

		$item = new Item;
		$item->item = $request->text;
		$item->save();
		return"Done";
    	//return $request->all();
	}

	public function delete(Request $request){
		Item::where('id', $request->id)->delete();
		return $request->all();
	}

	public function update(Request $request){
		$item = Item::find($request->id);
		$item->item = $request->updateItem;
		$item->save();
		return $request->all();
	}

	public function search(Request $request){

    	$term = $request->term;
    	$items = Item::where('item','LIKE','%'.$term.'%')->get();
    	if(count($items) == 0){
    		$searchResult[]="No Item Found";
    	}else{
    		foreach ($items as $key=>$value) {
    			$searchResult[]=$value->item;
    		}
    	}
		return $searchResult;
	}
}
