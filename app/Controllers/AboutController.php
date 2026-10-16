<?php

class AboutController extends Controller
{
    public function index(): void
    {
        $this->view('about/index', [
            'page_title' => 'Giới Thiệu - ' . SITE_NAME,
        ]);
    }
}
