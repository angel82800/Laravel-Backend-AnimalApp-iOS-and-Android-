<?php
namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Category;
use App\Model\Animal;
use App\Model\Organization;
use App\Model\Favourite;
use App\Mail\MailSender;

use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\Mail;

class AnimalAdmin extends Controller
{
    use DispatchesJobs, ValidatesRequests;
    public function __construct() {
        header("Content-type:application/json");
        app()->setLocale('en');
    }

    public function index(){
        return view('dashboard.dashboard')->with("select","dashboard");
    }

    public function user(Request $request){
        $val = $request->session()->get('user');
        $send_data = array();
        $organization = array();
        switch ($val['role']){
            case 2:
                $result = User::all();
                foreach ($result as $item){
                    $result1 = Organization::where('oid',$item->oid)->get();
                    if($result1 != null && count($result1) != 0)
                        $item['organization_name'] = $result1[0]->organization_name;
                    else
                        array_push($send_data,$item);
                }
                $organization = Organization::all();
                //var_dump($organization);exit;
                break;
            case 1:
                $result = User::where('uid',$val['uid'])->get();
                //foreach ($result as $item){
                    $result[0]['organization'] = Organization::where('oid',$result[0]->oid)->get();

                    $send_data = $result;
                //}
                break;
            default:
                $result = User::where('uid',$val['uid'])->get();
                $send_data = $result;
                break;
        }
        return view('user.user')->with("select","account")->with('data',$send_data)->with("organization",$organization);
    }

    public function animalList(){
        $arr = array();
        $list = Animal::all();
        $kind = Category::all();
        foreach ($list as $key){
            $key['kind'] = $key->getCategory->kind;
            array_push($arr,$key);
        }
        //var_dump($arr);exit;
        return view("animalList.animalList")->with("select","list")->with("list",$arr)->with("kind",$kind);
    }
    
    public function animalNew(){
        $kind = array();
        $kind = Category::all();
        return view("animalNew.animalNew")->with("select","new")->with("kind",$kind);
    }

    public function add_animal(Request $request){
        $name = $request->input("name");
        $color = $request->input("color");//
        $gender = $request->input("gender");//
        $size = $request->input("size");//
        $age = $request->input("age");//
        $infoEn = $request->input("infoEn");
        $infoNe = $request->input("infoNe");
        $infoPa = $request->input("infoPa");
//        $photo_url = $request->input("photo_url");
        $image = $request->file("image");
        $cid = $request->input("cid");//
        $status = $request->input("status");
        $img_name = "";
        if($image != null){
            $img_name=time().'_'.$image->getClientOriginalName();
            $image->move(realpath(base_path('public/uploads/')),$img_name);
        }


        $animal = new Animal();
        $animal->name = $name;
        $animal->color = $color;
        $animal->gender = $gender;
        $animal->size = $size;
        $animal->age = $age;
        $animal->infoEn = $infoEn;
        $animal->infoNe = $infoNe;
        $animal->infoPa = $infoPa;
        $animal->photo_url = $img_name;
        $animal->cid = (int)$cid;
        $animal->uid = (int)$request->session()->get("user")['uid'];
        $animal->status = $status;
        $animal->save();

        return redirect('/animalList');
    }

    public function del_animal(Request $request){
        $aid = $request->input('id');
        $result = Animal::where("aid",$aid)->delete();
        echo $result;
    }

    public function edit_animal(Request $request){
        $aid = $request->input("aid");//
        $name = $request->input("name");//
        $color = $request->input("color");//
        $gender = $request->input("gender");//
        $size = $request->input("size");//
        $age = $request->input("age");//
        $infoEn = $request->input("infoEn");
        $infoNe = $request->input("infoNe");
        $infoPa = $request->input("infoPa");
//        $photo_url = $request->input("photo_url");
        $image = $request->file("image");
        $cid = $request->input("cid");//
        $status = $request->input("status");

        if($image == null)
            $img_name = $request->input("photo");
        else{
            $img_name=time().'_'.$image->getClientOriginalName();
            $image->move(realpath(base_path('public/uploads/')),$img_name);
        }

        $result = Animal::where("aid",$aid)->update(["name"=>$name,"color"=>$color,"gender"=>$gender,"size"=>$size,"age"=>$age,"infoEn"=>$infoEn,"infoNe"=>$infoNe,"infoPa"=>$infoPa,"photo_url"=>$img_name,"cid"=>$cid,"status"=>$status,"uid"=>$request->session()->get('user')['uid']]);
        return redirect('/animalList');
    }

    public function signup(Request $request){
        $name = $request->input("name");
        $email = $request->input("email");
        $password = $request->input("password");
        $location = $request->input("location");
        $result1 = User::where('email',$email)->get();
        if(count($result1) != 0) {
//        $this->validate($request, [
//            'name' => 'required|unique:posts|max:255',
            return redirect('/');
        }
//        $validator->errors()->add('error', 'Email is registered already.');
//        return $validator->errors()->all();
        $user = new User();
        $user->username = $name;
        $user->email = $email;
        $user->password = $password;
        $user->location = $location;
        $user->save();

        $result = User::where([['email',$email],["password",$password]])->get();
        if($result != null && count($result) != 0){
            $value = array("uid"=>$result[0]->uid,"role"=>$result[0]->role);
            $request->session()->put("user",$value);
            return redirect('/animalList');
        }else{
            return redirect('/');
        }
    }

    public function login(Request $request){
        $email = $request->input("email");
        $password = $request->input("password");
        $result = User::where([["email",$email],["password",$password]])->get();
        if($result == null){
            return redirect('/');
        }else{
            if(count($result)!=0){
                $value = array("uid"=>$result[0]->uid,"role"=>$result[0]->role);
                $request->session()->put("user",$value);
                return redirect('/animalList');
            }else{
                return redirect("/");
            }
        }
    }

    public function edit_account(Request $request){
        $uid = $request->input("uid");
        $username = $request->input('username');
        $location = $request->input('location');
        $email = $request->input('email');

        User::where('uid',$uid)->update(["username"=>$username,"location"=>$location,"email"=>$email]);
        return redirect('/user');
    }

    public function del_user(Request $request){
        $uid = $request->input("id");
        $result = User::where("uid",$uid)->delete();
        echo $result;
    }
}