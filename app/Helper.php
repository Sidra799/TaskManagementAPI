<?php
namespace App;
class Helper{
//********** ERROR **************//
const ERROR_LOGIN_FAILED = 1;
const ERROR_NOT_FOUND = 2;
const ERROR_TOKEN_NOT_FOUND = 3;
const ERROR_EMAIL_ALREADY_VERIFIED = 4;
const ERROR_EMAIL_NOT_VERIFIED = 5;
const ERROR_EMAIL_ALREADY_EXIST = 6;
const ERROR_VERIFICATION_LINK_ALREADY_SENT = 7;
const ERROR_ATTEMPT_INVALID_LOGIN = 8;
const ERROR_COCKPIT_EMAIL_ALREADY_EXIST = 9;
const ERROR_TOKEN_EXPIRED = 10;
const ERROR_REGISTER_FAILED = 11;
const ERROR_USER_UPDATE = 12;
const ERROR_LOGIN_DESIGNATION=13;
const ERROR_PASSWORD_TOKEN_NOT_FOUND = 14;
const ERROR_PERMISSION_CREATE=15;
const ERROR_PERMISSION_FOUND=16;
const ERROR_ROLE_CREATE=17;
const ERROR_ROLE_FOUND=18;
const ERROR_ROLE_UPDATE = 19;
const ERROR_ROLE_DELETE = 20;
const ERROR_PERMISSION_DELETE=21;
const ERROR_MESSAGE_SEND = 22;

//********** ERROR **************//

public static $errors = [
    self::ERROR_LOGIN_FAILED => 'Failed to login, please try again',
    self::ERROR_REGISTER_FAILED => 'Failed to register, please try again',
    self::ERROR_NOT_FOUND => 'User not found',
    self::ERROR_TOKEN_NOT_FOUND => 'Invalid email verification token',
    self::ERROR_EMAIL_ALREADY_VERIFIED => 'Email is already confirmed',
    self::ERROR_EMAIL_NOT_VERIFIED => 'Email is not verified',
    self::ERROR_EMAIL_ALREADY_EXIST => 'This account already exists, try login from :login_link',
    self::ERROR_VERIFICATION_LINK_ALREADY_SENT => 'A verification link has already been sent to your email account',
    self::ERROR_ATTEMPT_INVALID_LOGIN => 'This account has been blocked for Invalid Login Attempts. Try \'Forgot Password\' to proceed',
    self::ERROR_COCKPIT_EMAIL_ALREADY_EXIST => 'This account already exists',
    self::ERROR_TOKEN_EXPIRED => 'Link has been expired',
    self::ERROR_USER_UPDATE => 'User not updated',
    self::ERROR_LOGIN_DESIGNATION => 'Designation not assigned',
    self::ERROR_PASSWORD_TOKEN_NOT_FOUND => 'Invalid Password Token',
    self::ERROR_PERMISSION_CREATE => "Permission not created successfully",
    self::ERROR_PERMISSION_FOUND => "Permission not Found",
    self::ERROR_ROLE_CREATE => "Role not created successfully",
    self::ERROR_ROLE_UPDATE => "Role not updated successfully",
    self::ERROR_ROLE_DELETE => "Role not deleted successfully",
    self::ERROR_PERMISSION_DELETE => "Permission not deleted successfully",
    self::ERROR_ROLE_FOUND => "Role not Found",
    self::ERROR_MESSAGE_SEND=> "Message sent successfully",
];

//********** SUCCESS **************//
const SUCCESS_LOGOUT	= 1;
const SUCCESS_LOGIN	= 2;
const SUCCESS_REGISTER    = 3;
const SUCCESS_EMAIL_VERIFICATION = 4;
const SUCCESS_COCKPIT_REGISTER    = 5;
const SUCCESS_FORGET_PASSWORD=6;
const SUCCESS_USER_UPDATE=7;
const SUCCESS_PASSWORD_UPDATE=8;
const SUCCESS_PERMISSION_CREATE=9;
const SUCCESS_PERMISSION_FOUND=10;
const SUCCESS_ROLE_CREATE=11;
const SUCCESS_ROLE_FOUND=12;
const SUCCESS_ROLE_UPDATE=13;
const SUCCESS_ROLE_DELETE=14;
const SUCCESS_PERMISSION_DELETE=15;
const SUCCESS_MESSAGE_SEND = 16;


//********** SUCCESS **************//

public static $success = [
    self::SUCCESS_LOGOUT              => "Successfully logged out",
    self::SUCCESS_LOGIN              => "Successfully logged in",
    self::SUCCESS_REGISTER            => "A verification link has been sent to your email account",
    self::SUCCESS_EMAIL_VERIFICATION  => "Your email address has been verified",
    self::SUCCESS_COCKPIT_REGISTER            => "User created successfully",
    self::SUCCESS_FORGET_PASSWORD => "A change password link has been sent to your email account",
    self::SUCCESS_USER_UPDATE => "User Updated",
    self::SUCCESS_PASSWORD_UPDATE => "Your password has heen updated",
    self::SUCCESS_PERMISSION_CREATE => "Permission created successfully",
    self::SUCCESS_PERMISSION_FOUND => "Permission  Found",
    self::SUCCESS_ROLE_CREATE => "Role created successfully",
    self::SUCCESS_ROLE_FOUND => "Role  Found",
    self::SUCCESS_ROLE_UPDATE => "Role updated successfully",
    self::SUCCESS_ROLE_DELETE => "Role deleted successfully",
    self::SUCCESS_PERMISSION_DELETE => "Permission deleted successfully",
    self::SUCCESS_MESSAGE_SEND=> "Message sent successfully",


];
}
