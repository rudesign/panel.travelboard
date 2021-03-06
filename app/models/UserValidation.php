<?php

use Phalcon\Validation,
    Phalcon\Validation\Validator\PresenceOf,
    Phalcon\Validation\Validator\Email;

class UserValidation extends Validation{

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
    }

    public function getMessage($messages){
        if (count($messages)) {
            $messages->rewind();

            return $messages->current()->getMessage();
        }else return null;
    }
}
