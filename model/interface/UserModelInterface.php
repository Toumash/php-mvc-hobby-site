<?php


interface UserModelInterface
{
    function logIn($login, $password);
    function isLoggedIn();
    function logOut();
    function loginExists($login);
    function register($login, $password, $email);
    function getLoggedUser();
}