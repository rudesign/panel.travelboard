<?php

use Phalcon\Validation,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\Email;

class LoginValidation extends Validation{

    public function initialize(){

        $this->add('email', new PresenceOf(array(
        'message' => 'The e-mail is required'
        )));

        $this->add('email', new Email(array(
        'message' => 'The e-mail is not valid'
        )));

        $this->add('password', new PresenceOf(array(
            'message' => 'Password is required'
        )));
    }
}
