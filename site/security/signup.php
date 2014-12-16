<?php

class SignupPasswordForm extends \OpenclerkForms\Form {

  function __construct() {
    $this->addText("name", "Name")->
      required("Name is required")->
      maxLength(64);

    $this->addEmail("email", "Email")->
      required("Email is required")->
      maxLength(255);

    $this->addPassword("password", "Password")->
      required("Password is required")->
      maxLength(255)->
      minLength(6);

    $this->addPassword("password2", "Confirm password")->
      required("Confirm password is required")->
      equals("password");

    $this->addSubmit("signup", "Signup");

  }

  /**
   * @return a list of errors (key => value or key => array(values))
   *      or nothing if the form validates fine
   */
  function validate($form) {
    $result = array();

    // check db
    $q = db()->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
    $q->execute(array($form['email']));
    if ($q->fetch()) {
      $result['email'] = "That email address is in use.";
    }

    return $result;
  }

  /**
   * The form has been submitted and is ready to be processed.
   * The user can be redirected from here if necessary, or
   * an exception can be thrown.
   * @return A success message if the form was successful
   * @throws Exception if the form could not be processed
   */
  function process($form) {

    $user = Users\UserPassword::trySignup(db(), $form['email'], $form['password']);
    if ($user) {
      return "Signed up successfully";
      // could also redirect here
    } else {
      throw new Exception("Could not sign up");
    }

  }


}

$form = new SignupPasswordForm();
$form->check();   // may process the form right here right now

// page render
page_header("Login", "page_login");
require_template("signup/password", array("form" => $form));

page_footer();
