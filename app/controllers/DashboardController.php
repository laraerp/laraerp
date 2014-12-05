<?php

class DashboardController extends BaseController {

    public function getIndex() {
        return View::make('dashboard');
    }

}
