<?php

use Phalcon\Validation,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\Email,
    Phalcon\Validation\Validator\Confirmation;

class SignupValidation extends Validation{

    public function initialize(){

        $this->add('name', new PresenceOf(array(
            'message' => 'Укажите имя'
        )));

        $this->add('email', new PresenceOf(array(
            'message' => 'The e-mail is required'
        )));

        $this->add('email', new Email(array(
            'message' => 'The e-mail is not valid'
        )));

        $this->add('password', new PresenceOf(array(
            'message' => 'Password is required'
        )));

        $this->add('password', new Confirmation(
            array(
                'message'=>'Пароль и его подтверждение не совпадают',
                'with'=>'_password',
            )
        ));
    }
}
