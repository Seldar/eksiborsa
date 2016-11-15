<?php
/**
 * Created by PhpStorm.
 * User: Ulukut
 * Date: 14.11.2016
 * Time: 16:06
 *
 * @author Volkan Ulukut <arthan@gmail.com>
 */

namespace Tsts\Controllers;


class AuthControllerTest extends \TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->seed('DatabaseSeeder');
    }


    public function testShowLoginForm()
    {
        $this->visit("login")
            ->assertResponseOk();
    }

    public function testLogin()
    {
        $this->post("login", ["email" => "test@gmail.com", "password" => "12345", '_token' => csrf_token()])
            ->followRedirects()
            ->see("Volkan Ulukut");
    }

    public function testFailedLogin()
    {
        $this->post("login", ["email" => "test@gmail.coma", "password" => "1", '_token' => csrf_token()])
            ->followRedirects()
            ->see("Register");
    }

    public function testRegister()
    {
        $this->visit("register")
            ->assertResponseOk();

        $this->post("register", [
            "name" => "tester",
            "email" => "test2@gmail.com",
            "password" => "123456",
            "password_confirmation" => "123456",
            "_token" => csrf_token()
        ])
            ->followRedirects()
            ->see("tester");
    }

    public function testRegisterFail()
    {
        $this->visit("register")
            ->assertResponseOk()
            ->see("Register");

        $this->post("register", [
            "name" => "",
            "email" => "",
            "password" => "12345",
            "password_confirmation" => "1234567",
            "_token" => csrf_token()
        ])
            ->followRedirects()
            ->see("Register");
    }

    public function testPasswordReset()
    {
        $this->visit("password/reset")
            ->assertResponseOk()
            ->see("Reset Password");
    }
}
