<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Validator;
use Helper;

class SupportController extends BaseController
{
    
    /**
    * index
    *
    * @return void
    */
    public function index(Request $request, $id = null)
    {
        $message = Helper::query("ChatMessage", "find", ["id" => $id]);
        if ( $request->isMethod("post") ) {
            $this->validate($request, ["message" => "required"]);
            $s_user = $request->user();
            $inputs = $request->all();            
            $inputs["parent_id"] = $message->id;
            $inputs["user_id"] = $s_user->id;
            $inputs["author"] = $s_user->name;
            $inputs["chat_user_id"] = $message->chat_user_id;
            //$inputs["viewed"] = 1;
            
            Helper::query("ChatMessage", "save", [
                "inputs"    =>  $inputs,
            ]);
            
            session()->flash("flashmessage", null);
            return redirect()->back();
        }
        if ( $message->id ) $message->update(["viewed" => 1]);
        $responses = Helper::query("ChatMessage", "where", ["field" => "parent_id", "value" => $id])->get();
        return view("admin.support.index", compact("message", "responses"));
    }
    
}