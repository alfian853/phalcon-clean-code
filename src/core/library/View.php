<?php
/**
 * Created by PhpStorm.
 * User: falnerz
 * Date: 5/19/19
 * Time: 4:05 PM
 */

namespace Core\Library;


interface View
{
    function addVariables(array $variables) : View;
    function render() : View;
    function getContent() : string;
}