<?php

class LoginPasswordForm extends \OpenclerkForms\Form {

  function __construct() {
    $this->addEmail("email", "Email")->
      required("Email is required")->
      maxLength(255);

    $this->addPassword("password", "Password")->
      required("Password is required")->
      maxLength(255)->
      minLength(6);

    $this->addSubmit("login", "Login");

  }

  /**
   * The form has been submitted and is ready to be processed.
   * The user can be redirected from here if necessary, or
   * an exception can be thrown.
   * @return A success message if the form was successful
   * @throws Exception if the form could not be processed
   */
  function process($form) {

    $user = Users\UserPassword::tryLogin(db(), $form['email'], $form['password']);
    if ($user) {
      $user->persist(db());
      return "Logged in successfully";
    } else {
      throw new Exception("Incorrect email or password.");
    }

  }


}

$form = new LoginPasswordForm();
$form->check();   // may process the form right here right now

// page render
page_header("Login", "page_login");
require_template("login/password", array("form" => $form));

page_footer();
