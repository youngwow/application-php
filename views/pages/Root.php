<?php

namespace Boyarkin\App\Pages;

class Root
{
    public function index(){
        echo "<h1>Home Page</h1>";
        $numargs = func_num_args();
        echo "Количество аргументов: $numargs\n";
        $arg_list = func_get_args();
        for ($i = 0; $i < $numargs; $i++) {
            echo "Аргумент №$i: " . $arg_list[$i] . "\n";
        }
    }
    public function test(){
        echo "<h1>Test Page</h1>";
        $numargs = func_num_args();
        echo "Количество аргументов: $numargs\n";
        $arg_list = func_get_args();
        for ($i = 0; $i < $numargs; $i++) {
            echo "Аргумент №$i: " . $arg_list[$i] . "\n";
        }
    }

}