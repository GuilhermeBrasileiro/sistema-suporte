<?php

    namespace controllers;

    class ticketController{
        public function index(){
            \views\mainView::render('ticket-new');
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
            \views\mainView::render('ticket-user-chat',$info);
        }
    }
?>