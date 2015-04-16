<?php

class LanguageController extends \BaseController {

    public function language()
    {
        $language = Input::get('language');
        Session::put('language', $language);

        return Redirect::back();
    }
}
