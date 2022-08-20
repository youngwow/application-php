<?php
namespace Boyarkin\App\Pages\Server\Api;

class Json
{
    public function index(){
        echo "<h1>JSON Page</h1>";
        $numargs = func_num_args();
        echo "Количество аргументов: $numargs\n";
        $arg_list = func_get_args();
        for ($i = 0; $i < $numargs; $i++) {
            echo "Аргумент №$i: " . $arg_list[$i] . "\n";
        }
    }
    public function commodities(){
        echo "<h1>Commodities Page</h1>";
        $numargs = func_num_args();
        echo "Количество аргументов: $numargs\n";
        $arg_list = func_get_args();
        for ($i = 0; $i < $numargs; $i++) {
            echo "Аргумент №$i: " . $arg_list[$i] . "\n";
        }
    }
}