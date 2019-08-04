<?php

namespace App\Http\Controllers\Country;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CountryModel;
use Validator;

class CountryController extends Controller
{
    public function country(){
        return response()->json(CountryModel::get(), 200);
        }

    public function countryByID($id){
        $country = CountryModel::find($id);
        if(is_null($country)){
            return response()->json(["message"=>'Record not found!'], 404);
        }
        return response()->json(CountryModel::findOrFail($id), 200);
    }

    public function countrySave(Request $request){
        $validate = Validator::make($request->all(), $this->validateRequest());
        if($validate->fails()){
        return response()->json($validate->errors(), 400);
    }
        $country = CountryModel::create($request->all());
       return response()->json($country, 201);
    }

    public function countryUpdate(Request $request, $id){
        $country = CountryModel::find($id);
        if(is_null($country)){
            return response()->json(["message"=>'Record not found!'], 404);
        }
        $validate = Validator::make($request->all(), $this->validateRequest());
        if($validate->fails()){
        return response()->json($validate->errors(), 400);
        }
        $country->update($request->all());
        return response()->json($country, 201);
     }
     public function countryDelete(Request $request, $id){
        $country = CountryModel::find($id);
        if(is_null($country)){
            return response()->json(["message"=>'Record not found!'], 404);
        }
        $country->delete($request->all());
        return response()->json(null, 204);
     }
     public function validateRequest(){
        return [
            'name' => 'required|min:3',
            'dname' => 'required|min:3',
            'iso' => 'required|min:2|max:2',
        ];
    }
}
