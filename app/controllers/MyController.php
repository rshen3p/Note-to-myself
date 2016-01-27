<?php

class MyController extends BaseController
{

    public function greet()
    {
        return View::make('greet');
    }

}