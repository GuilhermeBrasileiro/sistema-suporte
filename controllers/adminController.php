<?php

    namespace controllers;

    class adminController{
        public function index(){
            \views\mainView::render('index-panel');
        }

        public function chamados(){
            \views\mainView::render('ticket-panel');
        }

        public function existeToken(){
            $token = $_GET['token'];
            $verifica = \MySql::conectar()->prepare("SELECT * FROM chamados WHERE token = ?");
            $verifica->execute(array($token));
            if($verifica->rowCount() == 1)
                return true;
            else
                return false;
        }

        public function getPergunta($token){
            $sql = \MySql::conectar()->prepare("SELECT * FROM chamados WHERE token = ?");
            $sql->execute(array($token));
            return $sql->fetch();
        }

        public function abrirChamado($info){
            \views\mainView::render('ticket-open',$info);
        }

        public function inventario(){
            \views\mainView::render('inventory');
        }
        
        public function usuarios(){
            \views\mainView::render('user');
        }

        public function error(){
            \views\mainView::render('404');
        }
    }

?>