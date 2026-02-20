<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttributeController extends Controller
{
    public function addAttribute(){
        $order = DB::table('order')->where('status', 'pending')->count();
        return view('backend.add-attribute', ['orderRow'=>$order]);
    }

    public function addAttributeSubmit(Request $request){
        $value = $request->value;
        $check = DB::table('attribute')->where('value',$value)->get();
        if(count($check)!=0){
            return redirect('admin/add-attribute')->with('message','attribute already exists');
        }else{
            $type = $request->type;
            if($type != "" && $value !=""){
                $insert = DB::table('attribute')->insert([
                    'type' => $type,
                    'value' => $value,
                    'created_at'    => date('Y-m-d h:i:s',strtotime('+7 hours')),
                    'updated_at'    => date('Y-m-d h:i:s',strtotime('+7 hours')),
                ]);
                if($insert){
                    $lastId = $this->getLastPostId('attribute');
                    $this->logActivity('attribute',$type,$lastId,'Update');
                    return redirect('admin/list-attribute')->with('message','Insert Success');
                }else{
                    return redirect('admin/add-attribute')->with('message','Insert Fail');
                }
            }else{
                return redirect('admin/add-attribute')->with('message','Invalid Input');
            }
        }
    }
    public function  listAttribute(){
        $order = DB::table('order')->where('status', 'pending')->count();
        $attribute = DB::table('attribute')->get();
        return view('backend.list-attribute',['attribute'=>$attribute , 'orderRow'=>$order]);
    }

    public function updateAttribute($id){
        $order = DB::table('order')->where('status', 'pending')->count();
        $DbAttribute = DB::table('attribute')->where('id',$id)->first();
        return view('backend.update-attribute',['attribute'=>$DbAttribute , 'orderRow'=>$order]);
    }

    public function updateAttributeSubmit(Request $request){
        $id = $request->id;
        $value = $request->value;
        $type = $request->type;
        
        if($value){
            $exist = $this->checkExistPost('attribute','value',$value);
            if($exist){
                return redirect('admin/list-attribute')->with('message','Attribute Already exist');
            }else{
                $update = DB::table('attribute')->where('id',$id)->update([
                    'type' => $type,
                    'value' => $value,
                    'updated_at'    => date('Y-m-d h:i:s',strtotime('+7 hours')),
                ]);
                if($update){
                    $lastId = $this->getLastPostId('attribute');
                    $this->logActivity('attribute',$type,$lastId,'Update');
                    return redirect('admin/list-attribute')->with('message','Update Success');
                }else{
                    return redirect('admin/list-attribute')->with('message','Update Fail');
                }
            }
        }

       else{
                return redirect('admin/add-attribute')->with('message','Invalid Input');
            }
        
    }

    public function removeAttributeSubmit(Request $request){
        $id = $request->input('id');
        $Dblogo = DB::table('attribute')->where('id',$id)->delete();
        if($Dblogo){
            return redirect('/admin/list-attribute')->with('message','Delete Success');
        }else{
            return redirect('/admin/list-attribute')->with('message','Delete Fail');
        }
    }
}
