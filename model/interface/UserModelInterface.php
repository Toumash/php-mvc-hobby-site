<?php


interface UserModelInterface
{
    function logIn($login, $password);

    function isLoggedIn();

    function logOut();

    function loginExists($login);

    function emailExists($email);

    function register($login, $password, $email);

    function getLoggedUser();
}