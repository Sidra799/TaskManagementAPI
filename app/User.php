<?php

namespace App;
use GuzzleHttp\Psr7\Request;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'parent', 'designation', 'status', 'token_id', 'activationcode', 'id', 'type', 'passwordToken', 'passwordTokenTime', 'roles_id'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $hidden = [
        'password', 'remember_token',
    ];

    //********** Validation Rules **********/  
    public static $loginRules =  [
        'email' => 'required|email',
        'password' => 'required'
    ];

    public static $registerRules = [
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|string|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).{8,}$/',
        'gender' => 'required'
    ];

    public static $editUserRules = [
        'id' => 'required'
    ];

    //********** Relations **********/  
    public function Roles()
    {
        return $this->belongsTo(Roles::class);
    }
    //********** Methods **********/  

    /*
     * @name:    getUserByEmail
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
     * * @description:   To return all Users having particular email
     */
    public static function getUserByEmail($email)
    {
        return User::where('email', '=', $email)->first();
    }
    /*
     * @name:    getUserById
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
     * * @description:   To return all Users having particular id
     */
    public static function getUserById($id)
    {
        return User::find($id);
    }
    /*
     * @name:    getUserById
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
     * * @description:   To return all Users having particular id
     */
    public static function getUserByActivationCode($activationcode)
    {
        return User::where('activationcode', '=', $activationcode)->first();
    }
    /*
     * @name:    addUser
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
     * * @description:   To create a new User
     */
    public static function addUser($data)
    {
        $userArray = [
            "name" => $data['name'],
            "email" => $data['email'],
            "status" => $data['status'],
            "password" => $data['password'],
            "type" =>  $data['type'],
            "gender" => $data['gender'],
            'activationcode' => $data['activationcode'],
            'roles_id' => $data['role']
        ];
        if($data['registeredBy'] == 'admin'){
            
            $userArray["designation"] = $data['designation'];
            $userArray["parent"] = $data['parent'];
        }
        // return $userArray;
        $user = User::create($userArray);
        return $user;
    }
    /*
     * @name:    getAllActiveUsers
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
     * * @description:   To return all Users having status 1 and  are of user type
     */
    public static function getAllActiveUsers()
    {
       return User::where('type', '=', 'user')->where('status', '=', 1)->with('roles')->get();
    }
    /*
     * @name:    updateUser
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
     * * @description:   To Update a user with given id
     */
    public static function updateUser($id, $data)
    {
        $user = User::findOrFail($id);
        return $user->update($data);
    }
    /*
     * @name:    getUserByParentId
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
     * * @description:   To return assigned users of given Id
     */
    public static function getUserByParentId($id)
    {
        return User::where('parent', '=', $id)->get();
    }
    public static function getCurrentUser($request)
    {
        $user = $request->user();
        $role = $user->Roles;
        $permission = $role->permissions;
        return $user;
    }
}
