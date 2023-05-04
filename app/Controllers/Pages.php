<?php
namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pages extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view($page = 'home')
    {
        if (! is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            throw new PageNotFoundException($page);
        }

        $title = ($page=='msh') ? 'Review App Smart System MSH' : ucfirst($page);
        $data['title'] = $title; 
        $data['header_custom'] = '<script src="https://www.google.com/recaptcha/api.js?render='.getenv('GOOGLE_RECAPTCHAV3_SITEKEY').'"></script>';

        return view('templates/header', $data)
            . view('pages/' . $page)
            . view('templates/footer');
    }
    public function msh_action()
    {
        // Validation
        $input = $this->validate([
            'nama' => 'required',
            'url' => 'required',
            'review' => 'required',
            'picture' => 'required',
            'recaptcha_response' => 'required|verifyrecaptchaV3',
        ], [
            'recaptcha_response' => [
                'required' => 'Please verify captcha',
            ],
        ]);

        if (!$input) { // Not valid

            $data['validation'] = $this->validator;
            return redirect()->back()->withInput()->with('validation', $this->validator);
        } else {
            session()->setFlashdata('message', 'Request Submitted Successfully!');
            session()->setFlashdata('alert-class', 'alert-success');
        }
        return redirect()->route('/msh');
    }
}