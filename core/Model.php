<?php

namespace app\core;
abstract class Model{
  public const RULE_REQUIRED = 'required';
  public const RULE_EMAIL = 'email';
  public const RULE_MIN = 'min';
  public const RULE_MAX = 'max';
  public const RULE_MATCH = 'match';
public array $errors = [];



    public function loadData($data){
        foreach($data as $key =>$value){
            if(property_exists($this,$key)){
                $this->{$key} = $value;
            }
        }
        

    }
    abstract public function rules():array;
    public function validate(){

        foreach($this->rules() as $attribute => $rules){
            $value = $this->{$attribute};
            foreach($rules as $rule){
                $rulename = $rule;

                if(!is_string($rulename)){
                    $rulename = $rule[0];
                }
                if($rulename === self::RULE_REQUIRED && !$value){
                    $this->addError($attribute,self::RULE_REQUIRED);

                }
                if ($rulename === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                }

            }

        }

        return empty($this->errors);


    }

    public function addError(string $attribute, string $rule){
        $message = $this->errorMessages()[$rule] ?? '';

        $this->errors[$attribute][]=$message;

    }

    public function errorMessages(){
        return[
             self::RULE_REQUIRED => 'This field isrequired',
             self::RULE_EMAIL => 'This is not valid email',
             self::RULE_MIN => 'Min length of this field must be {min}',
             self::RULE_MAX => 'Min length of this field must be {max}',
             self::RULE_MATCH => 'This field is not same as {match}',
        ];
    }
}
