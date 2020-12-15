<?php

    namespace controllers;

    class loginController{
        public function index(){
            \views\mainView::render('login');
        }
    }
?>