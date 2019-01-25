<?php

class Vue {

    private $tpl_fic;
    private $tpl_var = array();

    public function __construct($action, array $values) {
        $this->tpl_fic = "tpl/$action.php";
        foreach ($values as $key => $val) {
            $this->setVar($key, $val);
        }
    }
    
    public function setVar($var_name, $value) {
        $this->tpl_var[$var_name] = $value;
    }

    public function generer() {
        $tpl_var = $this->tpl_var;
        include $this->tpl_fic;
        unset($tpl_var);
    }

}
