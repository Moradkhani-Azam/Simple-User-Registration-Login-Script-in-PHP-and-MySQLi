<?php
namespace App\helpers;

class Validator
{
    private $_errors = [];


    public function validate($data, $rules = [] ) {

        foreach($data as $item => $item_value) {
            $item_value = $this->prepareValidation($item_value);
            if(key_exists($item, $rules)) {
                foreach($rules[$item] as $rule => $rule_value) {

                    if(is_int($rule))
                         $rule = $rule_value;

                    switch ($rule){
                        case 'required':
                        if(empty($item_value) && $rule_value){
                            $this->addError($item,ucwords($item). ' الزامی است.');
                            break 2;
                        }
                        break;

                        case 'minLen':
                        if(strlen($item_value) < $rule_value){
                            $this->addError($item, ucwords($item). ' کمترین تعداد کاراکتر باید '.$rule_value. ' باشد.');
                            break 2;
                        }       
                        break;

                        case 'maxLen':
                        if(strlen($item_value) > $rule_value){
                            $this->addError($item, ucwords($item). ' بیشترین تعداد کاراکتر باید '.$rule_value. ' باشد.');
                        }
                        break;

                        case 'numeric':
                        if(!ctype_digit($item_value) && $rule_value){
                            $this->addError($item, ucwords($item). ' باید از نوع عدد باشد.');
                            break 2;
                        }
                        break;

                        case 'string':
                        if(!is_string($item_value) && $rule_value) {
                            $this->addError($item, ucwords($item). ' باید از نوع رشته باشد.');
                            break 2;
                        }
                        break;

                        case 'alpha':
                        if(!ctype_alpha($item_value) && $rule_value){
                            $this->addError($item, ucwords($item). ' باید از نوع کاراکتر  الفبایی باشد.');
                            break 2;
                        }
                        break;

                        case 'email':
                        if(!filter_var($item_value, FILTER_VALIDATE_EMAIL && $rule_value)) {
                            $this->addError($item, ucwords($item). ' ایمیل نامعتبر است.');
                            break 2;
                        }
                        break;

                        case 'url':
                        if(!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$item_value) && $rule_value){
                            $this->addError($item, ucwords($item). ' لینک نامعتبر است.');
                        }
                    }
                }
            }
        }    
    }

    private function prepareValidation($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    private function addError($item, $error) {
        $this->_errors[$item][] = $error;
    }


    public function error() {
        if(empty($this->_errors)) return false;
        return $this->_errors;
    }
}