<?php
namespace App\Http\Controllers;

use App\Model\User;
use App\Model\Category;
use App\Model\Animal;
use App\Model\Favourite;
use App\Mail\MailSender;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AnimalBack extends Controller
{
    public function __construct() {
        header("Content-type:application/json");
        app()->setLocale('en');
    }

    public function signup(Request $request){

        $result1 = Animal::favourite();
        $result = $result1->where('animal.aid','1')->get();
        //Animal::where('aid',1)->favourite->delete();
        var_dump($result);exit;
//        $username = $request->input('username');
//        $email = $request->input('email');
//        $password = $request->input('password');
//        $location = $request->input('location');
//
//        $result = User::where("email",$email)->get();
//        if($result == null){
//            $send_result = array("success"=>0,"error"=>__('back.connectError'),"data"=>"");
//        }else{
//            if(count($result) == 0){
//                $user = new User();
//                $user->username = $username;
//                $user->email = $email;
//                $user->password = $password;
//                $user->location = $location;
//                $user->save();
////                User('user')->insert(["username"=>$username,"email"=>$email,"password"=>$password,"location"=>$location]);
//                $result1 = User::where('email',$email)->get();
//                $send_result = array("success"=>1,"error"=>"","data"=>array("uid" => $result1[0]->uid));
//            }else{
//                $send_result = array("success"=>1,"error"=>__('back.userError'),"data"=>"");
//            }
//        }
//        echo json_encode($send_result);
    }

    public function login(Request $request){
        $email = $request->input('email');
        $password = $request->input("password");
        $result = User::where([['email',$email],['password',$password]])->get();
        if($result == null){
            $send_result = array("success"=>0,"error"=>__('back.connectError'),"data"=>"");
        }else{
            if(count($result) != 0){
                $send_result = array("success"=>1,"error"=>"","data"=>array("uid" => $result[0]->uid));
            }else{
                $send_result = array("success"=>1,"error"=>__('back.loginError'),"data"=>"");
            }
        }
        echo json_encode($send_result);
    }

    public function edit_profile(Request $request){
        $uid = $request->input("uid");
        $location = $request->input("location");

        $result = User::where("uid",$uid);

        if($result == null){
            $send_result = array("success"=>0,"error"=>__('back.connectError'),"data"=>"");
        }else{
            $result->update(['location'=>$location]);
            $send_result = array("success"=>1,"error"=>"","data"=>"");
        }
        echo json_encode($send_result);
    }

    public function get_category_list(Request $request){
        $uid = $request->input("uid");
        $result = Category::all();
        if($result == null){
            $send_result = array("success"=>0,"error"=>__('back.connectError'),"data"=>"");
        }else{
            if(count($result) != 0){
                $arr = array();
                foreach($result as $item){
                    array_push($arr,array("cid"=>$item->cid,"kind"=>$item->kind ));
                }
                $send_result = array("success"=>1,"error"=>"","data"=>$arr);
            }else{
                $send_result = array("success"=>1,"error"=>__('back.categoryError'),"data"=>"");
            }
        }
        echo json_encode($send_result);
    }

    public function set_favourite(Request $request){
        $uid = $request->input("uid");
        $aid = $request->input("aid");

        $result = Favourite::where([["uid",$uid],["aid",$aid]])->get();
        if($result == null){
            $send_result = array("success"=>0,"error"=>__('back.connectError'),"data"=>"");
        }else{
            //$result1 = DB::table('favourite')->insert(["uid"=>$uid,"aid"=>$aid]);
            $result1 = new Favourite();
            $result1->uid = $uid;
            $result1->aid = $aid;
            $result1->save();

            $send_result = array("success"=>1,"error"=>"","data"=>"");
        }
        echo json_encode($send_result);
    }

    public function del_favourite(Request $request){
        $uid = $request->input("uid");
        $aid = $request->input("aid");

        $result = Favourite::where([["uid",$uid],["aid",$aid]]);
        if($result == null){
            $send_result = array("success"=>0,"error"=>__('back.connectError'),"data"=>"");
        }else{
            $result1 = Favourite::where([["uid",$uid],["aid",$aid]]);
            $result1->delete();
            $send_result = array("success"=>1,"error"=>"","data"=>"");
        }
        echo json_encode($send_result);
    }

    public function get_favourite(Request $request){
        $uid = $request->input("uid");

        $result = Favourite::where("uid",$uid)->get();
        if($result == null){
            $send_result = array("success"=>0,"error"=>__('back.connectError'),"data"=>"");
        }else{
            if(count($result) != 0){
                $arr = array();
                foreach ($result as $item){
                    $result1 = Animal::where("aid",$item->aid)->toArray();
                    array_push($arr,$result1);
                }
                $send_result = array("success"=>1,"error"=>"","data"=>$arr);
            }else{
                $send_result = array("success"=>1,"error"=>__("back.favouriteError"),"data"=>"");
            }
        }
        echo json_encode($send_result);
    }

    public function logout(Request $request){
        $uid = $request->input("uid");
        echo json_encode(array("success"=>1,"error"=>"","data"=>""));
    }

    public function forget_pwd(Request $request){
        $uid = $request->input("uid");
        $email = $request->input("mail");
        $result = User::where('email',$email)->get();
        if($result == null){
            $send_result = array("success"=>0,"error"=>__('back.connectError'),"data"=>"");
        }else{
            if(count($result) != 0){
                $data = array("name"=>$result[0]->name,"pass"=>$result[0]->password);
                Mail::to($email)->send(new MailSender($data));
                $send_result = array("success"=>1,"error"=>"","data"=>"");
            }else{
                $send_result = array("success"=>1,"error"=>__('back.loginError'),"data"=>"");
            }
        }
        echo json_encode($send_result);
    }

    public function get_animals(Request $request){//Array
        $cids = $request->input("cid");
        $arr = array();
        $arr = json_decode($cids);
        $whereQuery = array();

        $result1 = array();
        $val = 0;
        foreach ($arr as $key){
            if($val == 0){
                $result1 = Animal::orWhere("cid",$key);
                $val++;
            }
            else{
                $result1 = $result1->orWhere("cid",$key);
                $val ++;
            }
        }
        $result = $result1->get();
        if($result == null){
            $send_result = array("success"=>0,"error"=>__('back.connectError'),"data"=>"");
        }else{
            if(count($result) != 0){
                $send_result = array("success"=>1,"error"=>"","data"=>$result);
            }else{
                $send_result = array("success"=>1,"error"=>__('back.animalError'),"data"=>"");
            }
        }
        echo json_encode($send_result);
    }

    public function add_animal(Request $request){
        $name = $request->input("name");
        $color = $request->input("color");
        $gender = $request->input("gender");
        $size = $request->input("size");
        $age = $request->input("age");
        $infoEn = $request->input("infoEn");
        $infoNe = $request->input("infoNl");
        $infoPa = $request->input("infoPa");
//        $photo_url = $request->input("photo_url");
        $image = $request->file("photo");
        $cid = $request->input("cid");
        $status = $request->input("status");
        $uid = $request->input("uid");
        //echo json_encode("tets");
        $img_name = "";
        if($image != null){
            $img_name=time().".jpg";
            $image->move(realpath(base_path('public/uploads/')),$img_name);
        }



        $animal = new Animal();
        $animal->name = $name;
        $animal->color = $color;
        $animal->gender = $gender;
        $animal->size = $size;
        $animal->age = $age;
        if($infoEn != null)
            $animal->infoEn = $infoEn;
        else
            $animal->infoEn = "";
        if($infoNe != null)
            $animal->infoNe = $infoNe;
        else
            $animal->infoNe = "";
        if($infoPa != null)
            $animal->infoPa = $infoPa;
        else
            $animal->infoPa = "";
        $animal->photo_url = $img_name;
        $animal->cid = $cid;
        $animal->status = $status;
        $animal->uid = $uid;
//
       // $send_result = array("success"=>1,"error"=>"dddjdjdjdjdjd","data"=>$animal);
       // echo json_encode($send_result);exit;


        $animal->save();
        $send_result = array("success"=>1,"error"=>"","data"=>"");
        echo json_encode($send_result);
    }

    public function update_animal(Request $request){
        $aid = $request->input("aid");
        $name = $request->input("name");
        $color = $request->input("color");
        $gender = $request->input("gender");
        $size = $request->input("size");
        $age = $request->input("age");
        $infoEn = $request->input("infoEn");
        $infoNe = $request->input("infoNl");
        $infoPa = $request->input("infoPa");
//        $photo_url = $request->input("photo_url");
        $image = $request->file("photo");
        $cid = $request->input("cid");
        $uid = $request->input("uid");
        $status = $request->input("status");

        $img_name=time().'_'.".jpg";
        $image->move(realpath(base_path('public/uploads/')),$img_name);

        $result = Animal::where("aid",$aid);
        if($result == null){
            $send_result = array("success"=>0,"error"=>__('back.connectError'),"data"=>"");
        }else{
            if(count($result) != 0){
                $result->update(["name"=>$name,"color"=>$color,"gender"=>$gender,"size"=>$size,"age"=>$age,"infoEn"=>$infoEn,"infoNe"=>$infoNe,"infoPa"=>$infoPa,"photo_url"=>$img_name,"cid"=>$cid,"status"=>$status,"uid"=>$uid]);
                $send_result = array("success"=>1,"error"=>"","data"=>"");
            }else{
                $send_result = array("success"=>1,"error"=>__('back.updateAnimalError'),"data"=>"");
            }
        }
        echo json_encode($send_result);
    }

    public function del_animal(Request $request){
        $aid = $request->input("aid");
        $result = Animal::where("aid",$aid);
        if($result == null){
            $send_result = array("success"=>0,"error"=>__('back.connectError'),"data"=>"");
        }else{
            if(count($result) != 0){
                $result->delete();
                $send_result = array("success"=>1,"error"=>"","data"=>"");
            }else{
                $send_result = array("success"=>1,"error"=>__('back.deleteAnimalError'),"data"=>"");
            }
        }
        echo json_encode($send_result);
    }
}