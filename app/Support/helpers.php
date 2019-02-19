<?php

if(!function_exists('str_one_spacing')) {
    /**
     * Удаляет все пробелы между словами, кроме одного и удаляет все переносы строк
     *
     * @param string $str
     * @return string
     */
    function str_one_spacing(string $str): string
    {
        $clear = str_replace("\n", "", $str);

        return preg_replace('#( +)#', ' ', $clear);
    }
}