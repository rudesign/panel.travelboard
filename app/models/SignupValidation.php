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

        $this->add('city', new PresenceOf(array(
            'message' => 'Укажите город'
        )));

        $this->add('email', new PresenceOf(array(
            'message' => 'Укажите e-mail'
        )));

        $this->add('email', new Email(array(
            'message' => 'Укажите реальный e-mail'
        )));

        $this->add('password', new PresenceOf(array(
            'message' => 'Укажите пароль'
        )));

        $this->add('password', new Confirmation(
            array(
                'message'=>'Пароль и его подтверждение не совпадают',
                'with'=>'_password',
            )
        ));
    }
}
