<?php
    class ValidaCampos
    {
        public function validaEmail($email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return true;
            }
            else
                return false;
        }
        
        public function validaSenha($senha) {
            if (preg_match("#.*^(?=.{8,60})(?=.*[A-z])(?=.*[0-9]).*$#", $senha))
                return true;
            else 
                return false;
        }

        /*
         Impede o usuario de fazer 
        */
        public function validar($str) {
            $ret = $str;
            $ret = str_replace("'", "&#39;", "$ret");
            $ret = str_replace("<", "&lt;", "$ret");
            $ret = str_replace(">", "&gt;", "$ret");
            return $ret;
        }
        
    }