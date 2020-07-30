<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Mail\ForgetPasswordEmail;
use App\Mail\TestMail;
use App\Twilio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use DateInterval;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class UsersController extends Controller
{
    /*
     * @name:    login
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
     * * @description:   To authorize a particular user and return access token
     */
    public function login(Request $request)
    {
        $this->validate($request, User::$loginRules);
        $input = $request->all();
        $user = User::getUserByEmail($input['email']);


        if ($user) {
            $password = $user->password;
            if (Hash::check($input['password'], $password)) {
                $data['token'] =  $user->createToken('MyApp')->accessToken;

                if ($user->status == 0) {
                    $code = Helper::ERROR_EMAIL_NOT_VERIFIED;
                    return response(['error' => 1, 'message' =>  Helper::$errors[$code]]);
                } else {
                    if ($user->type == 'admin') {
                        $code = Helper::SUCCESS_LOGIN;
                        return response(['data' => $data, 'message' => Helper::$success[$code]]);
                    } else {
                        if ($user->parent !== null) {
                            $code = Helper::SUCCESS_LOGIN;
                            return response(['data' => $data, 'message' => Helper::$success[$code]]);
                        } else {
                            $code = Helper::ERROR_LOGIN_DESIGNATION;
                            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
                        }
                    }
                }
            } else {
                $code = Helper::ERROR_LOGIN_FAILED;
                return response(['error' => 1, 'message' => Helper::$errors[$code]]);
            }
        } else {
            $code = Helper::ERROR_LOGIN_FAILED;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }

    public function logout(Request $request)
    {

        $token = $request->user()->token();
        if ($token->revoke()) {
            $code = Helper::SUCCESS_LOGOUT;
            return response(['message' => Helper::$success[$code]]);
        }
    }

    /*
     * @name:    confirmEmail
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
 	* @description:   To verify user email address
     */
    public function confirmEmail($code)
    {
        $user = User::getUserByActivationCode($code);
        if ($user) {
            if ($user->status == 0) {
                if (User::where('id', $user->id)
                    ->update(['status' => 1])
                ) {
                    $code = Helper::SUCCESS_EMAIL_VERIFICATION;
                    return response(['message' => Helper::$success[$code]]);
                }
            } else {
                $code = Helper::ERROR_EMAIL_ALREADY_VERIFIED;
                return response(['error' => 1, 'message' =>  Helper::$errors[$code]]);
            }
        } else {
            $code = Helper::ERROR_NOT_FOUND;
            return response(['error' => 1, 'message' =>  Helper::$errors[$code]]);
        }
    }

    /*
     * @name:    register
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
 	* @description:   To register user 
     */

    public function register(Request $request)
    {
        $this->validate($request, User::$registerRules);
        $input = $request->all();
        $to = $input['name'];
        $activationcode =  md5($input['email'] . time());
        $input['activationcode'] = $activationcode;
        $input['password'] = Hash::make($input['password']);

        $user = User::addUser($input);
        $data['token'] =  $user->createToken('MyApp')->accessToken;

        Mail::to($input['email'])
            ->send(new TestMail($to, $activationcode));
        if ($user) {
            $code = Helper::SUCCESS_REGISTER;
            return response(['data' => $data, 'message' =>  Helper::$success[$code]]);
        } else {
            $code = Helper::ERROR_REGISTER_FAILED;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
    /*
     * @name:    showAllUsers
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
 	* @description:   To return all users 
     */

    public static function showAllUsers()
    {
        return User::getAllActiveUsers();
        // return response(User::getAllActiveUsers());
    }
    /*
     * @name:    getUserById
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
 	* @description:   To return user with particular id 
     */
    public function getUserById($id)
    {
        $user = User::getUserById($id);
        if ($user) {
            return response(['data' => $user, 'message' => 'User Found']);
        } else {
            return response(['error' => 1, 'message' => 'User Not Found']);
        }
    }
    /*
     * @name:    getCurrentUser
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
 	* @description:   To return current user 
     */
    public function getCurrentUser(Request $request)
    {
        $user = User::getCurrentUser($request);
        if ($user) {
            return response(['data' => $user, 'message' => 'User Found']);
        } else {
            return response(['error' => 1, 'message' => 'User Not Found']);
        }
    }
    /*
     * @name:    editUser
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
 	* @description:   To update user 
     */
    public function editUser(Request $request)
    {
        $this->validate($request, User::$editUserRules);
        $input = $request->all();
        $id = $input['id'];
        $user = User::updateUser($id, $request->all());
        if ($user) {
            return response(['message' => 'User Updated']);
        } else {
            return response(['error' => 1, 'message' => 'User Not Updated']);
        }
    }
    /*
     * @name:    getAssignedUsers
     * @author:    Sidra Ashfaq
     * @date:   07-2-2020
     * * @description:   To return assigned users of given Id
     */
    public static function getAssignedUsers($id)
    {
        $users = User::getUserByParentId($id);
        return $users;
        // return response($users, 200);
    }
    /*
     * @name:    forgetPassword
     * @author:    Sidra Ashfaq
     * @date:   07-11-2020
     * * @description:   when user click on update password this method is called in which email is generated and password token is updated
     */
    function forgetPassword(Request $request)
    {
        $email = $request->get('email');

        $user = User::getUserByEmail($email);

        if ($user) {
            $token = md5($email . time());
            Mail::to($email)
                ->send(new ForgetPasswordEmail($token, $user->id));

            $updatedUser = UsersController::updatePasswordToken($user->id, $token);
            if ($updatedUser) {
                $code = Helper::SUCCESS_FORGET_PASSWORD;
                return response(['message' =>  Helper::$success[$code]]);
            }
        } else {
            $code = Helper::ERROR_NOT_FOUND;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
    /*
     * @name:    forgetPassword
     * @author:    Sidra Ashfaq
     * @date:   07-11-2020
     * * @description:   when user click on update password this method is called in which email is generated and password token is updated
     */
    public static function updatePasswordToken($id, $token)
    {
        $date = date('Y-m-d H:i:s');
        $minutes_to_add = 15;
        $time = new DateTime($date);
        $time->add(new DateInterval('PT' . $minutes_to_add . 'M'));
        $stamp = $time->format('Y-m-d H:i:s');
        $updateDetails = array(
            'passwordToken' => $token,
            'passwordTokenTime' => $stamp
        );
        $updatedUser = User::updateUser($id, $updateDetails);
        return $updatedUser;
    }
    /*
     * @name:    checkPasswordToken
     * @author:    Sidra Ashfaq
     * @date:   07-11-2020
     * * @description:   after clicking email link to change password expiry time is checked
     */
    public function checkPasswordToken(Request $request)
    {
        $id = $request->get('id');
        $token = $request->get('token');
        $user = User::getUserById($id);
        if ($user) {
            $passwordToken = $user->passwordToken;
            if ($passwordToken == $token) {
                $passwordTokenTime = $user->passwordTokenTime;
                $currentdate = date('Y-m-d H:i:s');
                if ($currentdate < $passwordTokenTime) {

                    return response(['data' => $id, 'message' =>  "current time is less than token time "]);
                } else {
                    return response(['error' => 1, 'message' =>  "Your token has expired please request again to change password"]);
                }
            } else {
                $code = Helper::ERROR_PASSWORD_TOKEN_NOT_FOUND;
                return response(['error' => 1, 'message' => Helper::$errors[$code]]);
            }
        } else {
            $code = Helper::ERROR_NOT_FOUND;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
    /*
     * @name:    updatePassword
     * @author:    Sidra Ashfaq
     * @date:   07-11-2020
     * * @description:   Updated user Password
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, User::$loginRules);
        $id = $request->get('id');
        $password = $request->get('password');
        $passwordHash = Hash::make($password);
        $updateArray = array(
            'password' => $passwordHash
        );
        $updatedUser = User::updateUser($id, $updateArray);
        if ($updatedUser) {
            $code = Helper::SUCCESS_PASSWORD_UPDATE;
            return response(['message' => Helper::$success[$code]]);
        } else {
            $code = Helper::ERROR_USER_UPDATE;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
    public function sendMessage(Request $request)
    {
        $this->validate($request, [
            'message' => 'required'
        ]);
        $message = $request->get('message');


        $account_sid =  env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_AUTH_TOKEN');
        $twilio_number = env('TWILIO_SMS_FROM');
        $client = new Client($account_sid, $auth_token);
        $response = $client->messages->create(
            env('TWILIO_SMS_TO'),
            ['from' => $twilio_number, 'body' => $message]
        );

        if ($response) {
            $code = Helper::SUCCESS_MESSAGE_SEND;
            return response(['message' =>  Helper::$success[$code]]);
        } else {
            $code = Helper::ERROR_MESSAGE_SEND;
            return response(['error' => 1, 'message' => Helper::$errors[$code]]);
        }
    }
}
